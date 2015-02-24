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
                <h1 class="page-header">Adatbázisok</h1>
            </div>
        </div>
        <div class="centered">
            <div class="row">
                <a href="{{ url('/admin/database/add') }}">
                    <button type="button" class="btn btn-outline btn-success btn-lg btn-block">Új adatbázis hozzáadása</button>
                </a>
            </div>
        </div>
    </div>
    </div>
@stop

@section('scripts')

@stop

@stop