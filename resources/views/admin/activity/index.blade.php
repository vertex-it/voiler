@extends('voiler::layouts.base-index')

@section('aditional-content')
    <x-modal id="activity-modal" title="{{ __('voiler::interface.activity') }}" />
@endsection

@section('aditional-scripts')
    <script>
        var aditionalConfig = {
            columns: [
                { data: "causer.name", orderable: false },
                { data: "subject_type" },
                { data: "subject.slug", orderable: false },
                { data: "description" },
                { data: "action", searchable: false, orderable: false, width: "60px" },
            ],
            select: {
                style: 'multi',
                selector: 'td:not(:last-child)'
            }
        };
    </script>
@endsection