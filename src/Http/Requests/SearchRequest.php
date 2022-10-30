<?php

namespace Hubblescope\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
{
    /**
    * Get the validation rules that apply to the request.
    *
    * @return array
    */
    public function rules()
    {
        return [
			"type" => ["required", "string"],
            "tags" => ['nullable', 'string'],
            "fields" => ['nullable', 'array'],
            "fields.*.key" => ['required', 'string'],
            "fields.*.operator" => ['required', 'string'],
            "fields.*.value" => ['nullable', 'string'],
            "page" => ["nullable", "integer"],
            "itemsPerPage" => ["nullable", "integer"],
        ];
    }
}
