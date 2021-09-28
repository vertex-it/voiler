$('.modal-open').on('click', function () {
    $('.modal').fadeIn()
})

$('body').delegate('.modal-close', 'click', function () {
    $('.modal').fadeOut()
})