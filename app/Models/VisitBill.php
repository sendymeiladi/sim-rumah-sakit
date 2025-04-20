<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitBill extends Model
{
    use HasFactory;
    protected $table = 'Visit_bill';

    protected $fillable = [
        'visit_id',
        'total',
        'payment_date',
        'usage_instructions',
    ];

}
