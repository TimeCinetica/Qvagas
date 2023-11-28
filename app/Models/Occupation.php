<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Occupation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'code'
    ];

    ///////////////////////////
    ///      Relations      ///
    ///////////////////////////

    public function resumes()
    {
        return $this->belongsToMany(Resume::class, 'resume_occupations', 'occupationId', 'resumeId');
    }
}
