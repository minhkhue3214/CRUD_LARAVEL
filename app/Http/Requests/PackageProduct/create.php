<?php

namespace App\Http\Requests\PackageProduct;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class create extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'package_name' => ['required', 'string', 'max:50'],
            'package_description' => ['required', 'string', 'max:100'],
            'product_list' => ['required'],
        ];
    }
}
