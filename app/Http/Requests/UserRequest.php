<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'erros' => $validator->errors()
        ], 422));
    }


    public function rules(): array
    {
        $userId = $this->route('users');
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users,email' . ($userId ? $userId->id : null),
            'password' => 'required|min:6',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Campo nome é obrigatório.',
            'email.required' => 'Campo email é obrigatório.',
            'email.email' => 'Campo email deve ser um e-mail válido.',
            'email.unique' => 'O e-mail já está cadastrado!',
            'password.required' => 'Campo password é obrigatório.',
            'password.min' => 'A senha deve conter pelomenos 6 caracteres.s'
        ];
    }
}
