<?php

namespace Tests\Feature;

use Tests\TestCase;

class ApiTest extends TestCase
{
    protected $token = 'ijjthUAP0cqkH7TOPAvBBsAZDtvdzaJV';

    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_it_can_create_sms_test()
    {
        $response = $this->postJson('api/sms', [
            'token'   => $this->token,
            'phone'   => 99362615986,
            'content' => '12345'
        ]);

        $response
            ->dump()
            ->assertStatus(201);
    }

    public function test_it_can_checkout_sms_test()
    {
        $response = $this->json('GET', 'api/sms', [
            // 'sms_id'  => 1,
            'token'   => $this->token,
            'phone'   => 99362615986
        ]);
        
        $response
            ->dump()
            ->assertStatus(200);
    }
}
