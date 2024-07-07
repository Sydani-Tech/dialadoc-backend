<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// Auth routes
Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('register', [AuthController::class, 'register'])->name('auth.register');
    Route::post('recover', [AuthController::class, 'recover'])->name('auth.recover');
    Route::post('send-reset-token', [AuthController::class, 'passwordResetToken'])->name('auth.reset-token');
    Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('auth.reset-password');
});

Route::prefix('auth')->middleware(['auth:sanctum'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::post('email-verification', [AuthController::class, 'emailVerification'])->name('auth.email-verification');
    Route::post('verify-email', [AuthController::class, 'verifyEmail'])->name('auth.verify-email');
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::resource('specializations', App\Http\Controllers\API\SpecializationAPIController::class)
        ->except(['create', 'edit']);

    Route::resource('locations', App\Http\Controllers\API\LocationAPIController::class)
        ->except(['create', 'edit']);

    Route::resource('doctors', App\Http\Controllers\API\DoctorAPIController::class)
        ->except(['create', 'edit']);

    Route::post('doctors/create-patient-record', [App\Http\Controllers\API\DoctorAPIController::class, 'createPatientRecord']);
    Route::post('doctors/upload-documents', [App\Http\Controllers\API\DoctorAPIController::class, 'uploadDocuments'])->name('doctors.upload-documents');

    Route::resource('reviews', App\Http\Controllers\API\ReviewAPIController::class)
        ->except(['create', 'edit']);

    Route::resource('pharmacies', App\Http\Controllers\API\PharmacyAPIController::class)
        ->except(['create', 'edit']);

    Route::resource('medications', App\Http\Controllers\API\MedicationAPIController::class)
        ->except(['create', 'edit']);

    Route::resource('prescriptions', App\Http\Controllers\API\PrescriptionAPIController::class)
        ->except(['create', 'edit']);

    Route::resource('prescription-medications', App\Http\Controllers\API\PrescriptionMedicationAPIController::class)
        ->except(['create', 'edit']);

    Route::resource('orders', App\Http\Controllers\API\OrderAPIController::class)
        ->except(['create', 'edit']);

    Route::resource('appointments', App\Http\Controllers\API\AppointmentAPIController::class)
        ->except(['create', 'edit']);
    Route::get('appointments/consultation-appointment/{consultation_id}', [App\Http\Controllers\API\AppointmentAPIController::class, 'appointmentByConsultation']);
    Route::get('appointments/by-patient/{patient_id}', [App\Http\Controllers\API\AppointmentAPIController::class, 'appointmentsByPatient']);

    Route::resource('consultations', App\Http\Controllers\API\ConsultationAPIController::class)
        ->except(['create', 'edit']);
    Route::get('consultations/by-doctor/{doctor_id}', [App\Http\Controllers\API\ConsultationAPIController::class, 'getConsultationsByDoctor']);

    Route::resource('messages', App\Http\Controllers\API\MessageAPIController::class)
        ->except(['create', 'edit']);

    Route::get('patients/by-user/{user_id}', [App\Http\Controllers\API\PatientAPIController::class, 'getByUserId']);

    Route::resource('patients', App\Http\Controllers\API\PatientAPIController::class)
        ->except(['create', 'edit']);

    Route::resource('medical-records', App\Http\Controllers\API\MedicalRecordAPIController::class)
        ->except(['create', 'edit']);

    Route::resource('test-results', App\Http\Controllers\API\TestResultAPIController::class)
        ->except(['create', 'edit']);

    Route::resource('health-metrics', App\Http\Controllers\API\HealthMetricAPIController::class)
        ->except(['create', 'edit']);

    Route::resource('treatment-plans', App\Http\Controllers\API\TreatmentPlanAPIController::class)
        ->except(['create', 'edit']);

    Route::resource('progress-reports', App\Http\Controllers\API\ProgressReportAPIController::class)
        ->except(['create', 'edit']);

    Route::resource('payments', App\Http\Controllers\API\PaymentAPIController::class)
        ->except(['create', 'edit']);

    Route::resource('notifications', App\Http\Controllers\API\NotificationAPIController::class)
        ->except(['create', 'edit']);

    Route::resource('insurances', App\Http\Controllers\API\InsuranceAPIController::class)
        ->except(['create', 'edit']);

    Route::resource('consent-types', App\Http\Controllers\API\ConsentTypeAPIController::class)
        ->except(['create', 'edit']);

    Route::resource('users', App\Http\Controllers\API\UserAPIController::class)
        ->except(['create', 'edit']);

    Route::resource('roles', App\Http\Controllers\API\RoleAPIController::class)
        ->except(['create', 'edit']);

    Route::get('permissions', [App\Http\Controllers\API\PermissionAPIController::class, 'index']);

    Route::resource('vital-signs', App\Http\Controllers\API\VitalSignAPIController::class)
        ->except(['create', 'edit']);

    Route::resource('allergies', App\Http\Controllers\API\AllergyAPIController::class)
        ->except(['create', 'edit']);

    Route::get('allergy-types', [App\Http\Controllers\API\AllergyAPIController::class, 'getAllergyTypes'])->name('allergy-types');
    Route::get('vital-sign-types', [App\Http\Controllers\API\VitalSignAPIController::class, 'getVitalSignsTypes'])->name('vital-sign-types');

    Route::resource('patient-records', App\Http\Controllers\API\PatientRecordAPIController::class)
        ->except(['create', 'edit']);

    Route::get('patient-records/by-facility/{facility_id}', [App\Http\Controllers\API\PatientRecordAPIController::class, 'referredPatientRecordsForFacility']);
    Route::get('appointments/appointment-patient-record/{appointment_id}', [App\Http\Controllers\API\PatientRecordAPIController::class, 'patientRecordByAppointment']);

    Route::resource('facilities', App\Http\Controllers\API\FacilityAPIController::class)
        ->except(['create', 'edit']);

    Route::get('facility-referrals/{facility_id}', [App\Http\Controllers\API\FacilityAPIController::class, 'getReferrals']);

    Route::resource('facility-appointments', App\Http\Controllers\API\FacilityAppointmentAPIController::class)
        ->except(['create', 'edit']);
    Route::get('facility-appointments/by-facility/{facility_id}', [App\Http\Controllers\API\FacilityAppointmentAPIController::class, 'appointmentByFacility']);
    Route::get('facility-appointments/by-patient/{patient_id}', [App\Http\Controllers\API\FacilityAppointmentAPIController::class, 'appointmentByPatient']);
});


Route::get('countries', [App\Http\Controllers\API\CommonAPIController::class, 'getCountries']);
Route::get('states', [App\Http\Controllers\API\CommonAPIController::class, 'getStates']);
Route::get('nigerian-states', [App\Http\Controllers\API\CommonAPIController::class, 'getNigerianStates']);
Route::get('nigerian-lgas', [App\Http\Controllers\API\CommonAPIController::class, 'getNigerianLGAs']);
Route::get('nigerian-geo-political-zones', [App\Http\Controllers\API\CommonAPIController::class, 'getNigerianGeopoliticalZones']);
Route::get('nigerian-senatorial-zones', [App\Http\Controllers\API\CommonAPIController::class, 'getNigerianSenatorialZones']);
