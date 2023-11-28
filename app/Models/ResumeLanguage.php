<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResumeLanguage extends Model
{
    use HasFactory;

    protected $fillable = [
        'resumeId',
        'language',
        'level',
    ];

    ///////////////////////////
    ///      Relations      ///
    ///////////////////////////

    public function resume()
    {
        return $this->belongsTo(Resume::class, 'resumeId');
    }
}
