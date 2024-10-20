@push('css')
    {!! push_asset_once(['css/plugins/slick/slick.css', 'css/plugins/slick/slick-theme.css']) !!}
    {{-- @once
        <link rel="stylesheet" href="{{ asset('css/project_managers/project_managers.css') }}">
        <link rel="stylesheet" href="{{ asset('css/plugins/sweetalert/sweetalert.css') }}" >
    @endonce --}}
@endpush
<div class="row justify-content-md-center">
    <div class="col-lg-11">
        <h3 class="text-left">
            Multiple example with responsive breakpoints
        </h3>
        <div class="cards row animated fadeInRight">
            <x-project-manager.card-activity />
            <x-project-manager.card-activity />
            <x-project-manager.card-activity />
            <x-project-manager.card-activity />
            <x-project-manager.card-activity />
            <x-project-manager.card-activity />
            <x-project-manager.card-activity />
        </div>
    </div>
</div>

@push('js')
    {!! push_asset_once(['js/plugins/slick/slick.min.js', 'js/plugins/slimscroll/jquery.slimscroll.min.js']) !!}
    @once
        <script>
            $(document).ready(function() {
                let $carousel = $('.cards').slick({
                    infinite: true,
                    slidesToShow: 4,
                    slidesToScroll: 1,
                    arrows: true,
                    dots: true,
                    responsive: [{
                            breakpoint: 1024,
                            settings: {
                                slidesToShow: 3,
                                slidesToScroll: 1,
                                infinite: true,
                                dots: true
                            }
                        },
                        {
                            breakpoint: 800,
                            settings: {
                                slidesToShow: 2,
                                slidesToScroll: 1
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1
                            }
                        }
                    ]
                });

                // Detectar cuando se muestra el tab correspondiente y recalcular slick
                $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                    let target = $(e.target).attr("href"); // El tab objetivo
                    if (target === '#tab-2') { // El ID del tab donde está el carrusel
                        $carousel.slick('setPosition');
                    }
                });
            });
        </script>
    @endonce
@endpush
