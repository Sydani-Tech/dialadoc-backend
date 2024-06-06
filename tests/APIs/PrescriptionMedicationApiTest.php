<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\PrescriptionMedication;

class PrescriptionMedicationApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_prescription_medication()
    {
        $prescriptionMedication = PrescriptionMedication::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/prescription-medications', $prescriptionMedication
        );

        $this->assertApiResponse($prescriptionMedication);
    }

    /**
     * @test
     */
    public function test_read_prescription_medication()
    {
        $prescriptionMedication = PrescriptionMedication::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/prescription-medications/'.$prescriptionMedication->id
        );

        $this->assertApiResponse($prescriptionMedication->toArray());
    }

    /**
     * @test
     */
    public function test_update_prescription_medication()
    {
        $prescriptionMedication = PrescriptionMedication::factory()->create();
        $editedPrescriptionMedication = PrescriptionMedication::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/prescription-medications/'.$prescriptionMedication->id,
            $editedPrescriptionMedication
        );

        $this->assertApiResponse($editedPrescriptionMedication);
    }

    /**
     * @test
     */
    public function test_delete_prescription_medication()
    {
        $prescriptionMedication = PrescriptionMedication::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/prescription-medications/'.$prescriptionMedication->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/prescription-medications/'.$prescriptionMedication->id
        );

        $this->response->assertStatus(404);
    }
}
