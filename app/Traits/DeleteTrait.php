<?php


namespace App\Traits;


use App\Models\Appointment;
use App\Models\AppointmentFollowUpNote;
use App\Models\Assistant;
use App\Models\DoctorsPatients;
use App\Models\Drug;
use App\Models\Patient;
use App\Models\PatientPayment;
use App\Models\Prescription;
use App\Models\PrescriptionHelper;
use App\Models\PrescriptionSetting;
use App\Models\Template\PrescriptionTemplate;
use App\User;

trait DeleteTrait
{
    /**
     * Delete doctor with all related data
     *
     * @param User $user
     * @return bool
     */
    public function isEmptyDoctorsRelatedData(User $user)
    {
        if (DoctorsPatients::where('doctor_id', $user->doctor->id)->orWhere('created_by', $user->id)->count() > 0) {
            return false;
        } elseif (Patient::where('created_by', $user->id)->count() > 0) {
            return false;
        } elseif (Prescription::where('doctor_id', $user->doctor->id)->count() > 0) {
            return false;
        } elseif (PatientPayment::where('created_by', $user->id)->count() > 0) {
            return false;
        } elseif (PrescriptionSetting::where('doctor_id', $user->doctor->id)->count() > 0) {
            return false;
        } elseif (PrescriptionTemplate::where('doctor_id', $user->doctor->id)->count() > 0) {
            return false;
        } elseif (Assistant::where('created_by', $user->id)->count() > 0) {
            return false;
        } elseif (Appointment::where('created_by', $user->id)->count() > 0) {
            return false;
        } elseif (AppointmentFollowUpNote::where('created_by', $user->id)->count() > 0) {
            return false;
        } elseif (Drug::where('created_by', $user->id)->count() > 0) {
            return false;
        } else {
            return true;
        }

    }
}