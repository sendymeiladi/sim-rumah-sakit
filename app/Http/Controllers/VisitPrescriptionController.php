<?php

namespace App\Http\Controllers;

use App\Http\Requests\VisitTreatmentUpdateRequest;
use App\Models\Medicines;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Visits;
use App\Models\VisitPrescription;
use Yajra\DataTables\Facades\DataTables;
use Exception;

class VisitPrescriptionController extends Controller
{
    public function index()
    {
        $medicines = Medicines::all();
        return view('visitsPrescription.index', compact('medicines'));
    }

    public function dataTable(): JsonResponse
    {
        $data = Visits::with('patients')->get();

        return DataTables::of($data)
        ->addColumn('aksi', function ($row) {
            return "<button class='btn btn-sm btn-danger btn-prescription' data-id='{$row->id}'>Resepkan</button>";
        })
        ->addColumn('nama', function (Visits $visits) {
            return $visits->patients->name;
        })
        ->rawColumns(['aksi', 'nama'])
        ->toJson();
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'visit_id' => 'required|exists:visits,id',
            'medicines' => 'required|array',
            'medicines.*.medicine_id' => 'required|exists:medicines,id',
            'medicines.*.quantity' => 'required|integer|min:1',
            'medicines.*.usage_instructions' => 'required|string',
        ]);

        foreach ($validated['medicines'] as $medicine) {
            VisitPrescription::create([
                'visit_id' => $validated['visit_id'],
                'medicine_id' => $medicine['medicine_id'],
                'quantity' => $medicine['quantity'],
                'usage_instructions' => $medicine['usage_instructions'],
            ]);
        }

        return response()->json(['message' => 'Resep berhasil disimpan']);
    }
}
