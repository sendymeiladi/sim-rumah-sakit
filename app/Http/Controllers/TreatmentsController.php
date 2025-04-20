<?php

namespace App\Http\Controllers;

use App\Http\Requests\TreatmentsCreateRequest;
use App\Http\Requests\TreatmentsUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Treatments;
use Yajra\DataTables\Facades\DataTables;
use Exception;

class TreatmentsController extends Controller
{
    public function index()
    {
        return view('treatments.index');
    }

    public function dataTable(): JsonResponse
    {
        $data = Treatments::query()->get();

        return DataTables::of($data)
        ->addColumn('aksi', function ($row) {
            return " <a href='#' data-id='$row->id' class='mdi mdi-pencil text-warning btn-edit'></a>
                            <a href='#' data-id='$row->id' class='mdi mdi-trash-can text-danger btn-delete'></a>";
        })
        ->rawColumns(['aksi'])
        ->toJson();
    }

    public function store(TreatmentsCreateRequest $request): JsonResponse
    {

        try {
            $data = $request->validated();
            Treatments::query()->create($data);

            return response()->json(
                data: ['message' => 'Data berhasil di tambahkan'],
                status: 201
            );

        } catch (Exception $exception) {
            return response()->json(
                data: ['message' => $exception->getMessage()],
                status: 400
            );
        }

    }

    public function show($id): JsonResponse
    {
        $treatments = Treatments::find($id);

        if (!$treatments) {
            return response()->json(['message' => 'Data tindakan tidak ditemukan'], 404);
        }

        return response()->json($treatments);
    }

    public function update(TreatmentsUpdateRequest $request, $id): JsonResponse
    {
        $treatments = Treatments::find($id);

        if (!$treatments) {
            return response()->json(['message' => 'Data tindakan tidak ditemukan'], 404);
        }

        $treatments->name = $request->name;
        $treatments->price = $request->price;
        $treatments->save();

        return response()->json(['message' => 'Data tindakan berhasil diperbarui'], 200);
    }

    public function delete($id): JsonResponse
    {
        $treatments = Treatments::find($id);

        if (!$treatments) {
            return response()->json(['message' => 'Data tindakan tidak ditemukan'], 404);
        }

        $treatments->delete();

        return response()->json(['message' => 'Data tindakan berhasil dihapus'], 200);
    }
}
