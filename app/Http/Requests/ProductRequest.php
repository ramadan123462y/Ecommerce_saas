<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
         
            'name' => "required|unique:products,name,$this->id",
            'quantity' => 'required',
            'slug' => 'required',
            'original_price' => 'required',
            'selling_price' => 'required',
            'categorie_id' => 'required',
        ];
    }
}
