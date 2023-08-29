<div id="wrapper-mini">
    <!-- Sidebar -->
    <div id="sidebar-wrapper-event">
        <ul class="sidebar-nav nav-pills nav-stacked" id="menu">
            <li>
                <a href="#" id="event_menu_eventos"><span class="fa-stack fa-lg pull-left"><i
                            class="fa fa-calendar fa-stack-1x "></i></span>Eventos</a>
                <ul class="nav-pills nav-stacked" style="list-style-type:none;">
                    <li><a href="#" data-toggle="modal" data-target="#modal_event"><span
                                class="fa-stack fa-lg pull-left"><i class="fa fa-plus fa-stack-1x "></i></span>Agregar
                            Eventos</a>
                    </li>
                    <li><a href="{{ route('eventos.index') }}"><span class="fa-stack fa-lg pull-left"><i
                        class="fa fa-list fa-stack-1x "></i></span>Lista de Evento</a>
                    </li>
                    <li><a href="{{ route('eventos.user_indes') }}"><span class="fa-stack fa-lg pull-left"><i
                            class="fa fa-user fa-stack-1x "></i></span>Mis Eventos</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#" id="cat_menu_eventos"><span class="fa-stack fa-lg pull-left"><i
                            class="fa fa-flag fa-stack-1x "></i></span>Categorias</a>
                <ul class="nav-pills nav-stacked" style="list-style-type:none;">
                    <li><a href="#" data-toggle="modal" data-target="#modal_category"><span
                                class="fa-stack fa-lg pull-left"><i class="fa fa-plus fa-stack-1x "></i></span>Agregar
                            Categoria</a>
                    </li>
                    <li><a href="{{ route('categorias_eventos.index') }}"><span class="fa-stack fa-lg pull-left"><i
                                    class="fa fa-list fa-stack-1x "></i></span>Lista de Categorias</a>
                    </li>
                </ul>
            </li>

        </ul>
    </div>
</div>
@include('eventos.categorias.add_modal')
@include('eventos.modal_add')
<style>
    .nav-pills>li>a {
        border-radius: 0;
    }

    #wrapper-mini {
        padding-left: 0;
        -webkit-transition: all 0.5s ease;
        -moz-transition: all 0.5s ease;
        -o-transition: all 0.5s ease;
        transition: all 0.5s ease;
        overflow: hidden;
    }

    #wrapper-mini.toggled {
        padding-left: 250px;
        overflow: hidden;
    }

    #sidebar-wrapper-event {
        z-index: 1000;
        position: absolute;
        left: 250px;
        width: 0;
        height: 100%;
        margin-left: -250px;
        overflow-y: auto;
        background: transparent;
        -webkit-transition: all 0.5s ease;
        -moz-transition: all 0.5s ease;
        -o-transition: all 0.5s ease;
        transition: all 0.5s ease;
    }

    #wrapper-mini.toggled #sidebar-wrapper-event {
        width: 250px;
    }

    #page-content-wrapper {
        position: absolute;
        padding: 15px;
        width: 100%;
        overflow-x: hidden;
    }

    .xyz {
        min-width: 360px;
    }

    #wrapper-mini.toggled #page-content-wrapper {
        position: relative;
        margin-right: 0px;
    }

    .fixed-brand {
        width: auto;
    }

    /* Sidebar Styles */

    .sidebar-nav {
        position: absolute;
        top: 0;
        width: 250px;
        margin: 0;
        padding: 0;
        list-style: none;
        margin-top: 2px;
    }

    .sidebar-nav li {
        text-indent: 15px;
        line-height: 40px;
    }

    .sidebar-nav li a {
        display: block;
        text-decoration: none;
        color: #212529;
    }

    .sidebar-nav li a:hover {
        text-decoration: none;
        color: black;
        background: #DCDCDC;
        border-left: #1c84c6 2px solid;
    }

    .sidebar-nav li a:active,
    .sidebar-nav li a:focus {
        text-decoration: none;
    }

    .sidebar-nav>.sidebar-brand {
        height: 65px;
        font-size: 18px;
        line-height: 60px;
    }

    .sidebar-nav>.sidebar-brand a {
        color: #999999;
    }

    .sidebar-nav>.sidebar-brand a:hover {
        color: #fff;
        background: none;
    }

    .no-margin {
        margin: 0;
    }

    @media (min-width: 768px) {
        #wrapper-mini {
            padding-left: 250px;
        }

        .fixed-brand {
            width: 250px;
        }

        #wrapper-mini.toggled {
            padding-left: 0;
        }

        #sidebar-wrapper-event {
            width: 100%;
            border-right: 1px solid #1c84c6;
            padding-left: 1em;
        }
    }

    .category-color {
        height: 100%;
    }
</style>
<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>

<script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper-mini").toggleClass("toggled");
    });
    $("#menu-toggle-2").click(function(e) {
        e.preventDefault();
        $("#wrapper-mini").toggleClass("toggled-2");
        $('#menu ul').hide();
    });

    function initMenu() {
        $('#menu ul').hide();
        $('#menu ul').children('.current').parent().show();
        //$('#menu ul:first').show();
        $('#menu li a').click(
            function() {
                var checkElement = $(this).next();
                if ((checkElement.is('ul')) && (checkElement.is(':visible'))) {
                    return false;
                }
                if ((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
                    $('#menu ul:visible').slideUp('normal');
                    checkElement.slideDown('normal');
                    return false;
                }
            }
        );
    }
    $(document).ready(function() {
        initMenu();
    });

    function color_select() {
        var color_id = $('#select_cat').val();
        $.ajax({
            type: "post",
            url: "{{ route('category.color') }}",
            data: {
                '_token': $('input[name=_token]').val(),
                'color': color_id
            },
            success: function(msg) {
                $('.category-color').css('background-color', "" + msg + "");
            },
            error: function(eject) {
                if (eject.status === 400) {
                    console.log(eject.responseJSON.error);
                }
            },
            cache: true
        });
    }
    function check_day() {
            if ($('#all_day').is(':checked')) {
                $('#hora_inicio').attr('disabled', true);
                $('#hora_fin').attr('disabled', true);
                $('#hora_inicio').attr('required', false);
                $('#hora_fin').attr('required', false);
            } else {
                $('#hora_inicio').attr('disabled', false);
                $('#hora_fin').attr('disabled', false);
                $('#hora_inicio').attr('required', true);
                $('#hora_fin').attr('required', true);
            }
        }
</script>
