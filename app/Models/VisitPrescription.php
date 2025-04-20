<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitPrescription extends Model
{
    use HasFactory;
    protected $table = 'visit_prescription';

    protected $fillable = [
        'visit_id',
        'medicine_id',
        'quantity',
        'usage_instructions',
    ];

    public function visit()
    {
        return $this->belongsTo(Visits::class, 'visit_id');
    }

    public function medicine()
    {
        return $this->belongsTo(Medicines::class, 'medicine_id');
    }
}
