<?php

namespace App\Http\Controllers\SMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\SMS\CreateRequest;
use App\Models\Service;
use Illuminate\Http\Response;
use App\Models\SMS;
use Illuminate\Support\Facades\Log;

/**
 * @OA\Get(
 *   path="api/sms",
 *   tags={"Create"},
 *   summary="Create sms",
 *   @OA\RequestBody(
 *     required=true,
 *     @OA\JsonContent(ref="#components/schemas/CreateSMSRequest")
 *   ),
 *   @OA\Response(
 *     response="406",
 *     description="Validation error"
 *   ),
 *   @OA\Response(
 *     response="200",
 *     description="ok"
 *   )
 * )
 */
class CreateController extends Controller
{
    public function __invoke(CreateRequest $r)
    {
        Log::info($r->url());
        $service = Service::query()->whereToken($r->token)->firstOrFail();

        $sms = SMS::create([
            'service_id'  => $service->id,
            'phone'    => $r->phone,
            'content'  => $r->content,
        ]);

        return response()
            ->json([
                'success' => true,
                'data'    => $sms
            ], Response::HTTP_CREATED);
    }
}
