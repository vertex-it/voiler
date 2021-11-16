<style>
    #toast-container > div {
        opacity: 1;
    }
</style>

<script>
    toastr.options = {
        closeButton: true,
        progressBar: true,
        enableHtml: true
    }
    @if(Session::has('success'))
        toastr.success("{!! Session::get('success') !!}");
    @endif

    @if(Session::has('info'))
        toastr.info("{!! Session::get('info') !!}");
    @endif

    @if(Session::has('warning'))
        toastr.warning("{!! Session::get('warning') !!}");
    @endif

    @if(Session::has('error'))
        toastr.error("{!! Session::get('error') !!}");
    @endif

    @if(count($errors))
        @foreach($errors->all() as $error)
            toastr.error("{!! $error !!}");
        @endforeach
    @endif
</script>