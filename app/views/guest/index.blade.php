@extends('default')

@section('styles')
    {{ HTML::style('assets/css/style.css') }}
    {{ HTML::style('assets/frameworks/metismenu/css/metisMenu.min.css') }}
@stop

@section('nav')
    <nav class="navbar navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ url('/') }}"><i class="fa fa-map-marker fa-fw"></i>SmartMeter</a>
            </div>
        </div>
    </nav>
@stop

@section('sidebar')
    <div id="sidebar" class="navbar-default sidebar" role="navigation">
        <div id="menu" class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <li>
                    <a class="active" href="#"><i class="fa fa-bullseye fa-fw"></i> Szenzorok<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse in">
                        @foreach($sensors as $sensor)
                            <li>
                                <a href="{{ url('sensor/' . $sensor->device_id) }}">{{ $sensor->name }} ({{ $sensor->device_id }})</a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            </ul>
        </div>
    </div>
@stop

@section('content')
    <div id="map-canvas"></div>
@stop

@section('scripts')
    {{ HTML::script('assets/frameworks/metismenu/js/metisMenu.min.js') }}
    {{ HTML::script('assets/js/admin.js') }}
    <script type="text/javascript">
        $(document).ready(function(){

            $('#side-menu').metisMenu();

            if ($(window).width() > 768) {
                $("#sidebar").height($(window).height() - $(".navbar").height());
            }

            $( window ).resize(function() {
                if ($(window).width() > 768) {
                    $("#sidebar").height($(window).height() - $(".navbar").height());
                } else {
                    $("#sidebar").height("auto");
                }
            })

            $.get("api/sensors", function(data, status){
                for(var i = 0; i < data.length; i++) {
                    var myLatlng = new google.maps.LatLng(data[i].latitude, data[i].longitude);

                    var content = '' +
                         '<p id="sensor-' + i + '" style="width: 150px;">' +
                            '<strong>Hőmérséklet: </strong><span id="temperature-'+i+'" class="temperature">25</span><br>' +
                            '<strong>Páratartalom: </strong><span class="humidity-'+i+'">80</span><br>' +
                            '<strong>Fény: </strong><span class="light-'+i+'">1000 </span><br>' +
                            '<strong>Magassság: </strong><span class="altimeter-'+i+'">120</span><br>' +
                         '</p>';

                    var image = 'assets/images/marker.png';

                    var marker = new google.maps.Marker({
                        position: myLatlng,
                        map: map,
                        clickable: true,
                        title: data[i].device_id,
                        icon: image
                    });

                    addInfoWindow(marker, content);
                    bounds.extend(marker.position);

                    marker.setMap(map);
                }
            });
        });

        var map;
        var bounds = new google.maps.LatLngBounds();

        function addInfoWindow(marker, message) {
            var infoWindow = new google.maps.InfoWindow({
                content: message,
                width: 300
            });
            google.maps.event.addListener(marker, 'click', function () {
                infoWindow.open(map, marker);
            });
        }

        function initialize() {
            var mapOptions = {
                zoom: 15,
                panControl: false,
                mapTypeControl: false,
                scaleControl: false,
                streetViewControl: false
            };
            map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
            map.fitBounds(bounds);
        }
        google.maps.event.addDomListener(window, 'load', initialize);
    </script>
@stop