@extends('voiler::layouts.base-index')

@section('additional-content')
    <x-modal id="activity-modal" title="{{ __('voiler::interface.activity') }}" />
@endsection

@section('scripts')
    <script>
        var additionalConfig = {
            columns: [
                { title: 'Causer', data: "causer.name", orderable: false },
                { title: 'Model', data: "subject_type" },
                { title: 'Value', data: "subject.slug", orderable: false },
                { title: 'Action', data: "description" },
                { title: 'Date', data: 'created_at_formatted', name: 'created_at' },
                { title: '', data: "action", searchable: false, orderable: false, width: "60px" },
            ],
            select: {
                style: 'multi',
                selector: 'td:not(:last-child)'
            },
            order: [[4, 'desc']],
        };
    </script>
@endsection
