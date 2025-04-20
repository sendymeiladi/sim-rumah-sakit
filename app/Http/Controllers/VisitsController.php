<?php

namespace App\Http\Controllers;

use App\Http\Requests\PatientsCreateRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Visits;
use App\Models\Patients;
use App\Models\Regions;
use Yajra\DataTables\Facades\DataTables;
use Exception;

class VisitsController extends Controller
{
    public function index()
    {
        $regionsData = Regions::all();
        return view('visits.index', compact('regionsData'));
    }

    public function dataTable(): JsonResponse
    {
        $data = Visits::with('patients')->get();

        return DataTables::of($data)
        ->addColumn('aksi', function ($row) {
            return "<a href='#' data-id='$row->id' class='mdi mdi-trash-can text-danger btn-delete'></a>";
        })
        ->addColumn('nama', function (Visits $visits) {
            return $visits->patients->name;
        })
        ->rawColumns(['aksi', 'nama'])
        ->toJson();
    }

    public function store(PatientsCreateRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            $patient = Patients::create($data);

            $visit = Visits::create([
                'patient_id' => $patient->id,
                'type' => 'baru',
            ]);

            return response()->json(
                data: ['message' => 'Data berhasil di tambahkan'],
                status: 201
            );

        } catch (Exception $exception) {
            return response()->json(
                data: ['message' => $exception->getMessage()],
                status: 400
            );
        }

    }

    public function delete($id): JsonResponse
    {
        $visits = Visits::find($id);

        if (!$visits) {
            return response()->json(['message' => 'Data kunjungan tidak ditemukan'], 404);
        }

        $visits->delete();

        return response()->json(['message' => 'Data kunjungan berhasil dihapus'], 200);
    }
}
