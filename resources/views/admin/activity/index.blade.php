@extends('voiler::layouts.base-index')

@section('aditional-content')
    <x-modal id="activity-modal" title="{{ __('voiler::interface.activity') }}" />
@endsection

@section('aditional-scripts')
    <script>
        var aditionalConfig = {
            columns: [
                { title: 'causer', data: "causer.name", orderable: false },
                { title: 'model', data: "subject_type" },
                { title: 'value', data: "subject.slug", orderable: false },
                { title: 'action', data: "description" },
                { title: '', data: "action", searchable: false, orderable: false, width: "60px" },
            ],
            select: {
                style: 'multi',
                selector: 'td:not(:last-child)'
            }
        };
    </script>
@endsection
