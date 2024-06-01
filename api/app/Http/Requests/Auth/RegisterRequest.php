<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Password::defaults()],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'ФИО не заполнено!',
            'name.max' => 'Максимальная длинна ФИО 255 символов!',
            'email.required' => 'Email не заполнен!',
            'email.lowecase' => 'Email должен быть нижнего регистра!',
            'email.email' => 'Не верный формат email!',
            'email.max' => 'Максимальная длинна email 255 символов!',
            'email.unique' => 'Сотрудник с заданным email уже существует в системе!',
            'password.required' => 'Введите пароль!',
            'password.confirmed' => '!',
        ];
    }
}
