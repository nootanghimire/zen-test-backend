<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class GetAPIsTest extends TestCase
{

	//Do not use DatabaseMigrations here because GET
	//does not affect database
	
		
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testDetails()
    {
        $this->assertTrue(true);
    }

    public function testBulkDetails()
    {
    	$this->assertTrue(true);
    }


}
