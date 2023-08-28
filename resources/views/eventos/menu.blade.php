<div id="wrapper-mini">
    <!-- Sidebar -->
    <div id="sidebar-wrapper-event">
        <ul class="sidebar-nav nav-pills nav-stacked" id="menu">
            <li>
                <a href="#"><span class="fa-stack fa-lg pull-left"><i
                            class="fa fa-flag fa-stack-1x "></i></span>Shortcut</a>
                <ul class="nav-pills nav-stacked" style="list-style-type:none;">
                    <li><a href="#"><span class="fa-stack fa-lg pull-left"><i
                                    class="fa fa-flag fa-stack-1x "></i></span>link1</a>
                    </li>
                    <li><a href="#"><span class="fa-stack fa-lg pull-left"><i
                                    class="fa fa-flag fa-stack-1x "></i></span>link2</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>
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
        background: #000;
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
        color: #999999;
    }

    .sidebar-nav li a:hover {
        text-decoration: none;
        color: #fff;
        background: rgba(255, 255, 255, 0.2);
        border-left: red 2px solid;
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
            width: 250px;
        }
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
</script>
