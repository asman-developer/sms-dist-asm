<?php

namespace App\Http\Controllers\SMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\SMS\FetchRequest;
use App\Models\SMS;

/**
 * @OA\Post(
 *   path="api/sms",
 *   tags={"Checkout"},
 *   summary="Checkout sms",
 *   @OA\RequestBody(
 *     required=true,
 *     @OA\JsonContent(ref="#components/schemas/FetchRequest")
 *   ),
 *   @OA\Response(
 *     response="406",
 *     description="Validation error"
 *   ),
 *   @OA\Response(
 *     response="200",
 *     description="ok",
 *     @OA\JsonContent(ref="#components/schemas/SMSModel")
 *   )
 * )
 */

class FetchController extends Controller
{
    public function __invoke(FetchRequest $r)
    {
        $sms = SMS::select('*')
            ->when($r->phone, function ($q, $v) {
                $q->wherePhone($v)->latest();
            })
            ->when($r->sms_id, function ($q, $v) {
                $q->whereId($v);
            })
            ->firstOrFail();

        return response()
            ->json([
                'success' => true,
                'data'    => $sms
            ]);
    }
}
