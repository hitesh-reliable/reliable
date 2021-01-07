<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\PollController;

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
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

$prefix = 'v1';
/**
 *
 * All Api without Authantication
 *
 */
Route::group(['prefix' => $prefix], function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

/**
 *
 * All Authorised Api Will Access Using This Group
 *
 */
Route::group(['middleware' => ['auth:api'], 'prefix' => $prefix], function () {
    Route::post('/create-poll', [PollController::class, 'createPoll']);
    Route::get('/poll-detail/{id}', [PollController::class, 'pollDetail']);
    Route::post('/poll-voting', [PollController::class, 'pollVoting']);
    Route::get('/poll-result/{id}', [PollController::class, 'pollResult']);
    Route::get('/all-polls', [PollController::class, 'allPolls']);
});
