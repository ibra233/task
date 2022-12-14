<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\IndustryController;
use App\Http\Controllers\IndustryOfCompaniesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('admin')->group(function () {
    Route::get('/', function () {
        return view('welcome');
    })->name('welcome');
    Route::resource('industry', IndustryController::class)->only([
        'index', 'store', 'update', 'destroy',
    ]);
    Route::resource('company', CompanyController::class)->only([
        'index', 'store', 'update', 'destroy',
    ]);
    Route::resources(['employee' => EmployeeController::class]);
    Route::post('company/update/{id}', [CompanyController::class, 'updateCompany']);
    Route::delete('industryOfCompany/{companyId}/{industryId}', [IndustryOfCompaniesController::class, 'delete']);
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
});

Route::get('/lang/{lang}', function ($lang) {
    session()->put('locale', $lang);

    return back();
})->name('language');

Route::view('/login', 'login');
Route::post('/login', [AuthController::class, 'login'])->name('login');
