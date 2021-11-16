@extends('voiler::layouts.base-form')

@section('title', $getFormTitle)

@section('breadcrumbs')
    <x-breadcrumb :model="$role" />
@endsection

@section('inputs')
    <x-inputs.input
        type="text"
        name="name"
        :value="$role->name"
        label="{{ __('voiler::interface.role_name') }}"
        placeholder="{{ __('voiler::interface.please_enter_role_name') }}"
        required
    />

    <x-inputs.textarea
        name="description"
        label="{{ __('voiler::interface.role_description') }}"
        :value="$role->description"
    />

    <x-inputs.select
        name="permissions"
        label="{{ __('voiler::interface.permissions') }}"
        placeholder="{{ __('voiler::interface.please_choose_permissions_assigned_to_role') }}"
        :options="$permissions"
        :value="$activePermissions"
        selectize
        multiple
    />

    <x-inputs.select
        name="users"
        label="{{ __('voiler::interface.users') }}"
        placeholder="{{ __('voiler::interface.please_choose_users_assigned_to_role') }}"
        :options="$users"
        :value="$activeUsers"
        selectize
        multiple
    />
@endsection
