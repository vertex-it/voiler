@extends('voiler::layouts.master')

@section('content')
    <div class="section max-w-full lg:max-w-4xl">
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

@section('master-scripts')
    <script src="{{ mix('js/blade-components.js') }}"></script>

    @yield('scripts')
@endsection
