@extends('voiler::layouts.base-index')

@section('aditional-content')
    <x-modal id="roles-modal" title="{{ __('voiler::interface.roles') }}" />
    <x-modal id="users-modal" title="{{ __('voiler::interface.users') }}" />
@endsection

@section('aditional-scripts')
    <script>
        var aditionalConfig = {
            columns: [
                { data: "name", responsivePriority: 0 },
                { data: "description" },
                { data: "roles" },
                { data: "users" },
                { data: "action", orderable: false,  width: "80px", responsivePriority: 1, searchable: false },
            ],
            select: {
                style: 'multi',
                selector: 'td:not(:nth-child(3), :nth-child(4), :last-child)'
            }
        };
    </script>
@endsection