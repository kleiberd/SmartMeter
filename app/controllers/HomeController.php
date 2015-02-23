<?php

class HomeController extends BaseController {

    public function index()
    {
        $sensors = Sensor::all();

        return View::make('guest.index')->with(array('sensors' => $sensors));
    }

}
