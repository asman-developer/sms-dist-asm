<?php

namespace App\Http\Requests\SMS;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     type="object",
 *     title="FetchRequest",
 *     description="Checkout sms",
 *     required={"phone"},
 *     @OA\Property(
 *         property="phone",
 *         title="phone",
 *         type="integer",
 *         description="11 digits phone number of user",
 *         example="99362615986"
 *     ),
 *     @OA\Property(
 *         property="sms_id",
 *         title="Sms id",
 *         type="integer",
 *         description="Sms id returned by system",
 *         example="13335"
 *     )
 *  )
 */
class FetchRequest extends FormRequest
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
            'phone'  => 'nullable|numeric|digits:11',
            'sms_id' => 'nullable|numeric'
        ];
    }
}
