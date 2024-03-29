@include('voiler::components.inputs.includes.inlinable-top')

<div class="flex items-center w-full">
    <label for="{{ $getId }}" class="flex items-center cursor-pointer">
        <div class="relative">
            <input
                type="checkbox"
                id="{{ $getId }}"
                class="sr-only"
                name="{{ $name }}"
                value="1"
                {{ old($name, $value) ? ' checked ' : '' }}
                {{ $attributes }}
            >
            <div class="toggle-background block bg-gray-200 w-10 h-6 rounded-full"></div>
            <div class="dot absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition"></div>
        </div>
        <div class="ml-3 mb-0 form-label">
            {{ $getLabel }} @if ($required)<span class="text-red-500">*</span>@endif
        </div>
    </label>
</div>

@include('voiler::components.inputs.includes.comment')
@include('voiler::components.inputs.includes.error')
@include('voiler::components.inputs.includes.inlinable-bottom')
