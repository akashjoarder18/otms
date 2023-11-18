<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateUpazilaRequest extends FormRequest
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
     * @return array  
     */
    public function rules()
    {
        $upazila = request()->route('upazila');
        
        return [
            'name' => 'required|regex:/^[A-Za-z0-9\-.\(\) ]+$/|unique:upazilas,name,' . $upazila->id,
            'district_id' => 'required|numeric'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [           
            'name.required' => 'Please Enter Upazila Name.',
            'name.unique' => 'Upazila Name should be unique.',
            'name.regex' => 'The Upazila Name field can only contain letters, numbers, hyphens, dots, spaces and parentheses.',
            'district_id.required' => 'Please Enter Upazila Name.'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return json array
     */
    public function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'error' => true,
            'message' => $validator->messages(),
        ]));
    }
}
