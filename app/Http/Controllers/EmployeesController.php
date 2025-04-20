<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeesCreateRequest;
use App\Http\Requests\EmployeesUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Employees;
use Yajra\DataTables\Facades\DataTables;
use Exception;

class EmployeesController extends Controller
{
    public function index()
    {
        return view('employees.index');
    }

    public function dataTable(): JsonResponse
    {
        $data = Employees::query()->get();

        return DataTables::of($data)
        ->addColumn('aksi', function ($row) {
            return " <a href='#' data-id='$row->id' class='mdi mdi-pencil text-warning btn-edit'></a>
                            <a href='#' data-id='$row->id' class='mdi mdi-trash-can text-danger btn-delete'></a>";
        })
        ->rawColumns(['aksi'])
        ->toJson();
    }

    public function store(EmployeesCreateRequest $request): JsonResponse
    {

        try {
            $data = $request->validated();
            Employees::query()->create($data);

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
        $employees = Employees::find($id);

        if (!$employees) {
            return response()->json(['message' => 'Data karyawan tidak ditemukan'], 404);
        }

        return response()->json($employees);
    }

    public function update(EmployeesUpdateRequest $request, $id): JsonResponse
    {
        $employees = Employees::find($id);

        if (!$employees) {
            return response()->json(['message' => 'Data karyawan tidak ditemukan'], 404);
        }

        $employees->nip = $request->nip;
        $employees->name = $request->name;
        $employees->position = $request->position;
        $employees->joined_date = $request->joined_date;
        $employees->phone = $request->phone;
        $employees->address = $request->address;
        $employees->save();

        return response()->json(['message' => 'Data karyawan berhasil diperbarui'], 200);
    }

    public function delete($id): JsonResponse
    {
        $employees = Employees::find($id);

        if (!$employees) {
            return response()->json(['message' => 'Data karyawan tidak ditemukan'], 404);
        }

        $employees->delete();

        return response()->json(['message' => 'Data karyawan berhasil dihapus'], 200);
    }
}
