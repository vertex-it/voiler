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
        label="Naziv"
        placeholder="Unesite naziv uloge"
        required
    />

    <x-inputs.textarea
        name="description"
        label="Opis"
        :value="$role->description"
    />

    <x-inputs.select
        name="permissions"
        label="Dozvole"
        placeholder="Odaberite dozvole..."
        :options="$permissions"
        :value="$activePermissions"
        selectize
        multiple
    />

    <x-inputs.select
        name="users"
        label="Korisnici"
        placeholder="Odaberite korisnike..."
        :options="$users"
        :value="$activeUsers"
        selectize
        multiple
    />
@endsection
