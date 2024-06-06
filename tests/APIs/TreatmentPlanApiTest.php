<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\TreatmentPlan;

class TreatmentPlanApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_treatment_plan()
    {
        $treatmentPlan = TreatmentPlan::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/treatment-plans', $treatmentPlan
        );

        $this->assertApiResponse($treatmentPlan);
    }

    /**
     * @test
     */
    public function test_read_treatment_plan()
    {
        $treatmentPlan = TreatmentPlan::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/treatment-plans/'.$treatmentPlan->id
        );

        $this->assertApiResponse($treatmentPlan->toArray());
    }

    /**
     * @test
     */
    public function test_update_treatment_plan()
    {
        $treatmentPlan = TreatmentPlan::factory()->create();
        $editedTreatmentPlan = TreatmentPlan::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/treatment-plans/'.$treatmentPlan->id,
            $editedTreatmentPlan
        );

        $this->assertApiResponse($editedTreatmentPlan);
    }

    /**
     * @test
     */
    public function test_delete_treatment_plan()
    {
        $treatmentPlan = TreatmentPlan::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/treatment-plans/'.$treatmentPlan->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/treatment-plans/'.$treatmentPlan->id
        );

        $this->response->assertStatus(404);
    }
}
