<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Allergy;

class AllergyApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_allergy()
    {
        $allergy = Allergy::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/allergies', $allergy
        );

        $this->assertApiResponse($allergy);
    }

    /**
     * @test
     */
    public function test_read_allergy()
    {
        $allergy = Allergy::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/allergies/'.$allergy->id
        );

        $this->assertApiResponse($allergy->toArray());
    }

    /**
     * @test
     */
    public function test_update_allergy()
    {
        $allergy = Allergy::factory()->create();
        $editedAllergy = Allergy::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/allergies/'.$allergy->id,
            $editedAllergy
        );

        $this->assertApiResponse($editedAllergy);
    }

    /**
     * @test
     */
    public function test_delete_allergy()
    {
        $allergy = Allergy::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/allergies/'.$allergy->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/allergies/'.$allergy->id
        );

        $this->response->assertStatus(404);
    }
}
