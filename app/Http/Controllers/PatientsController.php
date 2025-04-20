<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Patients;
use App\Models\Visits;
use Yajra\DataTables\Facades\DataTables;
use Exception;

class PatientsController extends Controller
{
    public function index()
    {
        return view('patients.index');
    }

    public function dataTable(): JsonResponse
    {
        $data = Patients::with('regions')->get();

        return DataTables::of($data)
        ->addColumn('aksi', function ($row) {
            return "<a href='#' data-id='$row->id' class='btn btn-sm btn-danger btn-register'>Daftarkan</a>";
        })
        ->addColumn('wilayah', function (Patients $patient) {
            return $patient->regions->name;
        })
        ->rawColumns(['aksi', 'wilayah'])
        ->toJson();
    }

    public function visit(Request $request): JsonResponse
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
        ]);

        try {
            $visit = Visits::create([
                'patient_id' => $request->patient_id,
                'visit_type' => 'lama',
            ]);

            return response()->json(['message' => 'Data kunjungan berhasil didaftarkan'], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat mendaftarkan kunjungan',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
