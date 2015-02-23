@extends('default')

@section('styles')
    {{ HTML::style('assets/css/admin.css') }}
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
                    <h1 class="page-header">Szenzorok</h1>
                </div>
                {{ Session::has('success') ? '<div class="row"><div class="col-lg-12"><div class="alert alert-success text-center">' . Session::get('success') . '</div></div></div>' : '' }}
                {{ Session::has('danger') ? '<div class="row"><div class="col-lg-12"><div class="alert alert-danger text-center">' . Session::get('danger') . '</div></div></div>' : '' }}
                <div class="row">
                    @foreach($sensors as $sensor)
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-bullseye fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">
                                        @if ($sensor->getLastValue() === null)
                                            N/A
                                        @else
                                            {{ round($sensor->getLastValue()->value) }}
                                        @endif
                                        </div>
                                        <div>{{ $sensor->name }} ({{ $sensor->unit }})</div>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ url('admin/sensor/get/' . $sensor->device_id) }}">
                                <div class="panel-footer">
                                    <span class="pull-left">Szerkesztés</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="centered">
                <div class="row">
                    <a href="{{ url('/admin/sensor/add') }}">
                        <button type="button" class="btn btn-outline btn-success btn-lg btn-block">Új szenzor hozzáadása</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')

@stop