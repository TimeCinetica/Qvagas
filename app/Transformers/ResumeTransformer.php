<?php

namespace App\Transformers;

use App\Models\Resume;

class ResumeTransformer extends BaseTransformer
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        //
    ];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'companies',
        'languages',
        'vacancyType',
        'occupations',
        'status'
    ];

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Resume $resume)
    {
        return [
            'id'                => (int) $resume->id,
            'linkedin'          => $resume->linkedin,
            'lattes'            => $resume->lattes,
            'video'             => $resume->video,
            'salary'            => $resume->salary,
            'typeWorking'       => (int) $resume->typeWorking,
            'typeContract'      => (int) $resume->typeContract,
            'courses'           => $resume->courses,
            'firstJob'          => $resume->firstJob,
            'unemployedTime'    => $resume->unemployedTime,
            'laborActivity'     => $resume->laborActivity,
            'targetJob'         => $resume->targetJob,
            'lastSalary'        => $resume->lastSalary,
            'abstract'          => $resume->abstract,
            'reference'         => $resume->reference,
            'userId'            => (int) $resume->userId,
            'resumePhoto'       => $this->formatFileUrl($resume->resumePhoto),
            'recomendationPhoto' => $this->formatFileUrl($resume->recomendationPhoto),
            'vacancyTypeId'     => (int) $resume->vacancyTypeId,
            'statusId'          => (int) $resume->statusId,
            'publicCurriculum'  => (int) $resume->publicCurriculum,
        ];
    }

    /**
     * 
     */
    public function includeCompanies(Resume $resume)
    {
        if (!isset($resume->companies)) {
            return null;
        }

        return $this->collection($resume->companies, new ResumeCompanyTransformer());
    }

    /**
     * 
     */
    public function includeLanguages(Resume $resume)
    {
        if (!isset($resume->languages)) {
            return null;
        }

        return $this->collection($resume->languages, new ResumeLanguageTransformer());
    }

    /**
     * 
     */
    public function includeVacancyType(Resume $resume)
    {
        if (!isset($resume->vacancyType)) {
            return null;
        }

        return $this->item($resume->vacancyType, new IdNameTransformer());
    }

    /**
     * 
     */
    public function includeOccupations(Resume $resume)
    {
        if (!isset($resume->occupations)) {
            return null;
        }

        return $this->collection($resume->occupations, new IdNameTransformer());
    }

    /**
     * 
     */
    public function includeStatus(Resume $resume)
    {
        if (!isset($resume->status)) {
            return null;
        }

        return $this->item($resume->status, new ResumeStatusTransformer());
    }
}
