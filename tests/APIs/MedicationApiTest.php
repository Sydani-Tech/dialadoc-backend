<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Medication;

class MedicationApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_medication()
    {
        $medication = Medication::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/medications', $medication
        );

        $this->assertApiResponse($medication);
    }

    /**
     * @test
     */
    public function test_read_medication()
    {
        $medication = Medication::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/medications/'.$medication->id
        );

        $this->assertApiResponse($medication->toArray());
    }

    /**
     * @test
     */
    public function test_update_medication()
    {
        $medication = Medication::factory()->create();
        $editedMedication = Medication::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/medications/'.$medication->id,
            $editedMedication
        );

        $this->assertApiResponse($editedMedication);
    }

    /**
     * @test
     */
    public function test_delete_medication()
    {
        $medication = Medication::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/medications/'.$medication->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/medications/'.$medication->id
        );

        $this->response->assertStatus(404);
    }
}
