<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Doctor;

class DoctorApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_doctor()
    {
        $doctor = Doctor::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/doctors', $doctor
        );

        $this->assertApiResponse($doctor);
    }

    /**
     * @test
     */
    public function test_read_doctor()
    {
        $doctor = Doctor::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/doctors/'.$doctor->id
        );

        $this->assertApiResponse($doctor->toArray());
    }

    /**
     * @test
     */
    public function test_update_doctor()
    {
        $doctor = Doctor::factory()->create();
        $editedDoctor = Doctor::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/doctors/'.$doctor->id,
            $editedDoctor
        );

        $this->assertApiResponse($editedDoctor);
    }

    /**
     * @test
     */
    public function test_delete_doctor()
    {
        $doctor = Doctor::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/doctors/'.$doctor->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/doctors/'.$doctor->id
        );

        $this->response->assertStatus(404);
    }
}
