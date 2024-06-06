<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Prescription;

class PrescriptionApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_prescription()
    {
        $prescription = Prescription::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/prescriptions', $prescription
        );

        $this->assertApiResponse($prescription);
    }

    /**
     * @test
     */
    public function test_read_prescription()
    {
        $prescription = Prescription::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/prescriptions/'.$prescription->id
        );

        $this->assertApiResponse($prescription->toArray());
    }

    /**
     * @test
     */
    public function test_update_prescription()
    {
        $prescription = Prescription::factory()->create();
        $editedPrescription = Prescription::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/prescriptions/'.$prescription->id,
            $editedPrescription
        );

        $this->assertApiResponse($editedPrescription);
    }

    /**
     * @test
     */
    public function test_delete_prescription()
    {
        $prescription = Prescription::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/prescriptions/'.$prescription->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/prescriptions/'.$prescription->id
        );

        $this->response->assertStatus(404);
    }
}
