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
                >
                    @yield('inputs')
                </x-form>
            </div>
        </div>
    </div>
@endsection
