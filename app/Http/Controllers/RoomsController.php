<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoomsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    //GET Requests 
    public function get_details($room_type, $date){

    }

    public function get_details_bulk($room_types, $dates){

    }

    //POST Requests
    
    public function post_price(){

    }

    public function post_inventory(){
    	
    }
}
