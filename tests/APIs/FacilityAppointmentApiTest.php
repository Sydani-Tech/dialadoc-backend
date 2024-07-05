<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\FacilityAppointment;

class FacilityAppointmentApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_facility_appointment()
    {
        $facilityAppointment = FacilityAppointment::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/facility-appointments', $facilityAppointment
        );

        $this->assertApiResponse($facilityAppointment);
    }

    /**
     * @test
     */
    public function test_read_facility_appointment()
    {
        $facilityAppointment = FacilityAppointment::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/facility-appointments/'.$facilityAppointment->id
        );

        $this->assertApiResponse($facilityAppointment->toArray());
    }

    /**
     * @test
     */
    public function test_update_facility_appointment()
    {
        $facilityAppointment = FacilityAppointment::factory()->create();
        $editedFacilityAppointment = FacilityAppointment::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/facility-appointments/'.$facilityAppointment->id,
            $editedFacilityAppointment
        );

        $this->assertApiResponse($editedFacilityAppointment);
    }

    /**
     * @test
     */
    public function test_delete_facility_appointment()
    {
        $facilityAppointment = FacilityAppointment::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/facility-appointments/'.$facilityAppointment->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/facility-appointments/'.$facilityAppointment->id
        );

        $this->response->assertStatus(404);
    }
}
