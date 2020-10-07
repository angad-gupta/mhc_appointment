<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment</title>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="//media.twiliocdn.com/sdk/js/video/v1/twilio-video.min.js"></script>
    <link rel="stylesheet" href="{{ asset('dash/plugins/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dash/plugins/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dash/plugins/Ionicons/css/ionicons.min.css') }}">

    @yield('css')

    <link rel="stylesheet" href="{{ asset('dash/css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dash/css/skins/_all-skins.min.css') }}">

    <link rel="stylesheet" href="{{ asset('dash/plugins/toastr.js/build/toastr.min.css') }}">

    <link rel="stylesheet" href="{{ asset('dash/css/custom-style.css') }}">


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
@php
$auth_user = auth('extra_user')->check() ? auth('extra_user')->user() : auth()->user();
@endphp
    <!-- Google Font -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <style>
        #videoCall {
            width: auto;
            height: 100%;
            position: relative;
            background-color:white;
            overflow: hidden;
        }

        body {
            margin: 0px;
        }

        #videoCall .contact-name {
            position: absolute;
            top: 0;
            margin-left: 15px;
            color: #f5f5f5;
            text-shadow: 0 1px rgba(0, 0, 0, 0.7);
        }

        #videoCall .remote-stream {
            width: 100%;
            height: 100%;
            background: rgba(3, 33, 52, 0.7);
            z-index: -1;
        }

        #videoCall .local-stream {
            width: 25%;
            height: 30%;
            position: absolute;
            z-index: 1000;
            background: #fff;
            border: solid 1px rgba(0, 0, 0, 0.3);
            bottom: 10;
            left: 40%;
        }

        #videoCall .controls {
            /* position: absolute;
        bottom: 0;
          */
            /* margin-right: 20px;
        margin-bottom: 10px; */
        }

        #videoCall .controls button {
            border: 0 none;
            padding: 10px 12px;
            border-radius: 50%;
            margin: 0 auto;
        }

        .material-icons.md-18 {
            font-size: 18px;
        }

        .material-icons.md-24 {
            font-size: 24px;
        }

        .material-icons.md-36 {
            font-size: 36px;
        }

        .material-icons.md-48 {
            font-size: 48px;
        }

        #videoCall .controls .call-end i {
            color: #f5f5f5;
        }

        #videoCall .controls .call-mute i {
            color: #f5f5f5;
        }

        #videoCall .controls .call-video-off i {
            color: #f5f5f5;
        }
    </style>
    <script>
        var roomObj;

        Twilio.Video.createLocalTracks({
            audio: true,
            video: {
                width: 640
            }
        }).then(function (localTracks) {
            return Twilio.Video.connect('{{ $accessToken }}', {
                name: '{{ $roomName }}',
                tracks: localTracks,
                video: {
                    width: 640
                }
            });
        }).then(function (room) {
            roomObj = room;
            //Alert use after you have joined the room
            
            //if someone has already joined the room before you
            if(room.participants.size > 0) {
                room.participants.forEach(function(participant){
                    participantConnected(participant, "remote");
                });
            }

            // room.participants.forEach(participantConnected);
            var previewContainer = document.getElementById('media-div');

            //if you join the room
            if (!previewContainer || !previewContainer.querySelector('video')) {
                participantConnected(room.localParticipant, "local");
            } 

            //if someone joined the room after you
            room.on('participantConnected', function (participant) {
                participantConnected(participant, "remote");
            });

            room.on('participantDisconnected', function (participant) {
                participantDisconnected(participant);
            });
        });
        // additional functions will be added after this point
        function participantConnected(participant, user) {
            const div = document.createElement('div');
            div.id = participant.sid;
            if (user == "local") {
                div.setAttribute("style", "float: left; margin: 10px;");

                participant.tracks.forEach(function (track) {
                    trackAdded(div, track, user);
                });

                participant.on('trackAdded', function (track) {
                    trackAdded(div, track, user);
                });
                participant.on('trackRemoved', trackRemoved);

                document.getElementById('media-div').appendChild(div);
            } else if (user == "remote") {
                div.setAttribute("style", "float: left;");

                participant.tracks.forEach(function (track) {
                    trackAdded(div, track, user);
                });

                participant.on('trackAdded', function (track) {
                    trackAdded(div, track, user);
                });

                participant.on('trackRemoved', trackRemoved);

                document.getElementById('remote-media-div').appendChild(div);
            }


        }

        function participantDisconnected(participant) {
            participant.tracks.forEach(trackRemoved);
            document.getElementById(participant.sid).remove();
        }
        
        //add the video
        function trackAdded(div, track, user) {
           div.appendChild(track.attach());
           var video = div.getElementsByTagName("video")[0];
           if (video) {
               if(user == "local") {
                    video.setAttribute("style", "margin-left: 90%; margin-top: -19%; max-width: 200px; border: 2px solid #999;border-radius: 10px;");
               } else if (user == "remote") {
                    video.setAttribute("style", "margin-left: 50%; width: 600px; border: 2px solid #999;border-radius: 10px;");
               }
           }
        }


        function trackRemoved(track) {
            track.detach().forEach(function (element) {
                element.remove()
            });
        }

        function MuteAudioTracks() {
            roomObj.localParticipant.audioTracks.forEach(audioTracks => {
                if (audioTracks.isEnabled == true) {
                    audioTracks.disable();
                    $('.fa-microphone-slash').removeClass('hidden');
                    $('.fa-microphone').addClass('hidden');
                } else {
                    audioTracks.enable();
                    $('.fa-microphone-slash').addClass('hidden');
                    $('.fa-microphone').removeClass('hidden');
                }
            });
        }

        function MuteVideoTracks() {
            roomObj.localParticipant.videoTracks.forEach(videoTrack => {
                if (videoTrack.isEnabled == true) {
                    videoTrack.disable();
                } else {
                    videoTrack.enable();
                }
            });
        }

        $(document).ready(function () {
            $('#end_call').click(function () {
                participantDisconnected(roomObj.localParticipant);
                
                var roomName = $(this).attr('room-name');
                var authUser = "{{ $auth_user->role }}";
                //only change the status of videoCall and appointment, if call ended by doctor
                if(authUser == 2) {
                    $.ajax({
                        url: "/room/destroy/"+roomName,
                        type: 'GET',
                        success: function(res) {
                            window.location.href = "{{ route('home') }}";
                        }, 
                        error: function(err) {
                            alert("Internal server error");
                        }
                    });
                } else if (!authUser) {
                    window.location.href = "{{ route('home') }}";
                }
                
            });

            $('#call-mute').click(function () {
                MuteAudioTracks();
            });

            $("#call-video-off").click(function () {
                MuteVideoTracks();
            })
        });
    </script>
</head>

<body>
    {{-- <div id="videoCall">
  <div class="contact-name">
    <h3 id="partner_name">Partner Name</h3>
  </div>
  <video class="remote-stream">thier video</video>
  <video class="local-stream" id="local-stream">
  </video>
  <div class="controls">
    <button class="call-end" style="font-size:48px; background-color: grey;"><i class="fa fa-video-camera" aria-hidden="true"></i></button>
    <button class="call-mute" style="font-size:48px; background-color: grey;"><i class="fa fa-microphone-slash" aria-hidden="true"></i></button>
    <button class="call-video-off" style="font-size:48px; background-color: #f00;"><i class="fa fa-phone" aria-hidden="true"></i></button>
  </div>
</div> --}}
    {{-- {{ dd(auth()->user()->role) }} --}}
    
    <div class="content" id="videoCall">
        <div class="row">
            <a href="http://localhost:8000" class="navbar-brand">
                <img src="https://www.merohealthcare.com/assets/images/1592375295logo.jpg" height="60" width="100" alt="Unify Logo">
            </a>
        </div>
        <div class="row">            
            @if (auth('extra_user')->check())
            <div style="height: 80%" id="remote-media-div">
                {{-- remote video --}}
            </div>
            @elseif($auth_user->role == 2)
            <div class="col-md-6" id="remote-media-div" style="height: 80%">               
                {{-- remote video --}}
            </div>
            <div class="col-md-6" style="height: 80%">                
                <div class="box-body" style="width: 60%; float: right;">

                    @include('operations.patient.patient-card-small', ['appointment'=>$appointment])
        
        
                    <form action="{{ route('patient-note.store','redirect_back=1') }}" method="post">
                        @csrf
                        <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">
                        <input type="hidden" value="{{ $appointment->patient_id }}" name="patient_id">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">{{ __('note.note') }}</label>
                                <textarea name="note" cols="30" rows="4" required minlength="10"
                                          class="form-control html-editor"></textarea>
                            </div>
                            <button type="submit" class="btn btn-success">{{ __('actions.submit') }}</button>
                        </div>
        
                    </form>
                </div>
            </div>
            @endif
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="controls" style="margin-left: 60%;">
                    <button class="call-video-off" id="call-video-off"
                        style="font-size:48px; background-color: grey;"><i class="fa fa-video-camera"
                            aria-hidden="true"></i></button>
                    <button class="call-mute" id="call-mute" style="font-size:48px; background-color: grey;"><i
                            class="fa fa-microphone-slash hidden" aria-hidden="true"></i><i class="fa fa-microphone"
                            aria-hidden="true"></i></button>
                    <button class="call-end" room-name="{{ $appointment->search_id }}" id="end_call" style="font-size:48px; background-color: #f00;"><i
                            class="fa fa-phone" aria-hidden="true"></i></button>
                </div>
            </div>
            <div class="col-md-4" style="margin-top: -5%">
                <div id="media-div">
                    {{-- your video --}}
                </div>
            </div>
        </div>
    </div>

</body>

</html>