<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\API\RolApiController;
use App\Http\Controllers\API\ClubesApiController;
use App\Http\Controllers\API\AcampantesApiController;
use App\Http\Controllers\API\DistritosApiController;
use App\Http\Controllers\API\TotalesClubApiController;
use App\Http\Controllers\API\PdfApiController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('login', [AuthController::class,"login"]);

Route::post('signup', [AuthController::class,"signup"]);



Route::group([
  'middleware' => 'auth:api'
], function() {
 // Route::get('clubes/{club_id}/acampantes', [AcampantesApiController::class, 'indexByClub']);

 Route::get('Clubes/{club_id}/acampantes', [AcampantesApiController::class, 'indexByClub']);

  Route::post('/clubes/{club_id}/acampantes', [AcampantesApiController::class, 'store']);
  Route::get('/acampantes/{id}', [AcampantesApiController::class, 'show']);

  Route::delete('/acampantes/{id}', [AcampantesApiController::class, 'destroy']);

  Route::put('clubes/{club_id}/acampantes/{acampante_id}', [AcampantesApiController::class, 'update']);

  Route::get('descargar-excel/{club_id}', [AcampantesApiController::class, 'descargarExcel']);

  Route::get('descargar-PDF/{club_id}', [AcampantesApiController::class, 'descargarPDF']);



  //Route::get('/pdfs', [PdfApiController::class, 'index']);

  Route::get('/pdfs', [PdfApiController::class, 'index']);
  Route::post('/pdfs/{clubId}/upload', [PdfApiController::class, 'upload']);


  Route::get('/pdfs/download/{id}', [PdfApiController::class, 'download']);

  Route::delete('/pdfs/{id}', [PdfApiController::class, 'destroy']);

  Route::get('/obtener-total-acampantes', [AcampantesApiController::class, 'getTotalAcampantes']);
  

  
  Route::get('/Clubes/{clubId}/calcular-totales', [TotalesClubApiController::class, 'calcularTotales']);

  
  Route::group(['middleware' => ['role:Administrator']], function () {
    //Route::get('descargar-excel/{club_id}', [AcampantesApiController::class, 'descargarExcel']);
    });



  // Luego define las rutas de apiResource a nivel más general
  Route::apiResource('Clubes', ClubesApiController::class);
  Route::apiResource('Acampantes', AcampantesApiController::class);
  Route::apiResource('Distritos', DistritosApiController::class);
});

    
    








Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
