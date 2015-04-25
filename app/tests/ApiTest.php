<?php

class ApiTest extends TestCase {

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testApiExample()
    {
        $this->client->request('GET', 'api/sensors');

        $this->assertTrue($this->client->getResponse()->isOk());
    }

}
