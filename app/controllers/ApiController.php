<?php

class ApiController extends BaseController
{

    public function sensorsGet()
    {
        $sensors = Sensor::all();

        return Response::Json($sensors);
    }

    public function sensorGetById($id)
    {
        $sensor = Sensor::find($id);

        return Response::Json($sensor);
    }

    public function uploadPost()
    {
        $data = Input::get('datas');
        $pieces = explode(";", $data);
        foreach ($pieces as $piece) {
            $line = explode(":", $piece);
            $measurement = new Measurement();
            $measurement->value = $line[1];
            $measurement->sensor_id = $line[0];
            $measurement->save();
        }
    }

    public function sensorDailyGet($id)
    {
        $sensor = Sensor::find($id);
        $measurements = $sensor->getTodayValues();

        return Response::Json($measurements);
    }

}