@extends('voiler::layouts.base-form')

@section('title', $getFormTitle)

@section('breadcrumbs')
    <x-breadcrumb :model="$profile" />
@endsection

@section('inputs')

    <x-inputs.input
        name="name"
        type="text"
        value="{{ $profile->name }}"
        required
        label="Ime i prezime"
    />

    <x-inputs.input
        name="email"
        type="email"
        value="{{ $profile->email }}"
        required
        label="Email"
    />

    <x-inputs.input
        name="password"
        type="password"
        label="Šifra"
        placeholder="Unesite šifru"
    />

@endsection
