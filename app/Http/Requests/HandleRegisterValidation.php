<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class HandleRegisterValidation extends FormRequest
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
    public function rules(): array
    {
        return [
            'name' => 'required',
            'surname' => 'required',
            'email' => ['required', 'unique:users,email'],
            'phone' => ['required'],
            'username' => ['required','unique:users,username'],
            'password' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nom és obligatori.',
            'surname.required' => 'El cognom és obligatori.',
            'email.required' => 'L\'email és obligatori.',
            'email.unique' => 'Aquest email ja està registrat.',
            'phone.required' => 'El telèfon és obligatori.',
            'username.required' => 'El nom d\'usuari és obligatori.',
            'username.unique' => 'Aquest nom d\'usuari ja està en ús.',
            'password.required' => 'La contrasenya és obligatòria.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'errors' => $validator->errors(),
        ], 422));
    }
}
