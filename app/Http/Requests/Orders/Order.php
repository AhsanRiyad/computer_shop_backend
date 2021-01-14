<?php

namespace App\Http\Requests\Orders;

use Illuminate\Foundation\Http\FormRequest;

class Order extends FormRequest
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
            //
            /* 'order.reference' => [
                'required', 'String',
                function ($attribute, $value, $fail) {
                    $fail($attribute . ' is invalid.');
                },
            ],
            'order_detail' => [function ($attribute, $value, $fail) {
                $fail($attribute .  $value[0]['product_id'] .' order detail is invalid.');
            },], */
        ];
    }


    public function messages()
    {
        return [
            // 'order.reference.string' => 'A value :attribute :input  is required',
        ];
    }
}
