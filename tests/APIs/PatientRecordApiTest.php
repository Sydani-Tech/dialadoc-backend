<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\PatientRecord;

class PatientRecordApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_patient_record()
    {
        $patientRecord = PatientRecord::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/patient-records', $patientRecord
        );

        $this->assertApiResponse($patientRecord);
    }

    /**
     * @test
     */
    public function test_read_patient_record()
    {
        $patientRecord = PatientRecord::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/patient-records/'.$patientRecord->id
        );

        $this->assertApiResponse($patientRecord->toArray());
    }

    /**
     * @test
     */
    public function test_update_patient_record()
    {
        $patientRecord = PatientRecord::factory()->create();
        $editedPatientRecord = PatientRecord::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/patient-records/'.$patientRecord->id,
            $editedPatientRecord
        );

        $this->assertApiResponse($editedPatientRecord);
    }

    /**
     * @test
     */
    public function test_delete_patient_record()
    {
        $patientRecord = PatientRecord::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/patient-records/'.$patientRecord->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/patient-records/'.$patientRecord->id
        );

        $this->response->assertStatus(404);
    }
}
