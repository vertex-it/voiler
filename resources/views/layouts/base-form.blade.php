@extends('voiler::layouts.master')

@section('content')
    <div class="section">
        <div class="section-content">
            <div class="card">
                <x-form
                    action="{{ $getFormAction }}"
                    method="{{ $getFormMethod }}"
                    buttonText="{{ __('voiler::interface.save') }}"
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

@section('scripts')
    <script src="{{ mix('js/blade-components.js') }}"></script>
@endsection
