@extends('default')

@section('styles')
    {{ HTML::style('assets/css/login.css') }}
@stop

@section('content')
    <div class="container">

        @if ($errors->has())
            @foreach($errors->all() as $error)
                <div class="bg-danger alert">{{ $error }}</div>
            @endforeach
        @endif

        <div class="logo">
            {{ HTML::image('assets/images/background.png', 'SmartMeter', array('class' => 'img-responsive')) }}
            <div class="home">
                {{ HTML::link('/', 'SmartMeter') }}
            </div>
        </div>

        {{ Form::open(['role' => 'form', 'class' => 'form-signin']) }}
            {{ Form::text('email', null, ['placeholder' => 'Email cím', 'class' => 'form-control']) }}
            {{ Form::password('password', ['placeholder' => 'Jelszó', 'class' => 'form-control']) }}
            {{ Form::submit('Bejelentkezés', ['class' => 'btn btn-lg btn-success btn-block']) }}
        {{ Form::close() }}

    </div>
@stop