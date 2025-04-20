<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
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
use App\Http\Controllers\DashboardController;

Route::get('/', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::middleware('role.access:Admin,Petugas')->group(function () {
    Route::get('/visits', [visitsController::class, 'index'])->name('visits.index');
    Route::get('/patients', [PatientsController::class, 'index'])->name('patients.index');
    });

    Route::middleware('role.access:Admin,Dokter')->group(function () {
        Route::get('/visit-treatment', [VisitTreatmentController::class, 'index'])->name('visitTreatment.index');
        Route::get('/visit-prescription', [VisitPrescriptionController::class, 'index'])->name('visitPrescription.index');
    });

    Route::middleware('role.access:Admin,Dokter')->group(function () {
        Route::get('/visit-treatment', [VisitTreatmentController::class, 'index'])->name('visitTreatment.index');
        Route::get('/visit-prescription', [VisitPrescriptionController::class, 'index'])->name('visitPrescription.index');
    });

    Route::middleware('role.access:Admin,Kasir')->group(function () {
        Route::get('/visit-bill', [VisitBillController::class, 'index'])->name('visitBill.index');
    });

    Route::middleware(['role.access:Admin'])->group(function () {
        Route::get('/regions', [RegionsController::class, 'index'])->name('regions.index');
        Route::get('/employees', [EmployeesController::class, 'index'])->name('employees.index');
        Route::get('/treatments', [TreatmentsController::class, 'index'])->name('treatments.index');
        Route::get('/medicines', [MedicinesController::class, 'index'])->name('medicines.index');
        Route::get('/manage-user', [UserController::class, 'index'])->name('user.index');
    });
});



require __DIR__.'/auth.php';
