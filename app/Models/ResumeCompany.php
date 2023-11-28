<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResumeCompany extends Model
{
    use HasFactory;

    protected $fillable = [
        'companyName',
        'companyActivity',
        'companyStart',
        'companyEnd',
        'companyLeftReason',
        'resumeId',
        'actualJob'
    ];

    ///////////////////////////
    ///      Relations      ///
    ///////////////////////////

    public function resume()
    {
        return $this->belongsTo(Resume::class, 'resumeId');
    }
}
