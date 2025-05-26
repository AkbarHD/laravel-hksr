<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
{{-- sweetalert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.js"></script>
<script>
    // Smooth scrolling for anchor links
    $(document).ready(function() {

        @if (Session::has('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: "{{ Session::get('success') }}",
                showConfirmButton: true,
                timer: 1500
            });
        @endif

        @if ($errors->any())
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal menyimpan data!',
                    html: `{!! implode('<br>', $errors->all()) !!}`,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Oke, mengerti'
                });
            });
        @endif


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
