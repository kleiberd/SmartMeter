<div id="wrapper">
    <nav class="navbar navbar-new navbar-fixed-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ url('/admin') }}"><i class="fa fa-map-marker fa-fw"></i>SmartMeter{{ isset($title) ?  ' - ' . $title : '' }}</a>
        </div>

        <ul class="nav navbar-top-links navbar-right">
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li><a href="{{ url('admin/logout') }}"><i class="fa fa-sign-out fa-fw"></i> Kijelentkezés</a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
