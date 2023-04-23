<?php

namespace App\Http\Requests;

use App\Models\Ad;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreAdRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('ad_create');
    }

    public function rules()
    {
        return [
            'image' => [
                'required',
            ],
            'url' => [
                'string',
                'nullable',
            ],
        ];
    }
}