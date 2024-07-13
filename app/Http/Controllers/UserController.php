<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(): JsonResponse
    {
        $users = User::orderBy('id', 'ASC')->get();
        return response()->json($users);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string',
            'is_admin' => 'required|boolean',
            'password' => 'required'
        ]);

        try {
            $users = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'is_admin' => $request->is_admin,
                'password' => $request->password,
            ]);

            DB::commit();

            return response()->json($users, 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json($th,400);
        }


    }

    public function show($id)
    {
        DB::beginTransaction();

        try {
            $users = User::find($id);

            if ($users) {
                return response()->json($users);
            } else {
                return response()->json(['message' => 'User not found'], 404);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json($th,400);
        }

    }
}
