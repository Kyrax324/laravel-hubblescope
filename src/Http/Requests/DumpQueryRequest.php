<?php

namespace Microscope\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DumpQueryRequest extends FormRequest
{
    /**
    * Get the validation rules that apply to the request.
    *
    * @return array
    */
    public function rules()
    {
        return [
            "tags" => ['nullable', 'string'],
            "fields" => ['nullable', 'array'],
            "fields.*.key" => ['required', 'string'],
            "fields.*.operator" => ['required', 'string'],
            "fields.*.value" => ['nullable', 'string'],
        ];
    }
}
