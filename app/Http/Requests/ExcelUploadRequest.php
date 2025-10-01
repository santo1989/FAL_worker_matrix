<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExcelUploadRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'excel_file' => 'required|file|mimes:xlsx,xls|max:10240', // 10MB max
        ];
    }

    public function messages()
    {
        return [
            'excel_file.required' => 'Please select an Excel file to upload.',
            'excel_file.mimes' => 'The file must be an Excel file (xlsx or xls).',
            'excel_file.max' => 'The file size must not exceed 10MB.',
        ];
    }
}
