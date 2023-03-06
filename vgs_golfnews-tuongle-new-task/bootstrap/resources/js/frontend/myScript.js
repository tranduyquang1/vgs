/* List event document ready */
$(document).ready(function () {
    // let $scrollHref = $('.scroll-href');
    //
    // /* Scroll href */
    // $scrollHref.click((e) => {
    //     let href = $(e.target).attr("href");
    //     $('html, body').animate({
    //         scrollTop: $(href).offset().top - 200
    //     }, 500);
    //     return false;
    // });


    // lazyload
    // var lazyLoadInstance = new LazyLoad({
    //     elements_selector: ".lazy",
    //     load_delay: 0,
    //     threshold: 10
    // });
    //
    // // Count down
    // $('.countdown').countDown();


});

// create plugin jquery countdown
(function ($) {
    $.fn.countDown = function (options = null) {
        let $this = $(this);
        let date = $this.data('date');
        let countDownDate = new Date(date).getTime();
        // Update the count down every 1 second
        let x = setInterval(function () {

            // Get today's date and time
            let now = new Date().getTime();

            // Find the distance between now and the count down date
            let distance = countDownDate - now;

            // Time calculations for days, hours, minutes and seconds
            let days = Math.floor(distance / (1000 * 60 * 60 * 24));
            let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            let seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Show time
            $this.find('#days').text(days);
            $this.find('#hours').text(hours);
            $this.find('#minutes').text(minutes);
            $this.find('#seconds').text(seconds);

            // If the count down is finished, write some text
            if (distance < 0) {
                clearInterval(x);
                // Reset time
                $this.find('#days').text(0);
                $this.find('#hours').text(0);
                $this.find('#minutes').text(0);
                $this.find('#seconds').text(0);
            }
        }, 1000);
    }
}(jQuery));