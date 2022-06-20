<div class="flex">
    <div class="dropdown direction-down-left">
        <button class="btn btn-transparent rounded-full hover:bg-gray-200 px-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
            </svg>
        </button>

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
