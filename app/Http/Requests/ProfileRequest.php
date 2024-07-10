<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use function App\Http\Helpers\store_saller;

class ProfileRequest extends FormRequest
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


            'title' => 'required',
            'sub_domain' => "required|unique:stores,sub_domain,".store_saller()->id,
        ];
    }
}
