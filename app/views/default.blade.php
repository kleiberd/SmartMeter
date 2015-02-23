<!DOCTYPE html>
<html lang="hu">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
        <title>{{ isset($title) ? $title . ' - ' : '' }} SmartMeter</title>
        <link rel="shortcut icon" type="image/png" href="{{ url('assets/images/favicon.png') }}"/>
        {{ HTML::style('assets/frameworks/bootstrap/css/bootstrap.min.css') }}
        {{ HTML::style('assets/frameworks/font-awesome/css/font-awesome.min.css') }}
        {{ HTML::style('http://fonts.googleapis.com/css?family=Merienda:400,700&subset=latin,latin-ext') }}
        @yield('styles')
    </head>
    <body>
        @yield('nav')
        @yield('sidebar')
        @yield('content')
        {{ HTML::script('assets/frameworks/jquery/jquery-2.1.1.min.js') }}
        {{ HTML::script('assets/frameworks/bootstrap/js/bootstrap.min.js') }}
        {{ HTML::script('https://maps.googleapis.com/maps/api/js?language=hu&libraries=places') }}
        @yield('scripts')
    </body>
</html>