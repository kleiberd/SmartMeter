<?php

class AdminTest extends TestCase
{

    public function testLogin()
    {
        Route::enableFilters();
        $this->call('GET', 'admin/sensor/add');
        $this->assertRedirectedTo('login');
    }

}