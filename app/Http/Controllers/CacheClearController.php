<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;

class CacheClearController extends Controller
{
    public function clearCache()
    {
        // Clear Laravel's caches
        Artisan::call('cache:clear');
        Artisan::call('route:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
        Artisan::call('optimize:clear');

        return response()->json(['message' => 'Cache cleared successfully!']);
    }
}
