<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Notifications\Notifiable;

class Student extends Model
{
    // use HasFactory, Notifiable;

    protected $table = 'student_info';
    public $timestamps = false;
    
    protected $fillable = [
        'student_name',
        'student_roll',
        'student_reg',
        'student_session',
        'student_department',
        'student_email',
        'student_phone',
        'student_fingerprint',
        'student_password'
    ];
}