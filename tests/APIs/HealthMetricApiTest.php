<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\HealthMetric;

class HealthMetricApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_health_metric()
    {
        $healthMetric = HealthMetric::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/health-metrics', $healthMetric
        );

        $this->assertApiResponse($healthMetric);
    }

    /**
     * @test
     */
    public function test_read_health_metric()
    {
        $healthMetric = HealthMetric::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/health-metrics/'.$healthMetric->id
        );

        $this->assertApiResponse($healthMetric->toArray());
    }

    /**
     * @test
     */
    public function test_update_health_metric()
    {
        $healthMetric = HealthMetric::factory()->create();
        $editedHealthMetric = HealthMetric::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/health-metrics/'.$healthMetric->id,
            $editedHealthMetric
        );

        $this->assertApiResponse($editedHealthMetric);
    }

    /**
     * @test
     */
    public function test_delete_health_metric()
    {
        $healthMetric = HealthMetric::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/health-metrics/'.$healthMetric->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/health-metrics/'.$healthMetric->id
        );

        $this->response->assertStatus(404);
    }
}
