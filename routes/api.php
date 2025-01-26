<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\subadminAPIcontroller;
use App\Http\Controllers\userAPIcontroller;
use App\Http\Controllers\adminAPIcontroller;
use App\Http\Controllers\VotersAPIController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// login LoginVerification

Route::post('verifylogin', [VotersAPIController::class, 'verifylogin']);
Route::post('updateaccount', [VotersAPIController::class, 'updateaccount']);
Route::post('verifyFingerprint', [VotersAPIController::class, 'verifyFingerprint']);
Route::get('verifyOTP', [VotersAPIController::class, 'verifyOTP']);

Route::get('voting_start', [userAPIcontroller::class, 'voting_start']);
Route::get('dashboardChart', [userAPIcontroller::class, 'dashboardChart']);
Route::get('realtime_result', [userAPIcontroller::class, 'realtime_result']);
Route::get('isVoted', [userAPIcontroller::class, 'isVoted']);
Route::get('hasVoting', [userAPIcontroller::class, 'hasVoting']);

// subadmin
Route::get('update_election', [subadminAPIcontroller::class, 'update_election']);
Route::get('realtimedata', [subadminAPIcontroller::class, 'realtimedata']);
Route::get('realtime_tbl', [subadminAPIcontroller::class, 'realtime_tbl']);
Route::get('realtime_chart', [subadminAPIcontroller::class, 'realtime_chart']);
Route::get('voters', [subadminAPIcontroller::class, 'voters']);
Route::get('voterbygender', [subadminAPIcontroller::class, 'voterbygender']);
Route::get('voterbycourse', [subadminAPIcontroller::class, 'voterbycourse']);
Route::get('candidate_vote_info', [subadminAPIcontroller::class, 'candidate_vote_info']);

// admin
Route::get('realtime_card', [adminAPIcontroller::class, 'realtime_card']);
Route::get('realtime_org_election', [adminAPIcontroller::class, 'realtime_org_election']);
Route::get('myaccount', [adminAPIcontroller::class, 'myaccount']);
Route::get('checkIfstarted', [adminAPIcontroller::class, 'checkIfstarted']);