<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */



     
    //para testear usar el comando en la terminal
    //  ./vendor/bin/phpunit --filter nombre_de_la_funcion

    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
