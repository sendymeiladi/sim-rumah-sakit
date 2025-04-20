<?php

namespace App\Jobs;

use App\Models\HistoryButton;
use Illuminate\Contracts\Container\BindingResolutionException;
use VladimirYuldashev\LaravelQueueRabbitMQ\Queue\Jobs\RabbitMQJob;
use Illuminate\Support\Facades\Log;
use App\Models\Device;
use App\Models\EmergencyState;
use PhpMqtt\Client\Facades\MQTT;



class SensorJob extends RabbitMQJob
{
    /**
     * @throws BindingResolutionException
     */
    public function fire(): void
    {
        $anyMessage = $this->getRawBody();
        $data = json_decode($anyMessage, true);

        Log::info('Job dijalankan', ['data' => $data]);

         // Validasi data
         if (!isset($data['code_device'], $data['time'])) {
            Log::error('Data tidak lengkap', ['data' => $data]);
            $this->delete(); // Hapus job jika data tidak valid
            return;
        }

        $device = Device::with('residentialBlock.residential')->where('code_device', $data['code_device'])->first();
        if (!$device) {
            Log::error('Device tidak ditemukan', ['data' => $data]);
            $this->delete(); // Hapus job jika device tidak ditemukan
            return;
        }
        $residential = $device->residentialBlock->residential->name;
        $address = $device->residentialBlock->name_block . ' No.' . $device->house_number;

        $dataPublish = [
            'residential' => $residential,
            'address' => $address,
            'state' => "1",
        ];


        if($data['state'] != '1') {
            $dataPublish['state'] = '0';
            $jasonData = json_encode($dataPublish);
            $this->delete(); // Hapus job jika device tidak ditemukan
            MQTT::publish('alarmSubscribe', $jasonData);
            return;
        }

        try {
            EmergencyState::query()->create([
                'id_device' => $device->id,
                'status' => 'Darurat',
                'epoch_time' => $data['time'],
            ]);
            $this->delete(); // Hapus job jika berhasil
            $jasonData = json_encode($dataPublish);
            MQTT::publish('alarmSubscribe', $jasonData);
        } catch (\Exception $e) {
            Log::error('Error ketika menyimpan data ke tabel Device', [
                'error' => $e->getMessage(),
                'data' => $data
            ]);
            $this->delete(); // Hapus job jika berhasil
        }
            // $this->delete(); // Hapus job jika berhasil

    }


    /**
     * Summary of getName
     */
    public function getName(): string
    {
        return '';
    }
}
