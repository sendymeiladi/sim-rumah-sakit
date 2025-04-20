<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Visits;
use App\Models\VisitBill;
use Yajra\DataTables\Facades\DataTables;
use Exception;

class VisitBillController extends Controller
{
    public function index()
    {
        return view('visitsBill.index');
    }

    public function dataTable(): JsonResponse
    {
        $data = Visits::with('patients')->get();

        return DataTables::of($data)
        ->addColumn('aksi', function ($row) {
            return "
            <a href='#' data-id='$row->id' class='btn btn-sm btn-danger btn-payment'>
                <i class='mdi mdi-cash-register'></i> Bayar
            </a>
        ";
        })
        ->addColumn('nama', function (Visits $visits) {
            return $visits->patients->name;
        })
        ->addColumn('status_bayar', function (Visits $visits) {
            return $visits->visitBill
                ? '<span class="badge bg-success">Lunas</span>'
                : '<span class="badge bg-warning text-dark">Belum Bayar</span>';
        })
        ->rawColumns(['aksi', 'nama', 'status_bayar'])
        ->toJson();
    }

    public function show($id)
    {
        $visit = Visits::with(['patients','treatments', 'prescriptions.medicine'])->findOrFail($id);

        $total = 0;

        if ($visit->treatments) {
            $total += $visit->treatments->price;
        }

        if ($visit->prescriptions && $visit->prescriptions->count() > 0) {
            foreach ($visit->prescriptions as $prescription) {
                $total += $prescription->medicine?->price * $prescription->quantity;
            }
        }

        return response()->json([
            'visit' => $visit,
            'patient_name' => $visit->patients->name ?? 'Tidak diketahui',
            'treatments' => $visit->treatments,
            'prescriptions' => $visit->prescriptions,
            'total_price' => $total
        ]);
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'visit_id' => 'required|exists:visits,id',
        'total' => 'required|numeric',
    ]);

    $visitBill = VisitBill::create([
        'visit_id' => $validated['visit_id'],
        'total' => $validated['total'],
        'payment_date' => now(),
    ]);

    return response()->json(['message' => 'Pembayaran berhasil disimpan',]);
}
}
