@extends('voiler::layouts.base-form')

@section('title', $getFormTitle)

@section('breadcrumbs')
    <div class="breadcrumbs">
        <a href="{{ route('admin.dashboard') }}" class="item item-link">{{ config('app.name') }}</a>
        <span class="separator">/</span>
        <span class="item item-last">@yield('title')</span>
    </div>
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
