<?php

class HomeControllerTest extends TestCase
{

    public function testIndex()
    {
        //$this->call('GET', '/');

        //$this->assertViewHas('sensors');

        $response = $this->call('GET', '/');

        $this->assertViewHas('sensors');

        $sensors = $response->original->getData()['sensors'];

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $sensors);
    }

}