<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegionsCreateRequest;
use App\Http\Requests\RegionsUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Regions;
use Yajra\DataTables\Facades\DataTables;
use Exception;


class RegionsController extends Controller
{
    public function index()
    {
        return view('regions.index');
    }

    public function dataTable(): JsonResponse
    {
        $data = Regions::query()->get();

        return DataTables::of($data)
        ->addColumn('aksi', function ($row) {
            return " <a href='#' data-id='$row->id' class='mdi mdi-pencil text-warning btn-edit'></a>
                            <a href='#' data-id='$row->id' class='mdi mdi-trash-can text-danger btn-delete'></a>";
        })
        ->rawColumns(['aksi'])
        ->toJson();
    }

    public function store(RegionsCreateRequest $request): JsonResponse
    {

        try {
            $data = $request->validated();
            Regions::query()->create($data);

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
        $regions = Regions::find($id);

        if (!$regions) {
            return response()->json(['message' => 'Data wilayah tidak ditemukan'], 404);
        }

        return response()->json($regions);
    }

    public function update(RegionsUpdateRequest $request, $id): JsonResponse
    {
        $regions = Regions::find($id);

        if (!$regions) {
            return response()->json(['message' => 'Data wilayah tidak ditemukan'], 404);
        }

        $regions->name = $request->name;
        $regions->save();

        return response()->json(['message' => 'Data wilayah berhasil diperbarui'], 200);
    }

    public function delete($id): JsonResponse
    {
        $regions = Regions::find($id);

        if (!$regions) {
            return response()->json(['message' => 'Data wilayah tidak ditemukan'], 404);
        }

        $regions->delete();

        return response()->json(['message' => 'Data wilayah berhasil dihapus'], 200);
    }
}
