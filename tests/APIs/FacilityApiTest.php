<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Facility;

class FacilityApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_facility()
    {
        $facility = Facility::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/facilities', $facility
        );

        $this->assertApiResponse($facility);
    }

    /**
     * @test
     */
    public function test_read_facility()
    {
        $facility = Facility::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/facilities/'.$facility->id
        );

        $this->assertApiResponse($facility->toArray());
    }

    /**
     * @test
     */
    public function test_update_facility()
    {
        $facility = Facility::factory()->create();
        $editedFacility = Facility::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/facilities/'.$facility->id,
            $editedFacility
        );

        $this->assertApiResponse($editedFacility);
    }

    /**
     * @test
     */
    public function test_delete_facility()
    {
        $facility = Facility::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/facilities/'.$facility->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/facilities/'.$facility->id
        );

        $this->response->assertStatus(404);
    }
}
