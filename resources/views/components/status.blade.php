@if (isset($statusColor))
    <div
        class="status-pill {{ $statusColor }}"
        title="{{ $statusTitle }}"
    ></div>
@else
    <div
        class="status-pill {{ $status ? 'green' : 'red' }}"
        title="{{ $status ? __('Active') : __('Inactive') }}"
    ></div>
@endif
