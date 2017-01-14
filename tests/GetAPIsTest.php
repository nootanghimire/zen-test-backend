<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GetAPIsTest extends TestCase
{

	//Do not use DatabaseMigrations here because GET
	//does not affect database

	//Logins and stuffs are handled by middlewares, so
	use WithoutMiddleware;	
		
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testDetails()
    {
    	$this->get('/rooms/details/single/2017-01-12')
    	    ->seeJson([
    	     	'room_type' => 'single',
    	     	'date' => '2017-01-12',
    	     	'price' => '5000IDR',
    	     	'available' => '5'
    	     ]);

    	$this->get('/rooms/details/double/2017-01-12')
    	     ->seeJson([
    	     	'room_type' => 'double',
    	     	'date' => '2017-01-12',
    	     	'price' => '8000IDR',
    	     	'available' => '5'
    	     ]);
    }

    public function testBulkDetails()
    {
    	$this->get('/rooms/details/all/2017-01-12')
    	     ->seeJson([
    	     	[
    	     		'room_type' => 'single',
    	     		'date' => '2017-01-12',
    	     		'price' => '5000IDR',
    	     		'available' => '5'
    	     	],
    	     	[
    	     		'room_type' => 'double',
    	     		'date' => '2017-01-12',
    	     		'price' => '8000IDR',
    	     		'available' => '5'	
    	     	]
    	     ]);

    	$this->get('/rooms/details/double/2017-01-12')
    	     ->seeJson([
    	     	[
    	     		'room_type' => 'double',
    	     		'date' => '2017-01-12',
    	     		'price' => '8000IDR',
    	     		'available' => '5'
    	     	]
    	     ]);
    	$this->assertTrue(true);
    }


}
