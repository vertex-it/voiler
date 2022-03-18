@extends('voiler::layouts.master')

@section('title', __('All ' . $resource['name_plural']))

@section('breadcrumbs')
    <x-breadcrumb />

    @yield('additional-content')
@endsection

@section('master-styles')
    @yield('styles')
@endsection

@section('content')
    <div class="section w-full">
        @if (Auth::user()->can($resource['roles']['create']) && $getModelRoute('create'))
            @section('action-button')
                <a class="btn btn-primary btn-sm" href="{{ $getModelRoute('create') }}">
                    {{ __('Add ' . $resource['name_singular']) }}
                </a>
            @endsection
        @endif

        <div class="card">
            <table id="datatable" class="datatable nowrap hover" style="width: 100%">
                <thead></thead>
                <tbody></tbody>
            </table>
        </div>

        <div>
            @yield('additional-post-content')
        </div>

        <div id="custom_filters" class="hidden">
            @hasSection('filters')
                <div class="dropdown direction-down-right">
                    <button class="btn btn-sm btn-gray btn-filter btn-has-icon text-gray-600">
                        <x-heroicon-s-adjustments /> Filters
                    </button>

                    <div class="hidden dropdown-menu w-80 md:w-96 p-6" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                        <div class="filter-inputs">
                            @yield('filters')
                        </div>

                        <div class="flex justify-end">
                            <button class="btn-reset-filters text-red-500 hover:text-red-600">
                                {{ __('voiler::interface.reset_filters') }}
                            </button>
                        </div>
                    </div>
                </div>
                @push('master-scripts')
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/js/standalone/selectize.js" integrity="sha512-pF+DNRwavWMukUv/LyzDyDMn8U2uvqYQdJN0Zvilr6DDo/56xPDZdDoyPDYZRSL4aOKO/FGKXTpzDyQJ8je8Qw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
                @endpush
            @endif
        </div>

        <div id="table_buttons">
            <div class="dropdown direction-down-left h-full">
                <button class="btn btn-gray btn-has-icon px-2.5 py-1.5 h-full">
                    <x-heroicon-o-lightning-bolt />
                </button>

                <div class="hidden dropdown-menu" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                    <a href="#" class="menuitem" data-action="selectAll">{{ __('voiler::interface.select_all') }}</a>
                    <a href="#" class="menuitem" data-action="selectNone">{{ __('voiler::interface.cancel') }}</a>
                    <a href="#" class="menuitem" data-action="soft_delete">{{ __('voiler::interface.soft_delete') }}</a>
                    <a href="#" class="menuitem" data-action="restore">{{ __('voiler::interface.restore') }}</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('master-scripts')
    <script src="{{ mix('js/datatables.js') }}"></script>
    <script>
        ajaxData = function () {
            return {}
        }

        $(document).ready(function () {
            DataTable = $("#datatable").DataTable(
                Object.assign(additionalConfig, {
                    dom:
                        '<"flex flex-wrap justify-between items-center -mt-1"' +
                            '<"custom-filters">' +
                            '<"flex justify-end items-stretch" lf <"ml-2 table-buttons">>' +
                        '>' +
                        ' t ' +
                        'i p',
                    language: {
                        "sProcessing":   "Obrada u toku...",
                        "sLengthMenu":   "_MENU_",
                        "sZeroRecords":  "Nije pronađen nijedan rezultat",
                        "sInfo":         "Prikaz _START_ - _END_ od _TOTAL_ rezultata",
                        "sInfoEmpty":    "Prikaz 0 do 0 od ukupno 0 rezultata",
                        "sInfoFiltered": "(filtrirano od ukupno _MAX_ rezultata)",
                        "sInfoPostFix":  "",
                        "sSearch":       "",
                        "sSearchPlaceholder": "Pretraga...",
                        "sUrl":          "",
                        "oPaginate": {
                            "sFirst": '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" /> </svg>',
                            "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /> </svg>',
                            "sNext": '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /> </svg>',
                            "sLast": '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7" /> </svg>'
                        },
                        "select": {
                            "rows": {
                                _: "Odabrali ste %d redova",
                                0: "Kliknite na red da ga odaberete",
                                1: "Odabrali ste 1 red",
                                2: "Odabrali ste 2 reda",
                                3: "Odabrali ste 3 reda",
                                4: "Odabrali ste 4 reda",
                            }
                        }
                    },
                    searchDelay: 500,
                    processing: true,
                    serverSide: true,
                    deferRender: true,
                    stateSave: true,
                    stateDuration: 60*60*24*365,
                    fixedHeader: true,
                    scrollX: true,
                    scrollCollapse: true,
                    fixedColumns: true,
                    ajax: {
                        url: "{{ $getModelRoute('index') }}",
                        data: function (d) {
                            let customData = ajaxData()

                            for (const property in customData) {
                                d[property] = customData[property]
                            }
                        }
                    },
                    columnDefs: [],
                    rowCallback: function (row, data) {
                        if (data.deleted_at) {
                            $(row).addClass('table-row-deleted')
                        }
                    }
                })
            )

            DataTable.on('select deselect', function () {
                var selectedRows = DataTable.rows({ selected: true }).count()

                // TODO Add enable/disable buttons status
                DataTable.button(2).enable(selectedRows > 0)
                DataTable.button(3).enable(selectedRows > 0)
            })

            function deleteElement(url) {
                $.ajax({
                    method: 'DELETE',
                    url: url,
                    success: function () {
                        toastr.success('{{ __('voiler::interface.soft_delete_success') }}')
                        refreshDatatable()
                    },
                    error: function () {
                        toastr.error('{{ __('voiler::interface.there_was_an_error') }}')
                    }
                })
            }

            function restoreElement(id) {
                $.ajax({
                    method: 'PUT',
                    url: "{{ $getModelRoute('restore') }}",
                    data: {
                        id: id
                    },
                    success: function () {
                        toastr.success('{{ __('voiler::interface.restore_success') }}')
                        refreshDatatable()
                    },
                    error: function () {
                        toastr.error('{{ __('voiler::interface.there_was_an_error') }}')
                    }
                })
            }

            function forceDeleteElement(id) {
                $.ajax({
                    method: 'DELETE',
                    url: "{{ $getModelRoute('forceDelete') }}",
                    data: {
                        id: id
                    },
                    success: function () {
                        toastr.success('{{ __('voiler::interface.force_delete_success') }}')
                        refreshDatatable()
                    },
                    error: function () {
                        toastr.error('{{ __('voiler::interface.there_was_an_error') }}')
                    }
                })
            }

            function updatePriority(id, priority) {
                $.ajax({
                    method: 'PUT',
                    url: "{{ $getModelRoute('updatePriority') }}",
                    data: {
                        id: id,
                        priority: priority
                    },
                    success: function () {
                        toastr.success('{{ __('voiler::interface.priority_update_success') }}')
                        refreshDatatable()
                    },
                    error: function () {
                        toastr.error('{{ __('voiler::interface.there_was_an_error') }}')
                    }
                })
            }

            function refreshDatatable() {
                DataTable.ajax.reload()
            }

            $(document).on('click', '.modal-action-btn', function() {
                const confirmButtonClass = $(this).data('confirmButtonClass')
                const properties = $(this).data('properties')

                switch (confirmButtonClass) {
                    case 'delete-confirm':
                        deleteElement(properties)
                        break

                    case 'force-delete-confirm':
                        forceDeleteElement(properties)
                        break

                    case 'restore-confirm':
                        restoreElement(properties)
                        break
                }

                closeModal()
            })

            const body = $('body')

            body.delegate('.delete-button', 'click', function (e) {
                e.preventDefault()
                openConfirmModal($(this), 'delete-confirm', '{{ __('voiler::interface.soft_delete') }}',  'btn btn-danger')
            })

            body.delegate('.force-delete-button', 'click', function (e) {
                e.preventDefault()
                openConfirmModal($(this), 'force-delete-confirm', '{{ __('voiler::interface.force_delete') }}', 'btn btn-danger')
            })

            body.delegate('.restore-button', 'click', function (e) {
                e.preventDefault()
                openConfirmModal($(this), 'restore-confirm', '{{ __('voiler::interface.restore') }}', 'btn btn-primary')
            })

            $(document).on('click', '.update-priority-button', function () {
                let id = $(this).attr('data-id')
                let priority = $(this).parents('div.input-group').find('input[name="priority"]').val()

                updatePriority(id, priority)
            })

            let customFilters = $('#table_buttons').html()
            $('#table_buttons').remove()
            $('#datatable_wrapper div.table-buttons').html(customFilters)

            let customButtons = $('#custom_filters').html()
            $('#datatable_wrapper div.custom-filters').html(customButtons)

            $(document).on('click', 'div.table-buttons .menuitem', function () {
                let action = $(this).data('action');

                if (action === 'selectAll') {
                    DataTable.rows().select()
                }

                if (action === 'selectNone') {
                    DataTable.rows().deselect()
                }

                if (action === 'soft_delete') {
                    let data = DataTable.rows({selected: true}).data()
                    let nodes = DataTable.rows({selected: true}).nodes()

                    $(nodes).addClass('table-row-deleted')

                    $.each(data, function (i) {
                        var slug = data[i].slug

                        if (slug === undefined) {
                            slug = data[i].id
                        }

                        deleteElement("{{ $getModelRoute('destroy', '') }}/" + slug)
                    })
                }

                if (action === 'restore') {
                    let data = DataTable.rows({selected: true}).data()
                    let nodes = DataTable.rows({selected: true}).nodes()

                    $(nodes).removeClass('table-row-deleted')

                    $.each(data, function (i) {
                        restoreElement(data[i].id)
                    })
                }
            })
        })
    </script>

    @yield('scripts')
    @stack('scripts')
@endsection
