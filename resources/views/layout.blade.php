<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="canonical" href="https://getbootstrap.com/docs/3.4/examples/theme/">

    <title>INEC Reporting Web App.</title>

    <!-- Bootstrap core CSS -->
    <link href="{{asset('/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Bootstrap theme -->
    <link href="{{asset('/css/bootstrap-theme.min.css')}}" rel="stylesheet">
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="{{asset('/css/ie10-viewport-bug-workaround.css')}}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{asset('/css/theme.css')}}" rel="stylesheet">

    <link href="{{asset('/css/toastr.min.css')}}" rel="stylesheet">

    <style rel="text/css">
        td.label {
            width: 20% !important;
            color: black !important;
        }

        td.value {
            width: 80% !important;
            font-weight: bold;
        }
    </style>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

<!-- Fixed navbar -->
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{route('index')}}">INEC-Reporting_APP</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="{{route('index')}}">Dashboard</a></li>
                <li><a href="{{route('new-result')}}">Submit Result</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Contacts <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="https://github.com/ncjoes" target="_blank">GitHub</a></li>
                        <li><a href="https://www.linkedin.com/in/jcnwobodo/" target="_blank">LinkedIn</a></li>
                        <li><a href="https://www.linkedin.com/in/jcnwobodo/" target="_blank">Twitter</a></li>
                        <li><a href="mailto:jc.nwobodo@gmail.com">E-mail</a></li>
                        <li role="separator" class="divider"></li>
                        <li class="dropdown-header">Mobile</li>
                        <li><a href="tel:+2348133621591">+2348133621591</a></li>
                    </ul>
                </li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<div class="container theme-showcase" role="main">
    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
        <h1>INEC_Reporting Web App</h1>
        <p>....</p>
    </div>
    @yield('content')
</div>
<script src="{{asset('js/jquery-2.1.0.min.js')}}" type="text/javascript"></script>
<script src="{{asset('js/bootstrap.min.js')}}" type="text/javascript"></script>
<script src="{{asset('js/jquery-ui-1.10.4.min.js')}}" type="text/javascript"></script>
<script src="{{asset('js/toastr.min.js')}}" type="text/javascript"></script>
<script src="{{asset('js/utils.js')}}" type="text/javascript"></script>
<script src="{{asset('js/task-list-base.js')}}" type="text/javascript"></script>

</body>
</html>
