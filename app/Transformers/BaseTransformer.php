<?php

namespace App\Transformers;

use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

abstract class BaseTransformer extends TransformerAbstract
{
    /**
     * 
     */
    protected function formatDate($date)
    {
        if (!isset($date)) {
            return null;
        }

        return Carbon::parse($date)->format('d/m/Y');
    }

    /**
     * 
     */
    protected function formatFileUrl($path)
    {
        if (!isset($path)) {
            return null;
        }

        return env('APP_URL') . '/files/' . $path;
    }
}
