<div class="flex">
    <div class="dropdown direction-down-left">
        <a class="btn btn-transparent hover:bg-white hover:border hover:border-gray-200 text-gray-700 p-1.5" href="#" aria-current="page" aria-expanded="false" aria-haspopup="true">
            <x-heroicon-o-dots-horizontal width="22px" height="22px" />
        </a>

        <div class="hidden dropdown-menu" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
            @hasSection('datatable-custom-actions')
                @yield('datatable-custom-actions')

                <hr class="my-1">
            @endif

            @if(method_exists($model, 'trashed') && $model->trashed())
                @can($resource['roles']['restore'])
                    <x-modal-button
                        id="{{ $model->id }}"
                        title="{{ __('voiler::interface.are_you_sure') }}"
                        content="{{ __('voiler::interface.restored_element_will_be_active') }}"
                        buttonClass="menuitem text-left"
                        confirmButtonClass="restore-button"
                        icon='<svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>'
                    >
                        {{ __('voiler::interface.restore') }}
                    </x-modal-button>
                @endcan

                @can($resource['roles']['forceDelete'])
                    <x-modal-button
                        id="{{ $model->id }}"
                        title="{{ __('voiler::interface.are_you_sure') }}"
                        content="{{ __('voiler::interface.you_will_not_be_able_to_undo_this_action') }}"
                        buttonClass="menuitem text-left"
                        confirmButtonClass="force-delete-button"
                        icon='<svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>'
                    >
                        {{ __('voiler::interface.force_delete') }}
                    </x-modal-button>
                @endcan
            @elseif(Gate::check($resource['roles']['update']) || Gate::check($resource['roles']['create']) || Gate::check($resource['roles']['delete']))
                @can($resource['roles']['update'])
                    <a class="menuitem" href="{{ $getModelRoute('edit', $model) }}">
                        {{ __('voiler::interface.edit') }}
                    </a>
                @endcan

                @can($resource['roles']['create'])
                    <a class="menuitem" href="{{ $getModelRoute('clone', $model) }}">
                        {{ __('voiler::interface.duplicate') }}
                    </a>
                @endcan

                @can($resource['roles']['delete'])
                    <x-modal-button
                        id="{{ $getModelRoute('destroy', $model) }}"
                        title="{{ __('voiler::interface.are_you_sure') }}"
                        content="{{ __('voiler::interface.soft_deleted_element_is_restorable') }}"
                        buttonClass="menuitem text-left"
                        confirmButtonClass="delete-button"
                        icon='<svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>'
                    >
                        {{ __('voiler::interface.soft_delete') }}
                    </x-modal-button>
                @endcan
            @endif
        </div>
    </div>
</div>
