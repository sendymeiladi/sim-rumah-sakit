<?php

namespace App\Http\Controllers;

use App\Http\Requests\MedicinesCreateRequest;
use App\Http\Requests\MedicinesUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Medicines;
use Yajra\DataTables\Facades\DataTables;
use Exception;

class MedicinesController extends Controller
{
    public function index()
    {
        return view('medicines.index');
    }

    public function dataTable(): JsonResponse
    {
        $data = Medicines::query()->get();

        return DataTables::of($data)
        ->addColumn('aksi', function ($row) {
            return " <a href='#' data-id='$row->id' class='mdi mdi-pencil text-warning btn-edit'></a>
                            <a href='#' data-id='$row->id' class='mdi mdi-trash-can text-danger btn-delete'></a>";
        })
        ->rawColumns(['aksi'])
        ->toJson();
    }

    public function store(MedicinesCreateRequest $request): JsonResponse
    {

        try {
            $data = $request->validated();
            Medicines::query()->create($data);

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
        $medicines = Medicines::find($id);

        if (!$medicines) {
            return response()->json(['message' => 'Data obat tidak ditemukan'], 404);
        }

        return response()->json($medicines);
    }

    public function update(MedicinesUpdateRequest $request, $id): JsonResponse
    {
        $medicines = Medicines::find($id);

        if (!$medicines) {
            return response()->json(['message' => 'Data obat tidak ditemukan'], 404);
        }

        $medicines->name = $request->name;
        $medicines->unit = $request->unit;
        $medicines->stock = $request->stock;
        $medicines->price = $request->price;
        $medicines->save();

        return response()->json(['message' => 'Data obat berhasil diperbarui'], 200);
    }

    public function delete($id): JsonResponse
    {
        $medicines = Medicines::find($id);

        if (!$medicines) {
            return response()->json(['message' => 'Data obat tidak ditemukan'], 404);
        }

        $medicines->delete();

        return response()->json(['message' => 'Data obat berhasil dihapus'], 200);
    }
}
