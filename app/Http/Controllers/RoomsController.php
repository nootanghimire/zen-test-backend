<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rooms;
use App\Models\RoomPrices;
use App\Models\RoomInventories;

class RoomsController extends Controller
{

    // Basic Dependency Injection
    // since this is a simple project, we do not use 
    // providers and bindings
    protected $rooms;
    protected $room_prices;
    protected $room_inventories; 
    
    public function __construct(Rooms $r, RoomPrices $rp, RoomInventories $ri)
    {
        $this->middleware('auth');

        $this->rooms = $r;
        $this->room_prices = $rp;
        $this->room_inventories = $ri;
    }

    //GET Requests 
    
    public function get_all_rooms(){
        return response()->json($this->rooms->all());
    }

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
