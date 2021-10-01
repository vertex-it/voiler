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
            label="Naziv"
            placeholder="Unesite naziv dozvole"
            required
    />

    <x-inputs.textarea
            name="description"
            label="Opis"
            :value="$permission->description"
    />

    <x-inputs.select
            name="roles"
            label="Uloge"
            placeholder="Odaberite uloge..."
            :options="$roles"
            :value="$activeRoles"
            selectize
            multiple
    />

@endsection