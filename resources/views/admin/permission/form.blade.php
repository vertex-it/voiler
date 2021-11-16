@extends('voiler::layouts.base-form')

@section('title', $getFormTitle)

@section('breadcrumbs')
    <x-breadcrumb :model="$permission" />
@endsection

@section('inputs')
    <x-inputs.input
        type="text"
        name="name"
        :value="$permission->name"
        label="{{ __('voiler::interface.permission_name') }}"
        placeholder="{{ __('voiler::interface.please_enter_permission_name') }}"
        required
    />

    <x-inputs.textarea
        name="description"
        label="{{ __('voiler::interface.permission_description') }}"
        :value="$permission->description"
    />

    <x-inputs.select
        name="roles"
        label="{{ __('voiler::interface.permission_roles') }}"
        placeholder="{{ __('voiler::interface.permission_roles_picker') }}"
        :options="$roles"
        :value="$activeRoles"
        selectize
        multiple
    />
@endsection
