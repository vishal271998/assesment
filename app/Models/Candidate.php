<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    protected $table = 'candidates';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'contact_number',
        'gender',
        'specialization',
        'work_ex_year',
        'candidate_dob',
        'address',
        'resume',
    ];
}
