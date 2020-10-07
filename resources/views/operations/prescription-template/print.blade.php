<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print Prescription</title>
    <link rel="stylesheet" href="{{ asset('dash/plugins/bootstrap/dist/css/bootstrap.min.css') }}">
    <style>
        @page {
            size: A4 portrait;
        }

        .signature {
            position: fixed;
            bottom: 20px;
            right: 0px;
            border-top: 1px solid;
            width: 200px;
            text-align: right;
        }

        .next-appointment {
            position: fixed;
            bottom: 20px;
            left: 0;
            text-align: left;
        }
    </style>
</head>
<body>

<table width="100%" style="border-bottom: 1px solid #878787;">
    <tr>
        <td width="50%" style="text-align: left;">
            <h3> ডক্টর আবু হেনা মস্তফা কামাল</h3>
            <p>
                FCPS
            </p>
        </td>
        <td width="50%" style="text-align: right;">
            <h3>Doctor Abu Hena mostofa kamal</h3>
            <p>
                DDD
            </p>
        </td>
    </tr>
</table>


<table width="100%" style="margin-top: 20px;">
    <tr>
        <td width="40%" valign="top" style="border-right: 1px solid #636363;">
            @if($template->inspection->chief_complains)
                <strong>Chief Complains</strong>
                <p>{{ $template->inspection->chief_complains }}</p>
            @endif

            @if($template->inspection->on_examinations)
                <strong>On Examinations</strong>
                <p>{{ $template->inspection->on_examinations }}</p>
            @endif

            @if($template->inspection->provisional_diagnosis)
                <strong>Provisional Diagnosis</strong>
                <p>{{ $template->inspection->provisional_diagnosis }}</p>
            @endif

            @if($template->inspection->differential_diagnosis)
                <strong>Differential Diagnosis</strong>
                <p>{{ $template->inspection->differential_diagnosis }}</p>
            @endif

            @if($template->inspection->lab_workup)
                <strong>Lab Workup</strong>
                <p>{{ $template->inspection->lab_workup }}</p>
            @endif

            @if($template->inspection->advices)
                <strong>Advices</strong>
                <p>{{ $template->inspection->advices }}</p>
            @endif


        </td>
        <td width="60%" valign="top">
            <h4 style="margin-left: 5px;">Rx</h4>
            <ol>
                @foreach($template->drugs as $drug)
                    <li>{{ $drug->type }} {{ $drug->name }} {{ $drug->strength }} <br> {{ $drug->dose }}
                        <br> {{ $drug->advice }}</li>
                @endforeach
            </ol>
        </td>
    </tr>

</table>


<div class="signature">
    Sign & Sel
</div>

<script>
    // window.print();
</script>

</body>
</html>