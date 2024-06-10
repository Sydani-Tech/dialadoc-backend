<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\VitalSign;

class VitalSignApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_vital_sign()
    {
        $vitalSign = VitalSign::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/vital-signs', $vitalSign
        );

        $this->assertApiResponse($vitalSign);
    }

    /**
     * @test
     */
    public function test_read_vital_sign()
    {
        $vitalSign = VitalSign::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/vital-signs/'.$vitalSign->id
        );

        $this->assertApiResponse($vitalSign->toArray());
    }

    /**
     * @test
     */
    public function test_update_vital_sign()
    {
        $vitalSign = VitalSign::factory()->create();
        $editedVitalSign = VitalSign::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/vital-signs/'.$vitalSign->id,
            $editedVitalSign
        );

        $this->assertApiResponse($editedVitalSign);
    }

    /**
     * @test
     */
    public function test_delete_vital_sign()
    {
        $vitalSign = VitalSign::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/vital-signs/'.$vitalSign->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/vital-signs/'.$vitalSign->id
        );

        $this->response->assertStatus(404);
    }
}
