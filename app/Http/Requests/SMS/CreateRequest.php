<?php

namespace App\Http\Requests\SMS;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     type="object",
 *     title="CreateSMSRequest",
 *     description="Create sms",
 *     required={"phone", "content"},
 *      @OA\Property(
 *         property="user_phone",
 *         title="user_phone",
 *         type="integer",
 *         description="Phone number of user",
 *         example="99362615986"
 *     ),
 *     @OA\Property(
 *         property="content",
 *         title="Content",
 *         type="string",
 *         description="Raw sms body",
 *         example="Hello world or 22333"
 *     ),
 *  )
 */
class CreateRequest extends FormRequest
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
            'phone'    => 'required|numeric|digits:11',
            'content'  => 'nullable|max:160'
        ];
    }
}
