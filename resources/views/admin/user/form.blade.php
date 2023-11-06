@extends('voiler::layouts.base-form')

@section('title', $getFormTitle)

@section('breadcrumbs')
    <x-breadcrumb :model="$user" />
@endsection

@section('inputs')

    <x-inputs.input
        name="name"
        :value="$user->name"
    />

    <x-inputs.input
        name="email"
        :value="$user->email"
    />

    <x-inputs.input
        name="password"
        type="password"
    />

@endsection
