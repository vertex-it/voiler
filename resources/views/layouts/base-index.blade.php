@extends('voiler::layouts.master')

@section('title', __('All ' . $resource['name_plural']))

@section('breadcrumbs')
    <x-breadcrumb />
    @yield('aditional-content')
@endsection

@section('styles')
    @yield('aditional-styles')
@endsection

@section('content')
    <div class="section w-full">
        @can($resource['roles']['create'])
            @section('action-button')
                <a class="btn btn-primary btn-sm px-5" href="{{ $getModelRoute('create') }}">
                    {{ __('Add ' . $resource['name_singular']) }}
                </a>
            @endsection
        @endcan

        <div class="section-content">
            <div class="card">
                <table id="datatable" class="datatable hover">
                    <thead>
                        @foreach ($datatableColumns as $column)
                            <th>{{ __(ucfirst($column)) }}</th>
                        @endforeach
                    </thead>
                    <tbody></tbody>
                </table>
            </div>

            <div>
                @yield('aditional-post-content')
            </div>
        </div>

        <div id="custom_buttons" class="hidden">
            <div class="dropdown direction-down-left">
                <a class="btn btn-white p-1.5" href="#" aria-current="page" aria-expanded="false" aria-haspopup="true">
                    <x-heroicon-o-dots-horizontal width="22px" height="22px" />
                </a>

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

@section('scripts')
    <script>
        ajaxData = function () {
            return {}
        }

        $(document).ready(function () {
            DataTable = $("#datatable").DataTable(
                Object.assign(aditionalConfig, {
                    dom: '<"custom-filters"> <"flex justify-end" f <"ml-2 custom-buttons">> t li p',
                    language: {
                        "sProcessing":   "Obrada u toku...",
                        "sLengthMenu":   "Prikažite _MENU_ rezultata",
                        "sZeroRecords":  "Nije pronađen nijedan rezultat",
                        "sInfo":         "Prikaz _START_ do _END_ od ukupno _TOTAL_ rezultata",
                        "sInfoEmpty":    "Prikaz 0 do 0 od ukupno 0 rezultata",
                        "sInfoFiltered": "(filtrirano od ukupno _MAX_ rezultata)",
                        "sInfoPostFix":  "",
                        "sSearch":       "",
                        "sSearchPlaceholder": "Pretraga...",
                        "sUrl":          "",
                        "oPaginate": {
                            "sFirst":    "Početna",
                            "sPrevious": "Prethodna",
                            "sNext":     "Sledeća",
                            "sLast":     "Poslednja"
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
                    responsive: {
                        details: {
                            display: $.fn.dataTable.Responsive.display.modal({
                                header: function (row) {
                                    var data = row.data()
                                    return '{{ __('voiler::interface.details_for') }} ' + data.{{ $resource['title_column'] }}
                                }
                            }),
                            renderer: $.fn.dataTable.Responsive.renderer.tableAll({
                                tableClass: 'table'
                            })
                        }
                    },
                    rowCallback: function (row, data) {
                        if (data.deleted_at) {
                            $(row).addClass('text-red-400')
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
                openConfirmModal($(this), 'delete-confirm', '{{ __('voiler::interface.soft_delete') }}',  'btn btn-sm btn-danger')
            })

            body.delegate('.force-delete-button', 'click', function (e) {
                e.preventDefault()
                openConfirmModal($(this), 'force-delete-confirm', '{{ __('voiler::interface.force_delete') }}', 'btn btn-sm btn-danger')
            })

            body.delegate('.restore-button', 'click', function (e) {
                e.preventDefault()
                openConfirmModal($(this), 'restore-confirm', '{{ __('voiler::interface.restore') }}', 'btn btn-sm btn-primary')
            })

            $(document).on('click', '.update-priority-button', function () {
                let id = $(this).attr('data-id')
                let priority = $(this).parents('div.input-group').find('input[name="priority"]').val()

                updatePriority(id, priority)
            })

            let customFilters = $('#table_filters').html()
            $('#table_filters').remove()
            $('#datatable_wrapper div.custom-filters').html(customFilters)

            let customButtons = $('#custom_buttons').html()
            $('#datatable_wrapper div.custom-buttons').html(customButtons)

            $(document).on('click', 'div.custom-buttons .menuitem', function () {
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

                    $(nodes).addClass('text-red-400')

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

                    $(nodes).removeClass('text-red-400')

                    $.each(data, function (i) {
                        restoreElement(data[i].id)
                    })
                }
            })
        })
    </script>

    @yield('aditional-scripts')
@endsection
