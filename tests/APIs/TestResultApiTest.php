<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\TestResult;

class TestResultApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_test_result()
    {
        $testResult = TestResult::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/test-results', $testResult
        );

        $this->assertApiResponse($testResult);
    }

    /**
     * @test
     */
    public function test_read_test_result()
    {
        $testResult = TestResult::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/test-results/'.$testResult->id
        );

        $this->assertApiResponse($testResult->toArray());
    }

    /**
     * @test
     */
    public function test_update_test_result()
    {
        $testResult = TestResult::factory()->create();
        $editedTestResult = TestResult::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/test-results/'.$testResult->id,
            $editedTestResult
        );

        $this->assertApiResponse($editedTestResult);
    }

    /**
     * @test
     */
    public function test_delete_test_result()
    {
        $testResult = TestResult::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/test-results/'.$testResult->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/test-results/'.$testResult->id
        );

        $this->response->assertStatus(404);
    }
}
