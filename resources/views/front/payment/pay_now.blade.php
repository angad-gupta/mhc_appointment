<div class="col-md-12">
          <h5 class="g-mb-15">Payment Options</h5>
        </div>
        <div class="col-md-12">
          <div class="row text-center">
            <!-- Visa Card -->
            <div class="col-md-6">
              <label class="u-check w-100 g-mb-25">
                <strong class="d-block g-color-gray-dark-v2 g-font-weight-700 g-mb-10">Pay with Khalti</strong>
                <input class="g-hidden-xs-up g-pos-abs g-top-10 g-right-10" id="khalti_payment_option" type="radio" name="profilePayments">
                <div
                  class="g-brd-primary--checked g-bg-primary-opacity-0_2--checked g-brd-around g-brd-gray-light-v2 g-rounded-5">
                  <div class="media g-pa-12">
                    <div class="media-body align-self-center g-color-blue">
                      <img
                        src="https://lh3.googleusercontent.com/vtoxj9t4UWl6qxWUPGpv7ndJuJs_W3UTnQYpBwJ7xBMuRJ2TE6d71NrwWU6Nkbq0Zs8"
                        class="g-font-size-30 align-self-center mx-auto" width="60">
                    </div>

                  </div>
                </div>
              </label>
            </div>
            <!-- End Visa Card -->
            <!-- Master Card -->
            <div class="col-md-6">
              <label class="u-check w-100 g-mb-25">
                <strong class="d-block g-color-gray-dark-v2 g-font-weight-700 g-mb-10">Esewa</strong>
                <input class="g-hidden-xs-up g-pos-abs g-top-10 g-right-10" id="esewa_payment_option" type="radio" name="profilePayments">
                <div
                  class="g-brd-primary--checked g-bg-primary-opacity-0_2--checked g-brd-around g-brd-gray-light-v2 g-rounded-5">
                  <div class="media g-pa-12">
                    <div class="media-body align-self-center g-color-lightred">
                      <img src="https://myngch.com/frontend/assets/images/esewa_logo.png"
                        class="g-font-size-30 align-self-center mx-auto" width="60">
                    </div>
                  </div>
                </div>
              </label>
            </div>
            <!-- End Master Card -->
          </div>
        </div>
        <button type="button" class="btn btn-block btn-primary rounded-0 submit-button">
          Confirm Appointment
        </button>


         <script>
        var config = {
            "publicKey": "{{ env('KHALTI_PUBLIC_KEY') }}",
            "productIdentity": "{{$appointment->search_id}}",
            "productName": "Appointment for {{$schedule_date}} starting from {{$schedule_time}}",
            "productUrl": "{{$url}}",
            "paymentPreference": [
                "MOBILE_BANKING",
                "KHALTI",
                "EBANKING",
                "CONNECT_IPS",
                "SCT",
                ],
            "eventHandler": {
                onSuccess (payload) {
                    $.ajax({
                    type: "POST",
                    url:"{{route('khalti_verification')}}",
                    data:{
                        amount: payload.amount,
                        mobile: payload.mobile,
                        order_number : payload.product_identity,
                        token : payload.token,
                        _token: '{{ csrf_token() }}'
                    },
                    success:function(data){
                        location.href = "{{route('payment_success_khalti',['appointment_id' => $appointment->search_id])}}";
                    },
                    error: function(data){
                        alert("Something went wrong")                     
                    }
                });  
                },
                onError (error) {
                    alert(error);
                },
                onClose () {
                    console.log('widget is closing');
                }
            }
        };

        var checkout = new KhaltiCheckout(config);

        $(document).on("click", "#pay-with-khalti" , function() {
           checkout.show({amount: {{$payment * 100}}});
        });
        $(document).on('click',"#pay-with-esewa",function(){
            var path="{{ env('ESEWA_URL') }}";

            var params= {
                amt: {{$payment}},
                psc: 0,
                pdc: 0,
                txAmt: 0,
                tAmt: {{$payment}},
                pid: "{{$appointment->search_id}}",
                scd: "{{ env('ESEWA_MERCHANT_CODE') }}",
                su: "{{route('payment_success',['appointment_id' => $appointment->search_id])}}",
                fu: "{{route('payment_failed',['appointment_id' => $appointment->search_id])}}"
            }            

            function post(path, params) {
                var form = document.createElement("form");
                form.setAttribute("method", "POST");
                form.setAttribute("action", path);

                for(var key in params) {
                    var hiddenField = document.createElement("input");
                    hiddenField.setAttribute("type", "hidden");
                    hiddenField.setAttribute("name", key);
                    hiddenField.setAttribute("value", params[key]);
                    form.appendChild(hiddenField);
                }
                
                document.body.appendChild(form);
                form.submit();
            }
            post(path,params);
        });
    </script>