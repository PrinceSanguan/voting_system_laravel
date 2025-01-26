<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\pageController;
use App\Http\Controllers\subadminController;
use App\Http\Controllers\adminController; 
use App\Http\Controllers\AccountController; 
use App\Http\Controllers\userController; 
use App\Http\Middleware\hasfingerprint;
use App\Http\Middleware\SubadminIsValid;
use App\Http\Middleware\verifyMiddleware;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// pageController subadmin
Route::get('subadmin/Dashboard', [pageController::class, 'subadmin_index_page'])
    ->name('subadmin.index')->middleware(SubadminIsValid::class);

Route::get('subadmin/position', [pageController::class, 'subadmin_position_page'])
    ->name('subadmin.position')->middleware(SubadminIsValid::class);

Route::get('subadmin/partylist', [pageController::class, 'subadmin_partylist_page'])
    ->name('subadmin.partylist')->middleware(SubadminIsValid::class);

Route::get('subadmin/candidates', [pageController::class, 'subadmin_candidates_page'])
    ->name('subadmin.candidates')->middleware(SubadminIsValid::class);

Route::get('subadmin/voter-list', [pageController::class, 'subadmin_voterlist_page'])
    ->name('subadmin.voter-list')->middleware(SubadminIsValid::class);

Route::get('subadmin/election', [pageController::class, 'subadmin_election_page'])
    ->name('subadmin.election')->middleware(SubadminIsValid::class);

Route::get('subadmin/election_type', [pageController::class, 'subadmin_election_type'])
    ->name('subadmin.election_type')->middleware(SubadminIsValid::class);

Route::get('subadmin/candidate', [pageController::class, 'to_candidate'])
    ->name('subadmin.to_candidate')->middleware(SubadminIsValid::class);

Route::get('subadmin-result', [pageController::class, 'to_view_result'])
    ->name('subadmin.to_result')->middleware(SubadminIsValid::class);

Route::get('subadmin/change-account', [pageController::class, 'subadmin_change_account'])
    ->name('subadmin.change-account')->middleware(SubadminIsValid::class);

Route::get('subadmin/voters-turnout', [pageController::class, 'subadmin_voters_turnout'])
    ->name('subadmin.voters-turnout')->middleware(SubadminIsValid::class);
// end

// pageController admin
Route::get('administrator', [pageController::class, 'admin_index_page'])
    ->name('admin.index')->middleware(hasfingerprint::class);

Route::get('administrator/organization', [pageController::class, 'admin_organization_page'])
    ->name('admin.organization')->middleware(hasfingerprint::class);

Route::get('administrator/organizations-account', [pageController::class, 'admin_organization_account_page'])
    ->name('admin.organization.account')->middleware(hasfingerprint::class);

Route::get('administrator/elections', [pageController::class, 'administrator_elections_per_org'])
    ->name('administrator-election-per-org')->middleware(hasfingerprint::class);

Route::get('administrator/update-account', [pageController::class, 'admin_update_account'])
    ->name('admin.update-account')->middleware(hasfingerprint::class);
// end

// pageController students
Route::get('user/dashboard', [pageController::class, 'user_index_page'])
    ->name('voter.index')->middleware(verifyMiddleware::class);
Route::get('user/info', [pageController::class, 'user_info_page'])
    ->name('voter.info')->middleware(verifyMiddleware::class);
// end

Route::get('otp', [pageController::class, 'otp']);
Route::post('verify-otp', [subadminController::class, 'verify_otp'])->name('verify.otp');

// subadminController
Route::post('add-position', [subadminController::class, 'subadmin_add_position'])
    ->name('add.position');
Route::post('update-position', [subadminController::class, 'subadmin_update_position'])
->name('update.position');

Route::post('add-partylist', [subadminController::class, 'subadmin_add_partylist'])
    ->name('add.partylist');

Route::post('add-candidate/', [subadminController::class, 'subadmin_add_candidate'])
    ->name('add.candidate');

Route::post('add-voters', [subadminController::class, 'subadmin_add_voter'])
    ->name('add.voter');

Route::post('add-election', [subadminController::class, 'subadmin_add_election'])
    ->name('add.election');

Route::get('subadmin/action/delete', [subadminController::class, 'subadmin_action_delete'])
    ->name('subadmin.action.delete')->middleware(SubadminIsValid::class);

Route::get('subadmin/delete', [subadminController::class, 'action_delete_voters'])
    ->name('action.delete.voters')->middleware(SubadminIsValid::class);

Route::get('subadmin/action/delete/candidates', [subadminController::class, 'subadmin_action_delete_candidates'])
    ->name('subadmin.action.delete.candidates')->middleware(SubadminIsValid::class);

Route::get('subadmin/view/candidate', [subadminController::class, 'subadmin_view_candidate'])
    ->name('candidate.position')->middleware(SubadminIsValid::class);

Route::get('subadmin/activate-vote', [subadminController::class, 'vote_action'])
    ->name('subadmin.vote.action')->middleware(SubadminIsValid::class);

Route::get('subadmin/view-result', [subadminController::class, 'view_result'])
    ->name('view_result')->middleware(SubadminIsValid::class);

Route::get('subadmin/print-report', [subadminController::class, 'print'])
    ->middleware(SubadminIsValid::class);
// end

// adminController
Route::post('add-organization', [adminController::class, 'admin_add_organization'])
    ->name('add.organization');

Route::post('add-organization-account', [adminController::class, 'admin_organization_account'])
    ->name('add.organization.account');

Route::get('administrator/view-result', [adminController::class, 'view_result'])
    ->middleware(hasfingerprint::class);

Route::post('administrator/updatemyaccount', [adminController::class, 'update_account'])
    ->name('admin-update-mydata');

Route::get('administrator/action-delete', [adminController::class, 'action_delete'])
->name('admin.action.delete');
// end

// userController
Route::post('submit-vote', [userController::class, 'submit_vote'])
    ->name('submit.vote');
Route::post('update-voters-data', [userController::class, 'update_data'])
    ->name('update-voters-data');
// end

// AccountController

Route::get('webview', [AccountController::class, 'webview']);

Route::post('admin/register', [AccountController::class, 'reg_admin'])
    ->name('reg-admin');

Route::post('auth-login', [AccountController::class, 'auth_login'])
    ->name('auth.login');

Route::post('register-voter', [AccountController::class, 'register_voter'])
    ->name('register.voter');

Route::post('ChangePassword', [AccountController::class, 'ChangePassword'])
    ->name('ChangePassword');

Route::get('logout', [AccountController::class, 'logout'])
    ->name('logout');

Route::get('user-logout', [AccountController::class, 'user_logout'])
    ->name('user.logout');
// end

// Authentication page
// Route::middleware()
Route::get('/', [pageController::class, 'login_page']);
Route::get('/admin', [pageController::class, 'login']);
Route::get('/register', [pageController::class, 'register'])->name('page.register');
Route::get('/administrator/register', [pageController::class, 'reg_administrator'])
    ->name('page.reg.Administrator');

Route::post('LoginVerification', [AccountController::class, 'LoginVerification'])
    ->name('LoginVerification');
    
Route::post('change-password', [AccountController::class, 'changepass'])
    ->name('change-pass');