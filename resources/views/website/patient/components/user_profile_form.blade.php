<form action="{{ route('web.patient.update-account') }}" method="post" class="validate" enctype="multipart/form-data">
    @csrf
    @method('put')
    <div class="row pl-4 pr-4">
        <div class="col-md-4">
           <img class="img-fluid w-100"  src="{{ asset(auth()->user()->patient->photo ? auth()->user()->patient->photo : 'front/assets/images/dummy-user.jpg') }}" alt="{{auth()->user()->fullname}}">
        </div>

        <div class="col-md-8">
            <div class="form-row">
                <div class="col-4">
                    <div class="form-group">
                        <input type="text" required class="form-control" name="title"
                            value="{{ auth()->user()->patient->title }}" placeholder="{{ __('patient.title') }}" />
                    </div>
                </div>
                <div class="col-8">
                    <div class="form-group">
                        <input type="text" required class="form-control" name="full_name"
                            value="{{ auth()->user()->patient->full_name }}"
                            placeholder="{{ __('doctor.full_name') }}" />
                    </div>
                </div>

                <div class="col-4 col-md-2">
                    <div class="form-group">
                        <select name="sex" required class="form-control">
                            <option {{ setSelectOption(auth()->user()->patient->sex , 'Male') }} value="Male">
                                Male
                            </option>
                            <option {{ setSelectOption(auth()->user()->patient->sex , 'Female') }} value="Female">
                                Female
                            </option>
                            <option {{ setSelectOption(auth()->user()->patient->sex , 'Other') }} value="Other">
                                Other
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-4 col-md-5">
                    <div class="form-group">
                        <input type="text"
                            value="{{ \Carbon\Carbon::parse(auth()->user()->patient->date_of_birth)->format('d-M-Y') }}"
                            required name="date_of_birth" class="form-control date_of_birth"
                            placeholder="{{ __('patient.birth_date') }}" />
                    </div>
                </div>
                <div class="col-4 col-md-5">
                    <div class="form-group">
                        <input type="text" required class="form-control" readonly
                            value="{{ auth()->user()->patient->age }}" placeholder="{{ __('patient.age') }}" />
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <input type="text" value="{{ auth()->user()->patient->occupation }}" class="form-control"
                            name="occupation" placeholder="{{ __('patient.occupation') }}" /></div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <input type="text" value="{{ auth()->user()->patient->height }}" class="form-control"
                            name="height" placeholder="{{ __('patient.height') }}" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <input type="text" value="{{ auth()->user()->patient->weight }}" class="form-control"
                            name="weight" placeholder="{{ __('patient.weight') }}" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <input type="text" required class="form-control"
                            value="{{ auth()->user()->patient->cell_phone }}" name="cell_phone"
                            placeholder="{{ __('patient.home_phone') }}" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <input type="text" class="form-control" value="{{ auth()->user()->patient->home_phone }}"
                            name="home_phone" placeholder="{{ __('patient.cell_phone') }}" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <input type="text" readonly class="form-control" placeholder="{{ __('patient.contact_email') }}"
                            name="contact_email" value="{{ auth()->user()->patient->contact_email }}" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="{{ __('patient.country') }}" name="country"
                            value="{{ auth()->user()->patient->country }}" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="text" class="form-control" value="{{ auth()->user()->patient->city }}" name="city"
                            placeholder="{{ __('patient.city') }}" /></div>
                </div>
                <div class="col-xs-12 col-sm-6 mb-4">
                 <label class="g-color-gray-dark-v2 g-font-weight-600 g-font-size-13">   Choose Photo</label>
                 <input type="file" id="uploadImage" name="photo" class="uploadPreview" />  
              </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <textarea name="address" rows="5" class="form-control" placeholder="{{ __('patient.address') }}"
                            value="{{ auth()->user()->patient->address }}"></textarea>
                    </div>
                </div>

                <div class="col-md-12">
                    <button class="btn btn-primary rounded-0">{{ __('actions.submit') }}</button>
                </div>
            </div>
        </div>
    </div>
</form>