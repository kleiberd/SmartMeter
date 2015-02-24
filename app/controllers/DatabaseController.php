<?php

class DatabaseController extends BaseController {

    public function databaseGet() {

        return View::make('admin.database.all');
    }

}