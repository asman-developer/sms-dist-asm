<?php

use App\Jobs\InsertErrorJob;

function service(string $token)
{
   $tokens = config('clients.tokens');

   if (!isset($tokens[$token])) {
      return;
   }

   return $tokens[$token];
}

function currentStaff(): ?\Illuminate\Contracts\Auth\Authenticatable
{
    return auth('staff')->user();
}

function toErrors(
   \Exception $exception
) {
  InsertErrorJob::dispatch(
       $exception->getFile(), 
       $exception->getTrace(), 
       now(),
   );
}
