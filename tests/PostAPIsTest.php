<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PostAPIsTest extends TestCase
{
	//POST Affects Database, so 
	use DatabaseMigrations;


    /**
     * A basic test example.
     *
     * @return void
     */
    public function testPrice()
    {
        $this->assertTrue(true);
    }


    public function testInventory()
    {
    	$this->assertTrue(true);
    }
}
