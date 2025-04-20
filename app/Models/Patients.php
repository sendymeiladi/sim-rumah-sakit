<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patients extends Model
{
    use HasFactory;

    protected $table = 'patients';

    protected $fillable = [
        'name',
        'nik',
        'birth_date',
        'gender',
        'address',
        'region_id',
        'phone'
    ];

    public function regions()
    {
        return $this->belongsTo(Regions::class, 'region_id');
    }

}

