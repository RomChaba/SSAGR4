function popup_loader(e, t) {
    loc = '/';
    if (window.location.origin == 'https://blog.dreamstime.com') loc = 'https://www.dreamstime.com/';
    if ($('.popup').length > 0) $('.popup').remove();
    $('body').append('<div class="popup" style="display:none;" id="' + t + '"></div>');
    $('#' + t).load(loc + e, function () {
        $('html').addClass('documentLocked');
        $('#' + t).addClass('show')
    })
}