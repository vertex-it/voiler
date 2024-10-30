@extends('voiler::layouts.base-index')

@section('additional-content')
    <x-modal id="permissions-modal" title="{{ __('voiler::interface.permissions') }}" />
    <x-modal id="users-modal" title="{{ __('voiler::interface.users') }}" />
@endsection

@section('scripts')
    <script>
        var additionalConfig = {
            columns: [
                { title: 'Name', data: "name", responsivePriority: 0 },
                { title: 'Permissions', data: "permissions" },
                { title: 'Users', data: "users" },
            ],
        };
    </script>
@endsection
