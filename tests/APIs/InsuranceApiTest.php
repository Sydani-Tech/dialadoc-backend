<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Insurance;

class InsuranceApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_insurance()
    {
        $insurance = Insurance::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/insurances', $insurance
        );

        $this->assertApiResponse($insurance);
    }

    /**
     * @test
     */
    public function test_read_insurance()
    {
        $insurance = Insurance::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/insurances/'.$insurance->id
        );

        $this->assertApiResponse($insurance->toArray());
    }

    /**
     * @test
     */
    public function test_update_insurance()
    {
        $insurance = Insurance::factory()->create();
        $editedInsurance = Insurance::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/insurances/'.$insurance->id,
            $editedInsurance
        );

        $this->assertApiResponse($editedInsurance);
    }

    /**
     * @test
     */
    public function test_delete_insurance()
    {
        $insurance = Insurance::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/insurances/'.$insurance->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/insurances/'.$insurance->id
        );

        $this->response->assertStatus(404);
    }
}
