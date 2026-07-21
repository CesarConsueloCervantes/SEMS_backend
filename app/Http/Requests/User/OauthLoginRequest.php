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
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ];
    }
}
