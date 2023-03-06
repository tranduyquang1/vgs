$(document).on('click', '.banner-tournament', function(e) {
    // e.preventDefault();
    let url = $(this).data('url');
    let href = $(this).attr('href');
    $.ajax({
        url: url,
        type: 'GET',
        dataType: 'json',
        success: function(result) {}
    });
});