<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomProductController;
use App\Http\Controllers\CustomDesignController;

// Custom Products and Designs - V2 API to avoid web.php conflicts
Route::middleware('web')->prefix('v2')->group(function () {
    Route::get('/customproducts', [CustomProductController::class, 'index']);
    Route::get('/customproducts/{id}', [CustomProductController::class, 'show']);
    Route::get('/customproducts/{id}/designer-data', [CustomProductController::class, 'getDesignerData']);

    // Designs
    Route::post('/designs/save', [CustomDesignController::class, 'store']);
    Route::post('/designs/export-image', [CustomDesignController::class, 'uploadExport']);
    Route::post('/designs/upload-image', [CustomDesignController::class, 'uploadUserImage']); 
    Route::get('/designs/my/all', [CustomDesignController::class, 'myDesigns']);
    Route::get('/designs/{id}', [CustomDesignController::class, 'show']);
    Route::delete('/designs/{id}', [CustomDesignController::class, 'destroy']);
});
