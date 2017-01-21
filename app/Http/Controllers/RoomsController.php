<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//For Interface Injection
use App\Repositories\Interfaces\RoomInventoriesRepositoryInterface;
use App\Repositories\Interfaces\RoomPricesRepositoryInterface;
use App\Repositories\Interfaces\RoomsRepositoryInterface;

//use Requests here
//json_decode
//validate
//send response
//
use App\Http\Requests\Requests\BulkUpdateRequest;
use App\Http\Requests\Requests\SavePriceRequest;
use App\Http\Requests\Requests\SaveInventoryRequest;

class RoomsController extends Controller
{

    // For Basic Dependency Injection
    protected $rooms;
    protected $room_prices;
    protected $room_inventories; 
    
    public function __construct(RoomsRepositoryInterface $r, RoomPricesRepositoryInterface $rp, RoomInventoriesRepositoryInterface $ri)
    {
        $this->middleware('auth');

        $this->rooms = $r;
        $this->room_prices = $rp;
        $this->room_inventories = $ri;
    }

    //GET Requests 
    
    public function get_all_rooms(){
        return response()->json($this->rooms->get_all_rooms());
    }

    public function get_details($room_types, $dates){
        $dates_array = explode(',' , $dates);
        $room_types_array = explode(',', $room_types);
        $response_inventories = $this->room_inventories->get_results($room_types_array, $dates_array)->toArray();
        $response_prices = $this->room_prices->get_results($room_types_array, $dates_array)->toArray();
        $response = array_merge($response_inventories, $response_prices);
        return response()->json($response); //, $response_prices);
    }

    public function get_details_date_range($room_types, $date_one, $date_two){
        $room_types_array = explode(',', $room_types);
        $response_inventories = $this->room_inventories->get_results_range($room_types_array, $date_one, $date_two)->toArray();
        $response_prices = $this->room_prices->get_results_range($room_types_array, $date_one, $date_two)->toArray();
        $response = array_merge($response_inventories, $response_prices);
        return response()->json($response);
    }

    //POST Requests
    
    public function post_price(SavePriceRequest $request){
        //assume $request is validated in SavePriceRequest 
        $params = $request->all();
        $condition = array_filter($params, function($key){
            if($key === 'price') return false;
            return true;
        }, ARRAY_FILTER_USE_KEY);
        $ret = App\Models\RoomPrices::updateOrCreate($condition, ['price' => $params['price']]);
        //If no exception is thrown, I think we can be sure that it passed
        return response()->json(['success' => 'true']);
    }

    public function post_inventory(SaveInventoryRequest $request){
        $params = $request->all();
        $condition = array_filter($params, function($key){
            if($key === 'num_available') return false;
            return true;
        }, ARRAY_FILTER_USE_KEY);
        $ret = App\Models\RoomPrices::updateOrCreate($condition, ['num_available' => $params['num_available']]);
        //If no exception is thrown, I think we can be sure that it passed
        return response()->json(['success' => 'true']);    }

    public function post_bulk(BulkUpdateRequest $request){
        //I really think, we should use Repository Pattern at this point
        //sorry for making this method kind of fat
        
        //again, assume $request is validated at BulkUpdateRequest
        $params = $request->all();
        $start_date = ($params['dateFrom']);
        $end_date = ($params['dateTo']);
        $days = array_filter($params['selectedDays']);
        $dates = [];
        $days = array_keys($days);
        foreach($days as $day){
            $dates = array_merge($dates, $this->getDateForSpecificDayBetweenDates($start_date, $end_date, rtrim($day, 's')));
            
        }
        //dd($dates);
        foreach($dates as $date){
            //I am sure there is a better way to do this, but deadlines
            App\Models\RoomInventories::updateOrCreate(['effective_date' => $date, 'room_type_id'=>$params['room_type_id']], ['num_available' => $params['changeAvailabilityTo']]);
            App\Models\RoomPrices::updateOrCreate(['effective_date' => $date, 'room_type_id'=>$params['room_type_id']], ['price' => $params['changePriceTo']]);
        }
        return response()->json(["success" => 'true']);

    }

    private function getDateForSpecificDayBetweenDates ($startDate,$endDate,$day) {
        $endDate = strtotime($endDate);
        for($i = strtotime($day, strtotime($startDate)); $i <= $endDate; $i = strtotime('+1 week', $i))
            $date_array[] = date('Y-m-d', $i);

        return $date_array;
    }
}
