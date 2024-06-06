<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Consultation;

class ConsultationApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_consultation()
    {
        $consultation = Consultation::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/consultations', $consultation
        );

        $this->assertApiResponse($consultation);
    }

    /**
     * @test
     */
    public function test_read_consultation()
    {
        $consultation = Consultation::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/consultations/'.$consultation->id
        );

        $this->assertApiResponse($consultation->toArray());
    }

    /**
     * @test
     */
    public function test_update_consultation()
    {
        $consultation = Consultation::factory()->create();
        $editedConsultation = Consultation::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/consultations/'.$consultation->id,
            $editedConsultation
        );

        $this->assertApiResponse($editedConsultation);
    }

    /**
     * @test
     */
    public function test_delete_consultation()
    {
        $consultation = Consultation::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/consultations/'.$consultation->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/consultations/'.$consultation->id
        );

        $this->response->assertStatus(404);
    }
}
