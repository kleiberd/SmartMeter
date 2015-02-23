<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Sensor extends Eloquent implements UserInterface, RemindableInterface {

    use UserTrait, RemindableTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'sensors';

    protected $primaryKey = 'device_id';

    public function measurements() {
        return $this->hasMany('Measurement')->orderBy('created_at', 'desc');
    }

    public function getLastValue() {
        return $this->measurements()->first();
    }

    public function getTodayValues() {
        $startToday = Carbon\Carbon::now()->startOfDay();
        $endToday = Carbon\Carbon::now()->endOfDay();

        return $this->hasMany('Measurement')->where('created_at', '>=', $startToday)->where('created_at', '<=', $endToday)->get();
    }

}