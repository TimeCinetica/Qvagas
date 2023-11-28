<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class AssetService
{
    /**
     * @param File $image
     * @param User $user
     * @return void
     */
    public function updateUserPhoto($image, $user)
    {
        if (isset($image)) {
            $path = Storage::putFile('user', $image);
            $user->update([
                'photo' => $path
            ]);
        }
    }

    /**
     * @param File $image
     * @param User $user
     * @return void
     */
    public function updatePcdReport($image, $user)
    {
        if (isset($image)) {
            $path = Storage::putFile('reports', $image);
            $user->update([
                'pcdReport' => $path
            ]);
        }
    }

    /**
     * @param File $resumePhoto
     * @param File $recumendationPhoto
     * @param Resume $resume
     * @return void
     */
    public function updateResumePhotos($resumePhoto, $recomendationPhoto, $resume)
    {
        $resumePath = null;
        $recomendationPath = null;

        if (isset($resumePhoto)) {
            $resumePath = Storage::putFile('resume', $resumePhoto);
        }

        if (isset($recomendationPhoto)) {
            $recomendationPath = Storage::putFile('recomendation', $recomendationPhoto);
        }

        $resume->update([
            'resumePhoto' => $resumePath,
            'recomendationPhoto' => $recomendationPath
        ]);
    }

    /**
     * @param string $resource
     * @param string $filename
     */
    public function getPath($resource, $filename)
    {
        return storage_path('app/' . $resource . '/' . $filename);
    }
}
