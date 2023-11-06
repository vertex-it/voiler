// Datatable filters
$(document).ready(function () {
    $(document).on('change', '.filter-inputs select, input[name="show_deleted"]', function () {
        DataTable.ajax.reload()

        toggleFiltersBtnActiveClass()
    })

    $(document).on('click', '.btn-reset-filters', function (e) {
        e.preventDefault()

        let filterInputs = $('.filter-inputs').children()

        $.each(filterInputs, function (i, element) {
            // TODO only works for selectize filters
            let selectizeInstance = $(element).find('.selectize')
            selectizeInstance[0].selectize.clear()
        })

        toggleFiltersBtnActiveClass()
    })
})

function toggleFiltersBtnActiveClass() {
    let hasActiveFilters = false

    let filterInputs = $('.filter-inputs').children()

    $.each(filterInputs, function (i, element) {
        // TODO only works for selectize filters
        let value = $(element).find('option:selected').text()

        if (value && value !== '') {
            hasActiveFilters = true
        }
    })

    if (hasActiveFilters) {
        $('.btn-filter').addClass('active')
    } else {
        $('.btn-filter').removeClass('active')
    }
}

// Dropdowns
document.addEventListener('DOMContentLoaded', function () {
    // close all inner dropdowns when parent is closed
    document.querySelectorAll('.navbar .dropdown').forEach(function (everydropdown) {
        everydropdown.addEventListener('hidden.bs.dropdown', function () {
            // after dropdown is hidden, then find all submenus
            this.querySelectorAll('.submenu').forEach(function (everysubmenu) {
                // hide every submenu as well
                everysubmenu.style.display = 'none'
            })
        })
    })

    document.querySelectorAll('.dropdown-menu a').forEach(function (element) {
        element.addEventListener('click', function (e) {
            let nextEl = this.nextElementSibling
            if (nextEl && nextEl.classList.contains('submenu')) {
                // prevent opening link if link needs to open dropdown
                e.preventDefault()
                if (nextEl.style.display === 'block') {
                    nextEl.style.display = 'none'
                } else {
                    nextEl.style.display = 'block'
                }

            }
        })
    })
})

$('.mobile-menu-close, .mobile-menu-open').click(function () {
    $('#mobile-menu').toggleClass('closed')
})