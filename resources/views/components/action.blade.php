@if(method_exists($model, 'trashed') && $model->trashed())
    @if($resource['name_plural'] . ' restore')
        <button
                class="btn btn-sm btn-success m-0 restore-button"
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
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-light btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <x-heroicon-o-dots-horizontal width="20px" height="20px" class="float-left" />
            </button>
            <div class="dropdown-menu dropdown-menu-right">

                @can($resource['name_plural'] . ' update')
                    <a class="dropdown-item" href="{{ $getModelRoute('edit', $model) }}">
                        Izmjenite
                    </a>
                @endcan

                @can($resource['name_plural'] . ' create')
                    <a class="dropdown-item" href="{{ $getModelRoute('clone', $model) }}">
                        Kopirajte
                    </a>
                @endcan

                <div class="dropdown-divider"></div>

                @can($resource['name_plural'] . ' delete')
                    <a
                            class="dropdown-item delete-button"
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
