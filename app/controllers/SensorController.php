<?php

class SensorController extends BaseController {

    public function addGet() {
        return View::make('admin.sensor.new')->with(array('title' => 'Új szenzor hozzáadása'));
    }

    public function addPost() {
        $sensor = new Sensor;
        $sensor->device_id = Input::get('device');
        $sensor->name = Input::get('name');
        $sensor->description = Input::get('description');
        $sensor->unit = Input::get('unit');
        $sensor->latitude = Input::get('latitude');
        $sensor->longitude = Input::get('longitude');
        $sensor->save();

        return Redirect::to('admin')->with('success', 'Szenzor sikeresen hozzáadva!');
    }

    public function sensorGet($id) {
        $sensor = Sensor::find($id);

        return View::make('admin.sensor.edit')->with(array('sensor' => $sensor, 'title' => 'Szenzor módosítása'));
    }

    public function sensorPost($id) {
        $sensor = Sensor::find($id);

        if (Input::get('delete')) {
            $sensor->delete();
            return Redirect::to('admin')->with('success', 'Szenzor sikeresen törölve!');
        }

        $sensor->name = Input::get('name');
        $sensor->description = Input::get('description');
        $sensor->unit = Input::get('unit');
        $sensor->latitude = Input::get('latitude');
        $sensor->longitude = Input::get('longitude');
        $sensor->save();

        return Redirect::to('admin')->with('success', 'Szenzor sikeresen módosítva!');
    }

    public function sensorGuestGet($id) {
        $sensors        = Sensor::all();
        $sensor         = Sensor::find($id);
        $measurements   = $sensor->measurements();

        return View::make('guest.sensor.index')->with(array(
            'sensor' => $sensor,
            'sensors' => $sensors,
            'measurements' => $measurements,
            'title' => $sensor->name,
            'active' => $sensor->device_id
        ));
    }
}