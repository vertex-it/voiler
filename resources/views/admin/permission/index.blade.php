@extends('voiler::layouts.base-index')

@section('aditional-content')
    <x-modal id="roles-modal" title="{{ __('voiler::interface.roles') }}" />
    <x-modal id="users-modal" title="{{ __('voiler::interface.users') }}" />
@endsection

@section('aditional-scripts')
    <script>
        var aditionalConfig = {
            columns: [
                { title: 'name', data: "name", responsivePriority: 0 },
                { title: 'description', data: "description" },
                { title: 'roles', data: "roles" },
                { title: 'users', data: "users" },
                { title: '', data: "action", orderable: false,  width: "80px", responsivePriority: 1, searchable: false },
            ],
            select: {
                style: 'multi',
                selector: 'td:not(:nth-child(3), :nth-child(4), :last-child)'
            }
        };
    </script>
@endsection
