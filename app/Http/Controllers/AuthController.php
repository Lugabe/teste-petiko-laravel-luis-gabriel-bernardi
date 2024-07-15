<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        // Validação das credenciais
        $credentials = $request->only('email', 'password');

        // Buscar o usuário pelo email
        $user = User::where('email', $credentials['email'])->first();

        // Verificar se o usuário existe e se a senha está correta
        if ($user && Hash::check($credentials['password'], $user->password)) {
            // Autenticação bem-sucedida
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'is_admin' => $user->is_admin
                ]
            ]);
        }

        // Falha na autenticação
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    public function logout(User $user): JsonResponse
    {
        try {
            $user->tokens()->delete();
            return response()->json(['Deslogado com sucesso e token deletado.'], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Não Deslogado!',
                'erros' => $th
            ]);
        }
    }
}
