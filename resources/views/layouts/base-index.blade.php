@extends('voiler::layouts.master')

@section('title', __('All ' . $resource['title_plural']))

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
                <a class="btn btn-primary" href="{{ $getModelRoute('create') }}">
                    {{ __('Add ' . $resource['title_singular']) }}
                </a>
            @endsection
        @endif

        <div class="card">
            <table id="datatable" class="datatable hover" style="width: 100%">
                <thead></thead>
                <tbody></tbody>
            </table>
        </div>

        <div>
            @yield('additional-post-content')
        </div>

        <div id="table_custom_filters" class="hidden">
            @hasSection('filters')
                <div class="dropdown">
                    <button class="table-select-actions-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                        </svg>
                         Filters
                    </button>

                    <div class="dropdown-menu w-80 md:w-96 p-6">
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
{{--                    TODO --}}
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/js/standalone/selectize.js" integrity="sha512-pF+DNRwavWMukUv/LyzDyDMn8U2uvqYQdJN0Zvilr6DDo/56xPDZdDoyPDYZRSL4aOKO/FGKXTpzDyQJ8je8Qw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
                @endpush
            @endif
        </div>

        <div id="table_buttons">
            <div class="dropdown">
                <button class="table-select-actions-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    Akcije odabira
                </button>

                <div class="dropdown-menu" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                    <a href="#" class="dropdown-item" data-action="soft_delete">{{ __('voiler::interface.soft_delete') }}</a>
                    <a href="#" class="dropdown-item" data-action="restore">{{ __('voiler::interface.restore') }}</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('master-scripts')
    <script src="{{ mix('js/datatables.js') }}"></script>
{{--   TODO --}}
    <script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.colVis.min.js"></script>
    <script>
        ajaxData = function () {
            return {}
        }

        $(document).ready(function () {
            // Order by first column if custom order is not set
            if (! additionalConfig.order) {
                additionalConfig.order = [1, 'asc']
            }

            // Add select to the first column
            additionalConfig.columns.unshift({
                title: '',
                defaultContent: '',
                searchable: false,
                orderable: false,
                className: 'select-checkbox',
                width: '40px',
                responsivePriority: 1,
                render: $.fn.dataTable.render.select(),
            })

            // Add actions to the last column
            additionalConfig.columns.push({
                title: '',
                data: "action",
                searchable: false,
                orderable: false,
                width: "40px",
                responsivePriority: 1,
            })

            DataTable = $("#datatable").DataTable(
                Object.assign(additionalConfig, {
                    layout: {
                        topStart: {
                            // Show colvis if there is more than 5 + 2 columns
                            buttons: additionalConfig.columns.length > 7 ?
                            [
                                {
                                    extend: 'colvis',
                                    popoverTitle: 'Prikazane kolone',
                                    columns: ':not(:first-child, :nth-child(2), :last-child)',
                                    postfixButtons: ['colvisRestore'],
                                    text: 'Prikazane kolone'
                                }
                            ]
                            : [],
                            div: {
                                className: 'custom-filters',
                            }
                        },
                        topEnd: {
                            search: {
                                placeholder: 'Pretraga',
                            },
                            pageLength: {
                                menu: [ 10, 15, 25, 50, 100 ]
                            },
                            div: {
                                className: 'table-select-actions',
                            }
                        },
                        bottomStart: {
                            info: true,
                        },
                        bottomEnd: {
                            paging: {
                                firstLast: true,
                            },
                        },
                    },
                    pageLength: 15,
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
                        "sLoadingRecords": "Učitavanje rezultata",
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
                                0: "",
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
                    responsive: {
                        details: {
                            type: 'column',
                            target: 1,
                        }
                    },
                    deferRender: true,
                    // stateSave: false, // TODO set to true
                    // stateDuration: 60*60*24*365,
                    fixedHeader: {
                        header: true,
                        footer: false,
                    },
                    select: {
                        style: 'multi',
                        selector: 'td:first-child',
                    },
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

            let customButtons = $('#table_buttons').html()
            $('#table_buttons').remove()
            $('#datatable_wrapper div.table-select-actions').html(customButtons)

            let customFilters = $('#table_custom_filters').html()
            $('#datatable_wrapper div.custom-filters').html(customFilters)

            $(document).on('click', 'div.table-select-actions .dropdown-item', function () {
                let action = $(this).data('action');

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
