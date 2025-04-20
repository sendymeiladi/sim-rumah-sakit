<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    use HasFactory;
    protected $table = 'employees';

    protected $fillable = [
        'nip',
        'name',
        'position',
        'joined_date',
        'phone',
        'address',
    ];
}
