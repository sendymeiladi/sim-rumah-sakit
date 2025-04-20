<?php

namespace App\Http\Controllers;

use App\Http\Requests\VisitTreatmentUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Patients;
use App\Models\Visits;
use App\Models\Treatments;
use Yajra\DataTables\Facades\DataTables;
use Exception;

class VisitTreatmentController extends Controller
{
    public function index()
    {
        $patientsData = Patients::all();
        $treatmentsData = Treatments::all();

        return view('visitsTretament.index', compact('patientsData', 'treatmentsData'));

    }

    public function dataTable(): JsonResponse
    {
        $data = Visits::with('patients')->get();

        return DataTables::of($data)
        ->addColumn('aksi', function ($row) {
            return "<a href='#' data-id='$row->id' class='btn btn-sm btn-danger btn-treatment'>Tindakan</a>";
        })
        ->addColumn('nama', function (Visits $visits) {
            return $visits->patients->name;
        })
        ->addColumn('tindakan', function (Visits $visits) {
            if ($visits->treatments) {
                return '<span class="badge bg-primary">' . $visits->treatments->name . '</span>';
            }
            return '<span class="badge bg-secondary">Belum Ditindak</span>';
        })
        ->rawColumns(['aksi','nama', 'tindakan'])
        ->toJson();
    }

    public function show($id): JsonResponse
    {
        $visits = Visits::find($id);

        if (!$visits) {
            return response()->json(['message' => 'Data perumahan tidak ditemukan'], 404);
        }

        return response()->json($visits);
    }

    public function update(VisitTreatmentUpdateRequest $request, $id): JsonResponse
    {
        $visits = Visits::find($id);

        if (!$visits) {
            return response()->json(['message' => 'Data kunjungan tidak ditemukan'], 404);
        }

        $visits->treatment_id = $request->treatment_id;
        $visits->save();

        return response()->json(['message' => 'Data kunjungan berhasil diperbarui'], 200);
    }
}
