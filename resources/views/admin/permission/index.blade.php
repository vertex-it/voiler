@extends('voiler::layouts.base-index')

@section('additional-content')
    <x-modal id="roles-modal" title="{{ __('voiler::interface.roles') }}" />
    <x-modal id="users-modal" title="{{ __('voiler::interface.users') }}" />
@endsection

@section('scripts')
    <script>
        var additionalConfig = {
            columns: [
                { title: 'Name', data: "name", responsivePriority: 0 },
                { title: 'Description', data: "description" },
                { title: 'Roles', data: "roles" },
                { title: 'Users', data: "users" },
                { title: '', data: "action", orderable: false,  width: "80px", responsivePriority: 1, searchable: false },
            ],
            select: {
                style: 'multi',
                selector: 'td:not(:nth-child(3), :nth-child(4), :last-child)'
            }
        };
    </script>
@endsection
