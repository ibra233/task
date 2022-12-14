<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $logo = 'nullable';
        if (request()->routeIs('company.store')) {
            $logo = 'required';
        }

        return [
            'name' => 'required|max:255',
            'logo' => $logo.'|mimes:jpg,bmp,png',
            'company_industry.*' => 'nullable|integer',
        ];
    }

    public function attributes()
    {
        return [
            'name' => __('view.name-company'),
            'logo' => __('view.logo-company'),
            'company_industry.*' => __('view.company-industry'),
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors(),
            'status' => false,
        ], 422));
    }
}
