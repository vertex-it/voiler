@if (isset($statusColor))
    <div
        class="status-pill {{ $statusColor }}"
        title="{{ $statusTitle }}"
    ></div>
@else
    <div
        class="status-pill {{ $status ? 'bg-green-400' : 'bg-red-400' }}"
        title="{{ $status ? __('voiler::interface.active') : __('voiler::interface.inactive') }}"
    ></div>
@endif
