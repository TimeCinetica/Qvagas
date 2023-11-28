<?php

namespace App\Transformers;

use App\Models\ResumeCompany;

class ResumeCompanyTransformer extends BaseTransformer
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
        //
    ];

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(ResumeCompany $resumeCompany)
    {
        return [
            'id'                => (int) $resumeCompany->id,
            'companyName'       => $resumeCompany->companyName,
            'companyActivity'   => $resumeCompany->companyActivity,
            'companyStart'      => $this->formatDate($resumeCompany->companyStart),
            'companyEnd'        => $this->formatDate($resumeCompany->companyEnd),
            'companyLeftReason' => $resumeCompany->companyLeftReason,
            'resumeId'          => (int) $resumeCompany->resumeId,
            'actualJob'         => $resumeCompany->actualJob
        ];
    }
}
