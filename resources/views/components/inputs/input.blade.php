@include('voiler::components.inputs.includes.inlinable-top')
@include('voiler::components.inputs.includes.label')

<input
    class="form-input @error($name) has-error @enderror"
    id="{{ $getId }}"
    name="{{ $name }}"
    placeholder="{{ $getPlaceholder() }}"
    type="{{ $type }}"
    value="{!! old($name, $value) !!}"
    {{ $outputRequired() }}
    {{ $attributes }}
>

@include('voiler::components.inputs.includes.comment')
@include('voiler::components.inputs.includes.error')
@include('voiler::components.inputs.includes.inlinable-bottom')
