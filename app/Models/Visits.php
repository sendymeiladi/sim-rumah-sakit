<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visits extends Model
{
    use HasFactory;
    protected $table = 'visits';

    protected $fillable = [
        'patient_id',
        'visit_type',
        'visit_date',
        'treatment_id',
    ];


    public function patients()
    {
        return $this->belongsTo(Patients::class, 'patient_id');
    }
    public function treatments()
    {
        return $this->belongsTo(Treatments::class, 'treatment_id');
    }

    public function prescriptions()
    {
        return $this->hasMany(VisitPrescription::class, 'visit_id');
    }

    public function visitBill()
    {
        return $this->hasOne(VisitBill::class, 'visit_id');
    }

}
