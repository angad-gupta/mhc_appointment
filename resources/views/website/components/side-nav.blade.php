 <div class="list-group list-group-border-0 g-mb-40">
              <!-- Overall -->
              <a href="{{route('home')}}" class="list-group-item list-group-item-action justify-content-between {{ request()->route()->getName() == 'home' ? 'active':''}}">
                <span><i class="fa fa-dashboard g-pos-rel g-top-1 g-mr-8"></i> Dashboard</span>
              </a>
              <!-- End Overall -->

              <!-- Profile -->
              <a href="{{route('web.patient.appointments')}}" class="list-group-item list-group-item-action justify-content-between  {{ request()->route()->getName() == 'web.patient.appointments' || request()->route()->getName() == 'web.patient.appointment' ? 'active':''}}">
                <span><i class="fa fa-calendar-check-o g-pos-rel g-top-1 g-mr-8"></i> Appointment</span>
              </a>
              <!-- End Profile -->

              <!-- Users Contacts -->
              <a href="{{route('web.patient.prescriptions')}}" class="list-group-item list-group-item-action justify-content-between {{ request()->route()->getName() == 'web.patient.prescriptions' ? 'active':''}}">
                <span><i class="icon-notebook g-pos-rel g-top-1 g-mr-8"></i> Prescription</span>
              </a>
              <!-- End Users Contacts -->

              <!-- My Projects -->
              <a href="{{route('web.patient.payments')}}" class="list-group-item list-group-item-action justify-content-between {{ request()->route()->getName() == 'web.patient.payments' ? 'active':''}}">
                <span><i class="fa fa-money g-pos-rel g-top-1 g-mr-8"></i> Payment</span>
              </a>
              <!-- End My Projects -->

              <!-- Comments -->
              <a href="{{route('web.patient.notes')}}" class="list-group-item list-group-item-action justify-content-between {{ request()->route()->getName() == 'web.patient.notes' ? 'active':''}}">
                <span><i class="fa fa-pencil g-pos-rel g-top-1 g-mr-8"></i> Note</span>
              </a>
              <!-- End Comments -->

              <!-- Reviews -->
              <a href="{{route('web.patient.documents')}}" class="list-group-item list-group-item-action justify-content-between {{ request()->route()->getName() == 'web.patient.documents' ? 'active':''}}">
                <span><i class="fa fa-files-o g-pos-rel g-top-1 g-mr-8"></i> Document</span>
              </a>
              <!-- End Reviews -->

              <!-- Settings -->
              <a href="{{route('web.patient.setting')}}" class="list-group-item list-group-item-action justify-content-between {{ request()->route()->getName() == 'web.patient.setting' ? 'active':''}}">
                <span><i class="icon-settings g-pos-rel g-top-1 g-mr-8"></i> Settings</span>
              </a>
              <!-- End Settings -->
            </div>