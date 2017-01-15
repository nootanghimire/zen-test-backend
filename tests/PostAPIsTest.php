<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PostAPIsTest extends TestCase
{
	//Logins and stuffs are handled by middlewares, so
	use WithoutMiddleware;

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
