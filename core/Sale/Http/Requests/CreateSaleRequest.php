<?php

namespace Core\Sale\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateSaleRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'products' => ['required', 'array',],
            'products.*' => ['required', 'integer', 'exists:products,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'products.*.exists' => 'Produto ID :input inválido!',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
