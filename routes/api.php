<?php

use App\Http\Controllers\DeviceController;
use Illuminate\Http\Request;
use App\Models\HistoryButton;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegionsController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\TreatmentsController;
use App\Http\Controllers\MedicinesController;
use App\Http\Controllers\VisitsController;
use App\Http\Controllers\PatientsController;
use App\Http\Controllers\VisitTreatmentController;
use App\Http\Controllers\VisitPrescriptionController;
use App\Http\Controllers\VisitBillController;
use App\Http\Controllers\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::middleware(['auth:sanctum'])->as('api.')->group(function () {
    Route::middleware(['role.access:Admin,Petugas'])->group(function () {
        Route::get('/visits', [VisitsController::class, 'dataTable'])->name('visits.dataTable');
        Route::post('/visits', [VisitsController::class, 'store'])->name('visits.store');
        Route::delete('/visits/{id}', [VisitsController::class, 'delete'])->name('visits.delete');

        Route::get('/patients', [PatientsController::class, 'dataTable'])->name('patients.dataTable');
        Route::post('/patients/visit', [PatientsController::class, 'visit'])->name('patients.visit');
    });
    Route::middleware(['role.access:Admin,Dokter'])->group(function () {
        Route::get('/visit-treatment', [VisitTreatmentController::class, 'dataTable'])->name('visitTreatment.dataTable');
        Route::get('/visit-treatment/{id}', [VisitTreatmentController::class, 'show'])->name('visitTreatment.show');
        Route::put('/visit-treatment/{id}', [VisitTreatmentController::class, 'update'])->name('visitTreatment.update');

        Route::get('/visit-prescription', [VisitPrescriptionController::class, 'dataTable'])->name('visitPrescription.dataTable');
        Route::post('/visit-prescription', [VisitPrescriptionController::class, 'store'])->name('visitPrescription.store');
    });

    Route::middleware(['role.access:Admin,Kasir'])->group(function () {
        Route::get('/visit-bill', [VisitBillController::class, 'dataTable'])->name('visitBill.dataTable');
        Route::get('/visit-bill/{id}', [VisitBillController::class, 'show'])->name('visitBill.show');
        Route::post('/visit-bill', [VisitBillController::class, 'store'])->name('visitBill.store');
    });

    Route::middleware(['role.access:Admin'])->group(function () {
        Route::get('/regions', [RegionsController::class, 'dataTable'])->name('regions.dataTable');
        Route::post('/regions', [RegionsController::class, 'store'])->name('regions.store');
        Route::get('/regions/{id}', [RegionsController::class, 'show'])->name('regions.show');
        Route::put('/regions/{id}', [RegionsController::class, 'update'])->name('regions.update');
        Route::delete('/regions/{id}', [RegionsController::class, 'delete'])->name('regions.delete');

        Route::get('/employees', [EmployeesController::class, 'dataTable'])->name('employees.dataTable');
        Route::post('/employees', [EmployeesController::class, 'store'])->name('employees.store');
        Route::get('/employees/{id}', [EmployeesController::class, 'show'])->name('employees.show');
        Route::put('/employees/{id}', [EmployeesController::class, 'update'])->name('employees.update');
        Route::delete('/employees/{id}', [EmployeesController::class, 'delete'])->name('employees.delete');

        Route::get('/treatments', [TreatmentsController::class, 'dataTable'])->name('treatments.dataTable');
        Route::post('/treatments', [TreatmentsController::class, 'store'])->name('treatments.store');
        Route::get('/treatments/{id}', [TreatmentsController::class, 'show'])->name('treatments.show');
        Route::put('/treatments/{id}', [TreatmentsController::class, 'update'])->name('treatments.update');
        Route::delete('/treatments/{id}', [TreatmentsController::class, 'delete'])->name('treatments.delete');

        Route::get('/medicines', [MedicinesController::class, 'dataTable'])->name('medicines.dataTable');
        Route::post('/medicines', [MedicinesController::class, 'store'])->name('medicines.store');
        Route::get('/medicines/{id}', [MedicinesController::class, 'show'])->name('medicines.show');
        Route::put('/medicines/{id}', [MedicinesController::class, 'update'])->name('medicines.update');
        Route::delete('/medicines/{id}', [MedicinesController::class, 'delete'])->name('medicines.delete');

        Route::get('/manage-user', [UserController::class, 'dataTable'])->name('user.dataTable');
        Route::post('/manage-user', [UserController::class, 'store'])->name('user.store');
        Route::get('/manage-user/{id}', [UserController::class, 'show'])->name('user.show');
        Route::put('/manage-user/{id}', [UserController::class, 'update'])->name('user.update');
        Route::delete('/manage-user/{id}', [UserController::class, 'delete'])->name('user.delete');
    });

});




