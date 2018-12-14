<?php
/**
 * Created by PhpStorm.
 * User: adamwaheed
 * Date: 12/12/2018
 * Time: 11:52 AM
 */

namespace Atolon\Finance\Requests;


use Illuminate\Foundation\Http\FormRequest;

class CreateCoupon extends FormRequest
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
            'amount'=>'required:integer',
            'reward'=>'required:integer',
            'expires_in'=>'required:integer'
        ];
    }
}