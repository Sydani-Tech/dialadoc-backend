<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\ProgressReport;

class ProgressReportApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_progress_report()
    {
        $progressReport = ProgressReport::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/progress-reports', $progressReport
        );

        $this->assertApiResponse($progressReport);
    }

    /**
     * @test
     */
    public function test_read_progress_report()
    {
        $progressReport = ProgressReport::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/progress-reports/'.$progressReport->id
        );

        $this->assertApiResponse($progressReport->toArray());
    }

    /**
     * @test
     */
    public function test_update_progress_report()
    {
        $progressReport = ProgressReport::factory()->create();
        $editedProgressReport = ProgressReport::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/progress-reports/'.$progressReport->id,
            $editedProgressReport
        );

        $this->assertApiResponse($editedProgressReport);
    }

    /**
     * @test
     */
    public function test_delete_progress_report()
    {
        $progressReport = ProgressReport::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/progress-reports/'.$progressReport->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/progress-reports/'.$progressReport->id
        );

        $this->response->assertStatus(404);
    }
}
