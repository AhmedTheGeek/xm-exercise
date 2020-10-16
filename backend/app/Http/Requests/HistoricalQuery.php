<?php

namespace App\Http\Requests;

use DateTime;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class HistoricalQuery extends FormRequest
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
        return [
            'email' => 'required|email',
            'symbol' => 'required|string',
            'startDate' => 'required|int',
            'endDate' => 'required|int',
        ];
    }



    /**
     * @param Validator $validator
     *
     */
    protected function failedValidation( Validator $validator ): void {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
