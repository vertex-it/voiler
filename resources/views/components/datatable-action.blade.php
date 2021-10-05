@if(method_exists($model, 'trashed') && $model->trashed())
    @can($resource['name_plural'] . ' restore')
        <button
            class="btn btn-sm btn-primary m-0 restore-button"
            data-id="{{ $model->id }}"
        >
            <i class="os-icon os-icon-common-07"></i>
        </button>
    @endcan

    @can($resource['name_plural'] . ' forceDelete')
        <button
            class="btn btn-sm btn-danger m-0 force-delete-button"
            data-id="{{ $model->id }}"
        >
            <i class="os-icon os-icon-close"></i>
        </button>
    @endcan
@else
    @if(Gate::check($resource['name_plural'] . ' update') || Gate::check($resource['name_plural'] . ' create') || Gate::check($resource['name_plural'] . ' delete'))
        <div class="relative btn-click-dropdown">
            <button type="button" class="btn btn-transparent btn-sm">
                <x-heroicon-o-dots-horizontal width="20px" height="20px" class="float-left" />
            </button>
            <div class="dropdown mt-3 hidden">
                @can($resource['name_plural'] . ' update')
                    <a
                        class="item"
                        href="{{ $getModelRoute('edit', $model) }}"
                    >
                        Izmjenite
                    </a>
                @endcan

                @can($resource['name_plural'] . ' create')
                    <a
                        class="item"
                        href="{{ $getModelRoute('clone', $model) }}"
                    >
                        Kopirajte
                    </a>
                @endcan

                @can($resource['name_plural'] . ' delete')
                    <a
                        class="item delete-button"
                        data-url="{{ $getModelRoute('destroy', $model) }}"
                        href="#"
                    >
                        Obrišite
                    </a>
                @endcan
            </div>
        </div>
    @endif
@endif

