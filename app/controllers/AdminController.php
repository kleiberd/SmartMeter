<?php

class AdminController extends BaseController {

    public function loginGet()
    {
        if (Auth::check())
            return Redirect::to('/admin/index');
        else
            return View::make('admin.login');
    }

    public function loginPost()
    {
        $email = Input::get('email');
        $password = Input::get('password');

        if (Auth::attempt(['email' => $email, 'password' => $password], false))
        {
            return Redirect::intended('admin');
        }

        return Redirect::back()->withInput()->withErrors('Hibás felhasználóénv/jelszó páros.');
    }

    public function logoutGet()
    {
        Auth::logout();

        return Redirect::to('/login');
    }

    public function index()
    {
        $sensors = Sensor::all();

        return View::make('admin.index')->with(array(
            'title' => 'Adminisztrációs felület',
            'sensors' => $sensors
        ));
    }
} 