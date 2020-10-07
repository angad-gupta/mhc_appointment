@if(session('success'))
    <script>
        $(document).ready(function () {
            swal("{{ session('success') }}")
        })
    </script>
    <?php session()->forget('success') ?>
@endif

@if(session('error'))
    <script>
        $(document).ready(function () {
            swal("{{ session('error') }}")
        })
        <?php session()->forget('error') ?>
    </script>
@endif