<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\ConsentType;

class ConsentTypeApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_consent_type()
    {
        $consentType = ConsentType::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/consent-types', $consentType
        );

        $this->assertApiResponse($consentType);
    }

    /**
     * @test
     */
    public function test_read_consent_type()
    {
        $consentType = ConsentType::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/consent-types/'.$consentType->id
        );

        $this->assertApiResponse($consentType->toArray());
    }

    /**
     * @test
     */
    public function test_update_consent_type()
    {
        $consentType = ConsentType::factory()->create();
        $editedConsentType = ConsentType::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/consent-types/'.$consentType->id,
            $editedConsentType
        );

        $this->assertApiResponse($editedConsentType);
    }

    /**
     * @test
     */
    public function test_delete_consent_type()
    {
        $consentType = ConsentType::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/consent-types/'.$consentType->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/consent-types/'.$consentType->id
        );

        $this->response->assertStatus(404);
    }
}
