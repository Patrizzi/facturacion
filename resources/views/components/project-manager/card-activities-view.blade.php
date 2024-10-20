@push('css')
    {!! push_asset_once(['css/plugins/slick/slick.css', 'css/plugins/slick/slick-theme.css']) !!}
    {{-- @once
        <link rel="stylesheet" href="{{ asset('css/project_managers/project_managers.css') }}">
        <link rel="stylesheet" href="{{ asset('css/plugins/sweetalert/sweetalert.css') }}" >
    @endonce --}}
@endpush
<div class="row justify-content-md-center">
    <div class="col-lg-11">
        <h4 class="text-center m">
            Multiple example with responsive breakpoints
        </h4>
        <div class="cards">
            <div>
                <div class="ibox-content">
                    <h2>Slide 1</h2>
                    <p>
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
                        Ipsum has been the industry's standard dummy text ever since the 1500s, when an
                        unknown printer took a galley of type and scrambled it to make a type specimen
                        book. It has survived not only five centuries, but also the leap.
                    </p>
                </div>
            </div>
            <div>
                <div class="ibox-content">
                    <h2>Slide 2</h2>
                    <p>
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
                        Ipsum has been the industry's standard dummy text ever since the 1500s, when an
                        unknown printer took a galley of type and scrambled it to make a type specimen
                        book. It has survived not only five centuries, but also the leap.
                    </p>
                </div>
            </div>
            <div>
                <div class="ibox-content">
                    <h2>Slide 3</h2>
                    <p>
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
                        Ipsum has been the industry's standard dummy text ever since the 1500s, when an
                        unknown printer took a galley of type and scrambled it to make a type specimen
                        book. It has survived not only five centuries, but also the leap.
                    </p>
                </div>
            </div>
            <div>
                <div class="ibox-content">
                    <h2>Slide 4</h2>
                    <p>
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
                        Ipsum has been the industry's standard dummy text ever since the 1500s, when an
                        unknown printer took a galley of type and scrambled it to make a type specimen
                        book. It has survived not only five centuries, but also the leap.
                    </p>
                </div>
            </div>
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
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    arrows: true,
                    dots: true,
                    responsive: [{
                            breakpoint: 1024,
                            settings: {
                                slidesToShow: 3,
                                slidesToScroll: 3,
                                infinite: true,
                                dots: true
                            }
                        },
                        {
                            breakpoint: 600,
                            settings: {
                                slidesToShow: 2,
                                slidesToScroll: 2
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
