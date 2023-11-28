<?php

namespace App\Http\Controllers\Asset;

use App\Http\Controllers\Controller;
use App\Services\AssetService;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    protected $assetService;

    public function __construct(AssetService $assetService)
    {
        $this->assetService = $assetService;
    }

    /**
     * 
     */
    public function show($resource, $filename)
    {
        $path = $this->assetService->getPath($resource, $filename);
        return response()->file($path);
    }
}
