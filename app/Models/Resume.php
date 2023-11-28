<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resume extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'linkedin',
        'lattes',
        'video',
        'typeOfVacancy',
        'salary',
        'typeWorking',  // Tipo de jornada de trabalho
        'typeContract', // Tipo de contrato
        'courses',
        'firstJob',
        'unemployedTime',
        'laborActivity',
        'targetJob',
        'lastSalary',
        'resume',
        'reference',
        'userId',
        'resumePhoto',
        'recomendationPhoto',
        'vacancyTypeId', // Tpo de vaga
        'statusId',
        'publicCurriculum',
        'abstract',
        'lastUpdate'
    ];


    ///////////////////////////
    ///      Relations      ///
    ///////////////////////////

    /**
     * 
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }

    /**
     * 
     */
    public function companies()
    {
        return $this->hasMany(ResumeCompany::class, 'resumeId');
    }

    /**
     * 
     */
    public function languages()
    {
        return $this->hasMany(ResumeLanguage::class, 'resumeId');
    }

    /**
     * 
     */
    public function vacancyType()
    {
        return $this->belongsTo(VacancyType::class, 'vacancyTypeId');
    }

    /**
     * 
     */
    public function occupations()
    {
        return $this->belongsToMany(Occupation::class, 'resume_occupations', 'resumeId', 'occupationId');
    }

    /**
     * 
     */
    public function status()
    {
        return $this->belongsTo(ResumeStatus::class, 'statusId');
    }
}
