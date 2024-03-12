<div class="form-group">
    @include('voiler::components.inputs.includes.label')

    @foreach($getPreparedOptions() as $key => $label)
        <div class="mb-1">
            <label>
                <input
                    name="{{ $name }}"
                    type="radio"
                    value="{{ $key }}"
                    {{ $checkIfActive($key, ' checked ') }}
                    {{ $outputRequired() }}
                    {{ $attributes }}
                >
                <span class="ml-2 mb-0 form-label">{{ $label }}</span>
            </label>
        </div>
    @endforeach

    @include('voiler::components.inputs.includes.comment')
    @include('voiler::components.inputs.includes.error')
</div>
