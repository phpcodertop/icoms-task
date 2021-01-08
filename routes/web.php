<?php

use App\Http\Controllers\CountryTaskController;
use App\Http\Controllers\PdfTaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/company/users', [ CountryTaskController::class,'getCompanyUsers']);
Route::get('/user/company', [ CountryTaskController::class,'getUserCompanies']);


Route::post('/upload', [ PdfTaskController::class,'process']);
