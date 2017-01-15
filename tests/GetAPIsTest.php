<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GetAPIsTest extends TestCase
{

	//Logins and stuffs are handled by middlewares, so
	use WithoutMiddleware;	
		
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAllRooms()
    {
        $this->get('/rooms/all')
            ->seeJson([
                'label' => 'Single Room'
            ]);

        $this->get('/rooms/all')
            ->seeJson([
                'label' => 'Double Room'
            ]);

    }

    public function testDetails()
    {
    	$this->get('/rooms/details/1/2017-01-12')
    	    ->seeJson([
    	     	'room_type_id' => 1,
                'price' => '5000IDR',
    	     	'effective_date' => '2017-01-12',
    	     ]);

        $this->get('/rooms/details/1/2017-01-12')
            ->seeJson([
                'room_type_id' => 1,
                'num_available' => 5,
                'effective_date' => '2017-01-12',
             ]);

    	$this->get('/rooms/details/2/2017-01-12')
    	     ->seeJson([
    	     	'room_type_id' => 2,
                'price' => '8000IDR',
    	     	'effective_date' => '2017-01-12'
    	     ]);

        $this->get('/rooms/details/2/2017-01-12')
             ->seeJson([
                'room_type_id' => 2,
                'num_available' => 5,
                'effective_date' => '2017-01-12'
             ]);

    	$this->get('/rooms/details/all/2017-01-12')
    	     ->seeJson([
    	     		'room_type_id' => 2,
    	     		'price' => '5000IDR',
                    'effective_date' => '2017-01-12',
    	     ]);

        $this->get('/rooms/details/all/2017-01-12')
             ->seeJson([
                    'room_type_id' => 1,
                    'num_available' => 5,
                    'effective_date' => '2017-01-12'
             ]);

    }

    public function testDateRange(){
        $this->get('/rooms/details/by_date_range/all/2010-10-10/2018-10-10')
            ->seeJson([
                    'room_type_id' => 1,
                    'num_available' => 5,
                    'effective_date' => '2017-01-12'
                ]);

        $this->get('/rooms/details/by_date_range/all/2010-10-10/2018-10-10')
            ->seeJson([
                    'room_type_id' => 2,
                    'num_available' => 5,
                    'effective_date' => '2017-01-12'
                ]);

        $this->get('/rooms/details/by_date_range/all/2010-10-10/2018-10-10')
            ->seeJson([
                    'room_type_id' => 1,
                    'price' => '5000IDR',
                    'effective_date' => '2017-01-12'
                ]);

        $this->get('/rooms/details/by_date_range/all/2010-10-10/2018-10-10')
            ->seeJson([
                    'room_type_id' => 2,
                    'price' => '8000IDR',
                    'effective_date' => '2017-01-12'
                ]);
    }


}
