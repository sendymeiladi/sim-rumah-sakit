<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Facades\DataTables;
use App\Models\User;
use App\Models\Residential;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use Exception;


class UserController extends Controller
{
    public function index()
    {
        return view('user.index');
    }
    public function dataTable(): JsonResponse
    {
        $data = User::where('username', '!=', 'lord_admin28')->get();

        return DataTables::of($data)
        ->addColumn('aksi', function ($row) {
            return " <a href='#' data-id='$row->id' class='mdi mdi-pencil text-warning btn-edit'></a>
                            <a href='#' data-id='$row->id' class='mdi mdi-trash-can text-danger btn-delete'></a>";
        })
        ->rawColumns(['aksi'])
        ->toJson();
    }
    public function store(UserCreateRequest $request): JsonResponse
    {

        try {
            $data = $request->validated();
            User::create($data);

            return response()->json(
                ['message' => 'Data berhasil ditambahkan'],
                201
            );

        } catch (Exception $exception) {
            return response()->json(
                ['message' => $exception->getMessage()],
                400
            );
        }
    }

    public function show($id): JsonResponse
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Data User ditemukan'], 404);
        }

        return response()->json($user);
    }

    public function update(UserUpdateRequest $request, $id): JsonResponse
    {
            try {
                $User = User::find($id);
                $data = $request->validated();
                $User->update($data);

                return response()->json(
                    data: ['message' => 'Data berhasil di ubah'],
                    status: 201
                );

            } catch (Exception $exception) {
                return response()->json(
                    data: ['message' => $exception->getMessage()],
                    status: 400
                );
            }

    }

    public function delete($id): JsonResponse
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'Data berhasil dihapus'], 200);
    }
}
