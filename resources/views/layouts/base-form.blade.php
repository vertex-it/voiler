@extends('voiler::layouts.master')

@section('content')
    <div class="section">
        <div class="section-content">
            <div class="card">
                <x-form
                    action="{{ $getFormAction }}"
                    method="{{ $getFormMethod }}"
                    buttonText="Sačuvajte"
                    multipart
                    button="{{ $hasButton ?? true }}"
                >
                    @yield('inputs')
                </x-form>
                @if (! ($hasButton ?? true))
                    @yield('confirm-button')
                @endif
            </div>
        </div>
    </div>
@endsection
