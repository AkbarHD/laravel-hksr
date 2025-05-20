<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    // Smooth scrolling for anchor links
    $(document).ready(function() {
        $('a[href^="#"]').on('click', function(e) {
            e.preventDefault();

            var target = this.hash;
            var $target = $(target);

            $('html, body').stop().animate({
                'scrollTop': $target.offset().top - 70
            }, 900, 'swing', function() {
                window.location.hash = target;
            });
        });

        // Add padding-top to body equal to navbar height
        $('body').css('padding-top', $('.navbar').outerHeight() + 'px');

        // Navbar change on scroll
        $(window).scroll(function() {
            if ($(this).scrollTop() > 50) {
                $('.navbar').addClass('shadow').css('background-color',
                    'rgba(29, 53, 87, 1) !important');
            } else {
                $('.navbar').removeClass('shadow').css('background-color',
                    'rgba(29, 53, 87, 0.9) !important');
            }
        });
    });
</script>
