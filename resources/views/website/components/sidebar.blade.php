<div class="list-group">
    <a href="{{ route('home') }}" class="list-group-item list-group-item-action {{ active_if_full_match('home') }}">
        <i class="fas fa-home"></i>{{ __('dashboard.dashboard') }}
    </a>
    <a href="{{ route('web.patient.appointments') }}" class="list-group-item list-group-item-action {{ active_if_full_match('w/patient/appointments') }}">
        <i class="far fa-calendar-check"></i>{{ __('appointment.appointment') }}
    </a>
    <a href="{{ route('web.patient.prescriptions') }}" class="list-group-item list-group-item-action {{ active_if_full_match('w/patient/prescriptions') }}">
        <i class="fas fa-file-prescription"></i>{{ __('prescription.prescription') }}
    </a>
    <a href="{{ route('web.patient.payments') }}" class="list-group-item list-group-item-action {{ active_if_full_match('w/patient/payments') }}">
        <i class="fas fa-credit-card"></i>{{ __('payment.title') }}
    </a>
    <a href="{{ route('web.patient.notes') }}" class="list-group-item list-group-item-action {{ active_if_full_match('w/patient/notes') }}">
        <i class="far fa-clipboard"></i>{{ __('note.note') }}
    </a>
    <a href="{{ route('web.patient.documents') }}" class="list-group-item list-group-item-action {{ active_if_full_match('w/patient/documents') }}">
        <i class="fas fa-file-medical-alt"></i>{{ __('document.document') }}
    </a>
    <a href="{{ route('web.patient.my-account') }}" class="list-group-item list-group-item-action {{ active_if_full_match('w/patient/my-account') }}">
        <i class="fas fa-user-cog"></i>{{ __('website.nav.account.my_account') }}
    </a>
    <a href="{{ route('web.patient.setting') }}" class="list-group-item list-group-item-action {{ active_if_full_match('w/patient/setting') }}">
        <i class="fas fa-cogs"></i>{{ __('settings.settings') }}
    </a>
</div>
