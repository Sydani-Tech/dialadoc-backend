<?php

namespace App\Http\Helpers;

use Illuminate\Support\Facades\DB;

class FacilityReferral
{
  public static function getFacilityReferral($facilityId)
  {
    $results = DB::table('patient_records', 'ptr')
      ->where('ptr.recommended_facility', '=', $facilityId)
      ->join('patients', 'ptr.patient_id', '=', 'patients.patient_id')
      ->join('users', 'patients.user_id', '=', 'users.id')
      ->join('appointments', 'ptr.appointment_id', '=', 'appointments.appointment_id')
      ->join('consultations', 'appointments.consultation_id', '=', 'consultations.consultation_id')
      ->join('doctors', 'consultations.doctor_id', '=', 'doctors.doctor_id')
      ->join('users as doc', 'doctors.user_id', '=', 'doc.id')
      ->select(
        'users.name as patient_name',
        'patients.state as patient_state',
        'patients.lga as patient_lga',
        'patients.patient_id as patient_id',
        'patients.gender as patient_gender',
        'doc.name as doctor_name',
        'doctors.doctor_id as doctor_id',
        'consultations.consultation_id as consultation_id',
        'appointments.appointment_id as appointment_id',
        'ptr.update_type',
        'ptr.suspected_illness',
        'ptr.findings',
        'ptr.recommended_tests',
        'ptr.prescriptions'
      )
      ->get();

    return $results->groupBy('patient_name')->map(function ($patientRecords, $patientName) {
      $firstRecord = $patientRecords->first();

      return [
        'patient_name' => $patientName,
        'patient_id' => $firstRecord->patient_id,
        'patient_state' => $firstRecord->patient_state,
        'patient_lga' => $firstRecord->patient_lga,
        'patient_gender' => $firstRecord->patient_gender,
        'patient_records' => $patientRecords->map(function ($record) {
          return [
            'doctor_name' => $record->doctor_name,
            'doctor_id' => $record->doctor_id,
            'consultation_id' => $record->consultation_id,
            'appointment_id' => $record->appointment_id,
            'update_type' => $record->update_type,
            'suspected_illness' => $record->suspected_illness,
            'findings' => $record->findings,
            'recommended_tests' => $record->recommended_tests,
            'prescriptions' => $record->prescriptions
          ];
        })->toArray()
      ];
    })->values()->toArray();
  }
}