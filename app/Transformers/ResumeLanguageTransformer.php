<?php

namespace App\Transformers;

use App\Models\ResumeLanguage;
use League\Fractal\TransformerAbstract;

class ResumeLanguageTransformer extends TransformerAbstract
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
    public function transform(ResumeLanguage $resumeLanguage)
    {
        return [
            'id'            => (int) $resumeLanguage->id,
            'language'      => $resumeLanguage->language,
            'level'         => (int) $resumeLanguage->level,
            'resumeId'      => (int) $resumeLanguage->resumeId
        ];
    }
}
