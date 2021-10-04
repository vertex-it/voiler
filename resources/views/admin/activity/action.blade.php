<div>
    <button type="button" class="btn btn-click-dropdown">
        <x-heroicon-o-dots-horizontal width="20px" height="20px" class="float-left" />
    </button>
    <div class="dropdown mt-3 hidden">
        @can($resource['name_plural'] . ' update')
            <a class="item" href="{{ $getModelRoute('show', $model) }}">
                Prikažite
            </a>
        @endcan
    </div>
</div>


