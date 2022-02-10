<div class="relative btn-click-dropdown">
    <button type="button" class="btn btn-transparent btn-sm">
        <x-heroicon-o-dots-vertical width="22px" height="22px" class="float-left" />
    </button>
    <div class="dropdown mt-3 hidden right-0">
        @can($resource['name_plural'] . ' update')
            <a class="item" href="{{ $getModelRoute('show', $model) }}">
                {{ __('voiler::interface.show') }}
            </a>
        @endcan
    </div>
</div>


