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
                { title: 'Roles', data: "roles" },
                { title: 'Users', data: "users" },
            ],
        };
    </script>
@endsection
