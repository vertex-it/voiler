import { enter, leave, toggle } from 'el-transition'

// Add transition effects to each dropdown
$(document).ready(function () {
    $('div:not(.nav-mobile.item) .dropdown > .dropdown-menu').each(function () {
        if ($(this).is('.nav-mobile-item *')) {
            return
        }

        // TODO Add animation for slide down - slide up

        $(this).attr('data-transition-enter', 'transition ease-out duration-200')
        $(this).attr('data-transition-enter-start', 'transform opacity-0 scale-95')
        $(this).attr('data-transition-enter-end', 'transform opacity-100 scale-100')
        $(this).attr('data-transition-leave', 'transition ease-in duration-75')
        $(this).attr('data-transition-leave-start', 'transform opacity-100 scale-100')
        $(this).attr('data-transition-leave-end', 'transform opacity-0 scale-95')
    })
})

// Dropdown toggle
$(document).on('click', '.dropdown > :first-child', function (e) {
    e.preventDefault()
    e.stopPropagation()

    let menu = $(this).siblings('.dropdown-menu')

    if (menu.hasClass('hidden') && ! menu.parent('.dropdown').hasClass('submenu')) {
        $('.dropdown > .dropdown-menu:not(.hidden)').each(function () {
            leave($(this).get(0))
        })
    }

    menu.parents('.dropdown').each(function () {
        $(this).addClass('parent')
    })

    if (menu.parent('.dropdown').hasClass('submenu')) {
        menu.parents('.dropdown').each(function () {
            $(this).addClass('parent')
        })

        $('.dropdown.submenu:not(.parent) > .dropdown-menu:not(.hidden)').each(function () {
            leave($(this).get(0))
        })

        $('.dropdown.parent').each(function () {
            $(this).removeClass('parent')
        })
    }

    toggle(menu.get(0))
})

// Close open dropdown on click outside of it
$(document).on('click', function (e) {
    if (! $(this).is('.dropdown *') && ! $(e.target).is('.dropdown *')) {
        $('.dropdown-menu:not(.hidden)').each(function () {
            leave($(this).get(0))
        })
    }
})

// Mobile menu dropdown toggle
$('.mobile-menu-open, .mobile-menu-close').on('click', function() {
    $('#mobile-menu').toggle()
})



// Datatable filters
$(document).ready(function () {
    $(document).on('change', '.filter-inputs select, input[name="show_deleted"]', function () {
        DataTable.ajax.reload();

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
