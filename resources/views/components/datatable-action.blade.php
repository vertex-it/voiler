@if(method_exists($model, 'trashed') && $model->trashed())
    @can($resource['name_plural'] . ' restore')
        <x-modal-button
            id="{{ $model->id }}"
            title="Da li ste sigurni?"
            content="Da li ste sigurni da želite vratiti ovaj element?"
            buttonClass="btn btn-green-400"
            confirmButtonClass="restore-button"
            icon='<svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>'
        >
            Restore
        </x-modal-button>
    @endcan

    @can($resource['name_plural'] . ' forceDelete')
        <x-modal-button
            id="{{ $model->id }}"
            title="Da li ste sigurni?"
            content="Ukoliko trajno obrišete element, nećete ga više moći vratiti"
            buttonClass="btn btn-sm btn-danger m-0"
            confirmButtonClass="force-delete-button"
            icon='<svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>'
        >
            Force delete
        </x-modal-button>
    @endcan
@else
    @if(Gate::check($resource['name_plural'] . ' update') || Gate::check($resource['name_plural'] . ' create') || Gate::check($resource['name_plural'] . ' delete'))
        <div class="relative btn-click-dropdown">
            <button type="button" class="btn btn-transparent btn-sm">
                <x-heroicon-o-dots-vertical width="20px" height="20px" class="float-left" />
            </button>
            <div class="dropdown mt-3 hidden right-0">
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
                    <x-modal-button
                        id="{{ $getModelRoute('destroy', $model) }}"
                        title="Da li ste sigurni?"
                        content="Ukoliko obrišete element, možete ga kasnije vratiti"
                        buttonClass="btn btn-sm btn-danger m-0"
                        confirmButtonClass="delete-button"
                        icon='<svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>'
                    >
                        Delete
                    </x-modal-button>
                @endcan
            </div>
        </div>
    @endif
@endif

