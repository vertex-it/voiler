@extends('voiler::layouts.base-index')

@section('scripts')
    <script>
        var additionalConfig = {
            columns: [
                { data: "name" },
                { data: "email" },
                { data: "action", searchable: false, orderable: false, width: "40px",  responsivePriority: 1 },
            ],
            select: {
                style: 'multi',
                selector: 'td:not(:last-child)'
            }
        };
    </script>
@endsection
