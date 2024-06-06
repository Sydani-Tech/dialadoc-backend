<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Specialization;

class SpecializationApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_specialization()
    {
        $specialization = Specialization::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/specializations', $specialization
        );

        $this->assertApiResponse($specialization);
    }

    /**
     * @test
     */
    public function test_read_specialization()
    {
        $specialization = Specialization::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/specializations/'.$specialization->id
        );

        $this->assertApiResponse($specialization->toArray());
    }

    /**
     * @test
     */
    public function test_update_specialization()
    {
        $specialization = Specialization::factory()->create();
        $editedSpecialization = Specialization::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/specializations/'.$specialization->id,
            $editedSpecialization
        );

        $this->assertApiResponse($editedSpecialization);
    }

    /**
     * @test
     */
    public function test_delete_specialization()
    {
        $specialization = Specialization::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/specializations/'.$specialization->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/specializations/'.$specialization->id
        );

        $this->response->assertStatus(404);
    }
}
