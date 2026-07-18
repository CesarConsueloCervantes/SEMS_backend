<?php

namespace App\Http\Requests\User;

use App\Rules\IsEnabledUser;
use App\Rules\IsValidPassword;
use Illuminate\Foundation\Http\FormRequest;

class OauthLoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * 
     * Determina si el usuario está autorizado a realizar esta petición.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * 
     * Retorna las reglas de validación: correo obligatorio y válido, y contraseña obligatoria y válida.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', new IsEnabledUser],
            'password' => ['required', new IsValidPassword($this->email)],
        ];
    }
}
