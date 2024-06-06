<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Location;

class LocationApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_location()
    {
        $location = Location::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/locations', $location
        );

        $this->assertApiResponse($location);
    }

    /**
     * @test
     */
    public function test_read_location()
    {
        $location = Location::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/locations/'.$location->id
        );

        $this->assertApiResponse($location->toArray());
    }

    /**
     * @test
     */
    public function test_update_location()
    {
        $location = Location::factory()->create();
        $editedLocation = Location::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/locations/'.$location->id,
            $editedLocation
        );

        $this->assertApiResponse($editedLocation);
    }

    /**
     * @test
     */
    public function test_delete_location()
    {
        $location = Location::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/locations/'.$location->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/locations/'.$location->id
        );

        $this->response->assertStatus(404);
    }
}
