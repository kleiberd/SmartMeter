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
                <a class="navbar-brand" href="{{ url("/") }}"><i class="fa fa-map-marker fa-fw"></i>SmartMeter</a>
            </div>
        </div>
    </nav>
@stop

@section('content')
    <div id="sidebar" class="navbar-default sidebar" role="navigation">
        <div id="menu" class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <li>
                    <a href="#"><i class="fa fa-bullseye fa-fw"></i> Szenzorok<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse in">
                        @foreach($sensors as $sensor_item)
                        <li {{ ($sensor_item->device_id == $active) ? 'class="active"' : '' }}>
                            <a href="{{ url('sensor/' . $sensor_item->device_id) }}">{{ $sensor_item->name }} ({{ $sensor_item->device_id }})</a>
                        </li>
                        @endforeach
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="page-header">{{ $sensor->name }} - {{ $sensor->description }}</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Adatok
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        Név
                                    </div>
                                    <div class="panel-body">
                                        <p>{{ $sensor->name }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        Leírás
                                    </div>
                                    <div class="panel-body">
                                        <p>{{ $sensor->description }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        Utolsó mért érték
                                    </div>
                                    <div class="panel-body">
                                        @if ($sensor->getLastValue() === null)
                                           N/A
                                       @else
                                           <span id="last_value">{{ round($sensor->getLastValue()->value, 3) }}</span> ({{ $sensor->unit }})
                                       @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Ma mért adatok
                    </div>
                    <div class="panel-body">
                        <div id="chartContainer" data-id="{{ $sensor->device_id }}" style="height: 300px; width: 100%;"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Pozició
                    </div>
                    <div class="panel-body">
                        <div id="map" style="width: 100%; height: 300px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    {{ HTML::script('assets/frameworks/metismenu/js/metisMenu.min.js') }}
    {{ HTML::script('assets/js/admin.js') }}
    {{ HTML::script('assets/frameworks/canvasjs/canvasjs.min.js') }}
    {{ HTML::script('assets/frameworks/socket.io/socket.io-1.3.4.js') }}
    <script type="text/javascript">
        $('#side-menu').metisMenu();

        if ($(window).width() > 768) {
            $("#sidebar").height($("#page-wrapper").height() + 50);
            $("#page-wrapper").width(($(window).width() - $("#sidebar").width()) - 50);
        }

        $( window ).resize(function() {
            if ($(window).width() > 768) {
                $("#sidebar").height($("#page-wrapper").height() + 50);
            } else {
                $("#sidebar").height("auto");
                $("#page-wrapper").width($(window).width());
            }
        })
    </script>
    <script type="text/javascript">
        window.onload = function () {
            var values = [];

            var chart = new CanvasJS.Chart("chartContainer", {
                zoomEnabled: true,
                title: {
                    text: "{{ $sensor->name }} adatok"
                },
                toolTip: {
                    shared: true
                },
                legend: {
                    verticalAlign: "top",
                    horizontalAlign: "center",
                    fontSize: 14,
                    fontWeight: "bold",
                    fontFamily: "calibri",
                    fontColor: "dimGrey"
                },
                axisX: {
                    title: "Idő",
                    titleFontSize: 15,
                    valueFormatString: "HH:mm:ss",
                    labelFontSize: 15
                },
                axisY:{
                    suffix: "{{ $sensor->unit }}",
                    includeZero: true,
                    labelFontSize: 15
                },
                data: [{
                    type: "line",
                    xValueType: "dateTime",
                    showInLegend: true,
                    color: "#2ECC71",
                    name: "Maximum {{ $sensor->name }}",
                    dataPoints: values
                }],
              legend:{
                cursor:"pointer",
                itemclick : function(e) {
                  if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                    e.dataSeries.visible = false;
                  }
                  else {
                    e.dataSeries.visible = true;
                  }
                  chart.render();
                }
              }
            });

            var updateChart = function(data) {
                for (var i = 0; i < data.length; i++) {
                    var d = new Date(data[i].created_at);
                    console.log(d);
                    values.push({
                        x: d,
                        y: data[i].value
                    });
                    last_date_new = d;
                }
                chart.render();
                $("#chartContainer").attr("data-lastdate", last_date_new);
            }

            $.get('{{ url('/api/sensors/daily/' . $sensor->device_id) }}', function( data ) {
                var last_date;
                if (data.length != 0) {
                    for (var i = 0; i < data.length; i++) {
                        last_date = data[i].created_at;
                        var t = data[i].created_at.split(/[- :]/);
                        var d = new Date(t[0], t[1]-1, t[2], t[3], t[4], t[5]);
                        //var d = new Date(data[i].created_at);
                        values.push({
                            x: d.getTime(),
                            y: parseFloat(data[i].value)
                        });
                    }
                    chart.render();
                    $("#chartContainer").attr("data-lastdate", last_date);
                    createWS();
                }
            });

            function createWS() {

                var datas = $("#chartContainer").data();
                var socket = io.connect('http://davidkleiber.com:8000');

                socket.on('connect', function() {
                    socket.emit("data", {date: datas.lastdate, id: datas.id});
                });

                socket.on('notification', function(data) {
                    if (data.measurements.length != 0) {
                        updateChart(data.measurements);
                    }
                })
            }
        }
    </script>
    <script type="text/javascript">
        var map;
        var marker;

        function initialize() {
            var mapOptions = {
                center: { lat: {{ $sensor->latitude }}, lng: {{ $sensor->longitude }} },
                zoom: 15,
                panControl: false,
                mapTypeControl: false,
                scaleControl: false,
                streetViewControl: false
            };
            map = new google.maps.Map(document.getElementById('map'), mapOptions);
            var image = '{{ url('assets/images/marker.png') }}';
            var marker = new google.maps.Marker({
                position: new google.maps.LatLng({{ $sensor->latitude }}, {{ $sensor->longitude }}),
                map: map,
                clickable: true,
                title: "{{ $sensor->name }}",
                icon: image
            });
        }
        google.maps.event.addDomListener(window, 'load', initialize);
    </script>
@stop