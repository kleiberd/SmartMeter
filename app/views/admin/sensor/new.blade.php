@extends('default')

@section('styles')
    {{ HTML::style('assets/css/admin.css') }}
    {{ HTML::style('assets/frameworks/font-awesome/css/font-awesome.min.css') }}
@stop

@section('nav')
    @include('admin.nav')
@stop

@section('sidebar')
    @include('admin.sidebar')
@stop

@section('content')
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header">Új szenzor hozzáadása</h3>
                </div>
            </div>
             <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading"></div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    {{ Form::open(array('url' => 'admin/sensor/add', 'role' => 'form')) }}
                                        <div class="form-group">
                                            {{ Form::label('device', 'Eszköz azonosító') }}
                                            {{ Form::text('device', null, array('required', 'class' => 'form-control')) }}
                                        </div>
                                        <div class="form-group">
                                            {{ Form::label('name', 'Név') }}
                                            {{ Form::text('name', null, array('required', 'class' => 'form-control')) }}
                                        </div>
                                        <div class="form-group">
                                            {{ Form::label('description', 'Leírás') }}
                                            {{ Form::text('description', null, array('required','class' => 'form-control')) }}
                                        </div>
                                        <div class="form-group">
                                            {{ Form::label('unit', 'Mértékegység') }}
                                            {{ Form::text('unit', null, array('required', 'class' => 'form-control')) }}
                                        </div>
                                        <div class="form-group">
                                            {{ Form::label('latitude', 'Földrajzi szélesség (latitude)') }}
                                            {{ Form::text('latitude', null, array('required', 'class' => 'form-control')) }}
                                        </div>
                                        <div class="form-group">
                                            {{ Form::label('longitude', 'Földrajzi hosszúság (longitude)') }}
                                            {{ Form::text('longitude', null, array('required', 'class' => 'form-control')) }}
                                        </div>
                                        {{ Form::submit('Mentés', array('class' => 'btn btn-outline btn-success')) }}
                                    {{ Form::close() }}
                                </div>
                                <div class="col-lg-6">
                                    <form role="form">
                                        <div class="form-group">
                                            {{ Form::label('pac-input', 'Térkép') }}
                                            {{ Form::text('pac-input', null, array('class' => 'controls', 'placeholder' => 'Keresés')) }}
                                            <div id="map-canvas" style="width: 100%; height: 300px;"></div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script type="text/javascript">
        var map;
        var marker;

        function changeMarkerPosition(position, map) {
            if (marker == undefined) {
                marker = new google.maps.Marker({
                    position: position,
                    map: map
                });
            } else {
                marker.setPosition(position);
                map.panTo(position);
            }
        }

        function initialize() {
            var mapOptions = {
                center: { lat: 47.087771, lng: 17.908241},
                zoom: 15,
                panControl: false,
                mapTypeControl: false,
                scaleControl: false,
                streetViewControl: false
            };
            map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

            var input = /** @type {HTMLInputElement} */(
                document.getElementById('pac-input'));
            map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

            var searchBox = new google.maps.places.SearchBox(
                /** @type {HTMLInputElement} */(input));

            google.maps.event.addListener(searchBox, 'places_changed', function() {
                var places = searchBox.getPlaces();

                if (places.length == 0) {
                    return;
                }

                var bounds = new google.maps.LatLngBounds();
                for (var i = 0, place; place = places[i]; i++) {
                    bounds.extend(place.geometry.location);
                }

                map.fitBounds(bounds);
            });

            google.maps.event.addListener(map, 'click', function(e) {
                changeMarkerPosition(e.latLng, map);
                $("#latitude").val(e.latLng.lat());
                $("#longitude").val(e.latLng.lng());
            });

            google.maps.event.addListener(map, 'bounds_changed', function() {
                var bounds = map.getBounds();
                searchBox.setBounds(bounds);
            });
        }
        google.maps.event.addDomListener(window, 'load', initialize);
    </script>
@stop

@stop