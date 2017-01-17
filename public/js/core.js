var App = angular.module("ZenRoomsApp", []);

App.filter('range', function() {
  return function(input, total) {
    var date = new Date();
    var total = parseInt(total);

    for (var i=0; i<total; i++) {
      input.push(i + (date.getFullYear() - total + 1));
    }

    return input;
  };
});

App.controller("BulkOperationsController", function($scope, $http) {

  //Dummy Room Size, for before angular does xhr
  $scope.roomSizeList = [{id:-99, label:"--Select Room Size--"}];

  //Room Size
  $http.get('/rooms/all').then(function(response){
    return response.data;
  }).then(function(response){
    return response.map(function(elem){ return {id: elem.id, label: elem.label} || false; });
  }).then(function(room_labels){
    $scope.roomSizeList = room_labels;
  });



  //Days
  $scope.days = ["Mondays", "Tuesdays", "Wednesdays", "Thursdays", "Fridays", "Saturdays", "Sundays"];


  // Set this from backend
  $scope.bulkOperations = {
    dateFrom : new Date(),
    dateTo : new Date(),
    allDays : false,
    allWeekdays : false,
    allWeekends : false,
    selectedDays : {Mondays:false, Tuesdays:false, Wednesdays: false, Thursdays: false, Fridays: false, Saturdays: false, Sundays: false},
    changePriceTo : 0,
    changeAvailabilityTo : 0
  }

  $scope.clickAllDays = function(){
    $scope.cancelEventHandler(); //resest
    $scope.days.forEach(function(elem){
      $scope.checkDaySelection(elem);
    });
    $scope.bulkOperations.allDays = true;
  }

  $scope.clickAllWeekDays = function(){
    $scope.cancelEventHandler(); //resest
    $scope.days.forEach(function(elem){
      if(elem == 'Saturdays' || elem == 'Sundays') {
        $scope.uncheckDaySelection(elem);
        return;
      }
      $scope.checkDaySelection(elem);
    })
    $scope.bulkOperations.allWeekdays = true;
  }

  $scope.clickAllWeekends = function(){
    $scope.cancelEventHandler(); //resest
    $scope.days.forEach(function(elem){
      if(elem == 'Saturdays' || elem == 'Sundays') {
        $scope.checkDaySelection(elem);
        return;
      }
      $scope.uncheckDaySelection(elem);
    })
    $scope.bulkOperations.allWeekends = true;  }

  // Toggle day checkboxes
  $scope.toggleDaySelection = function(day) {
    $scope.bulkOperations.selectedDays[day] = !$scope.bulkOperations.selectedDays[day];
  }

  $scope.checkDaySelection = function(day){
    $scope.bulkOperations.selectedDays[day] = true;
  }

  $scope.uncheckDaySelection = function(day){
    $scope.bulkOperations.selectedDays[day] = false;
  }

  // Reset Form
  $scope.cancelEventHandler = function() {
    $scope.bulkOperations = {
      dateFrom : new Date(),
      dateTo : new Date(),
      allDays : false,
      allWeekdays : false,
      allWeekends : false,
      selectedDays : {Mondays:false, Tuesdays:false, Wednesdays: false, Thursdays: false, Fridays: false, Saturdays: false, Sundays: false},
      changePriceTo : 0,
      changeAvailabilityTo : 0
    }
  }

  // Save form
  $scope.submitEventHandler = function() {
    console.log($scope.bulkOperations);
    //send $http, xhr
    //see response
    //need to call update calendar on next controller
    //because this changes things
    $http.post('/rooms/bulk', $scope.bulkOperations);
  }
});

App.controller("CalendarViewController", function($scope, $http) {
  
  $http.get('/rooms/all').then(function(response){
    return response.data;
  }).then(function(response){
    return response.map(function(elem){ return {id: elem.id, label: elem.label} || false; });
  }).then(function(room_labels){
    $scope.roomSizeList = room_labels;
    $scope.updateCalendar();
  });

  $scope.days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
  $scope.months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

  $scope.date = new Date();
  $scope.currentMonth = $scope.months[$scope.date.getMonth()];
  $scope.currentMonthNum = $scope.months.indexOf($scope.currentMonth);
  $scope.currentYear = $scope.date.getFullYear().toString();


  $scope.monthStart = new Date(parseInt($scope.currentYear), $scope.currentMonthNum, 1);
  $scope.monthEnd = new Date(parseInt($scope.currentYear), $scope.currentMonthNum + 1, 1);
  
  $scope.monthLength = ($scope.monthEnd - $scope.monthStart) / (1000 * 60 * 60 * 24);
  $scope.dayNames = [];

  $scope.dayStartIndex = $scope.monthStart.getDay();

  $scope.roomAndPrice = {};

  //Dummy Fill
  $scope.getRoomAndPrice = function(year, month){
    //Get values from 'year' and 'month' from db
    var localRoomAndPrice = {};
    for(var i = 0; i < $scope.roomSizeList.length; i++) {
      localRoomAndPrice[$scope.roomSizeList[i].id] = [];
      for(var j = 1; j <= $scope.monthLength; j++) {
        localRoomAndPrice[$scope.roomSizeList[i].id].push({

          //Set Id, room available, and price from backend
          id:"id-"+$scope.roomSizeList[i].id+"-"+j,
          editRoom: false, // Necessary
          editPrice: false, // Necessary
          room: 0,
          price: "N/A "
        })
      }
    }
    return localRoomAndPrice;
  }

  $scope.updateCalendar = function(){
    $scope.currentMonthNum = $scope.months.indexOf($scope.currentMonth);
    $scope.monthStart = new Date(parseInt($scope.currentYear), $scope.currentMonthNum, 0);
    $scope.monthEnd = new Date(parseInt($scope.currentYear), $scope.currentMonthNum + 1, 0);
    $scope.monthLength = ($scope.monthEnd - $scope.monthStart) / (1000 * 60 * 60 * 24);
    $scope.dayStartIndex = $scope.monthStart.getDay();

    $scope.dayNames = [];
    for(var i = 0; i< $scope.monthLength; i++){
      if($scope.dayStartIndex > 6) $scope.dayStartIndex = 0;
      $scope.dayNames.push($scope.days[$scope.dayStartIndex]);
      $scope.dayStartIndex++;
    }

    //Fill dummy data first
    $scope.roomAndPrice = $scope.getRoomAndPrice($scope.currentYear, $scope.currentMonthNum);

    //then do an XHR request;
    //looks nice, later use "loading" thing
    
    $scope.send_month_base = $scope.currentYear.toString() + '-' + (($scope.currentMonthNum +1) < 10 ? '0' : '') + ($scope.currentMonthNum + 1).toString();
    $scope.send_month_start = $scope.send_month_base + '-01';
    $scope.send_month_end = $scope.send_month_base.toString() + '-' + $scope.monthLength.toString();
    //console.log('months');
    //console.log($scope.send_month_start);
    //console.log($scope.send_month_end);
    $http.get('/rooms/details/by_date_range/all/' + $scope.send_month_start + '/' + $scope.send_month_end).then(
      function(response){
        return response.data;
      }).then(function(response){
        //return sort by effective_date
        //test: expect response as Array
        //test: Date is proper
        return response.sort(function(a,b){ return Date.parse(a.effective_date) - Date.parse(b.effective_date);});
      }).then(function(response){
        //return sort by room_type_id
        return response.sort(function(a,b){ return (a.room_type_id - b.room_type_id); });
      }).then(function(response){
        //filter and combine
        //some tests before and after this filter would be great
        return response.filter(function(elem, idx, arr){
          if(typeof arr[idx+1] !== 'undefined'){
            if(arr[idx+1].room_type_id === arr[idx].room_type_id){
              Object.assign(arr[idx+1], arr[idx]);
              return false;
            }
          }
          return true;
        });
        //end filter
      }).then(function(response){
        //map things here,
        return response.map(function(elem){
          var dt = new Date(elem.effective_date);
          dt = dt.getDate();
          return{
            room_type_id : elem.room_type_id,
            id: 'id-' + elem.room_type_id + '-' + dt,
            editRoom: false,
            editPrice: false,
            room: elem.num_available,
            price: elem.price
          };
        });
        //end map
      }).then(function(response){
        //console.log(JSON.stringify(response));
        //not pure functions, but wth
        //$scope.updateCalendar();
        //probable test: assert response is array
        //there is probably a nice way of doing this
        response.forEach(function(elem){
          var idx = elem.room_type_id;
          delete elem.room_type_id;
          //console.log(JSON.stringify(elem));
          //console.log($scope.roomAndPrice[idx]);
          $scope.roomAndPrice[idx].forEach(function(elem_inner){
            if(elem_inner.id == elem.id){
              //console.log('here');
              elem_inner.room = elem.room;
              elem_inner.price = elem.price;
            }
          }); //inner foreach
        }); //outer foreach
        //console.log(JSON.stringify($scope.roomAndPrice));
      }); //end promise chain, handle error later        
  }


  $scope.updateCellRoom = function(id, room){
    //Get updated room and price of id. Send to backend
    var id_split = id.split('-');
    var room_type_id = id_split[1];
    var currentDay = (parseInt(id_split[2]) < 10 ? "0" : "") + id_split[2];
    var currentMonthNumericDouble = (parseInt($scope.currentMonthNum) < 10 ?  "0" : "") + ($scope.currentMonthNum + 1);
    console.log(room_type_id, currentDay, $scope.currentYear, currentMonthNumericDouble, room);
    //xhr request here
    //no need to change anything on frontend side, changes persist
    //check on error, though, if error try to reload
    $http.post(
      '/rooms/price',
      {
        date: $scope.currentYear + "-" + currentMonthNumericDouble + "-" + currentDay,        
        room_type_id: room_type_id,
        inventory: room
      }
    );
  }

  $scope.updateCellPrice = function(id, price){
    //Get updated room and price of id. Send to backend
    var id_split = id.split('-');
    var room_type_id = id_split[1];
    var currentDay = (parseInt(id_split[2]) < 10 ? "0" : "") + id_split[2];
    var currentMonthNumericDouble = (parseInt($scope.currentMonthNum) < 10 ?  "0" : "") + ($scope.currentMonthNum + 1);
    console.log(room_type_id, currentDay, $scope.currentYear, currentMonthNumericDouble, price);
    //xhr request here
    //no need to change anything on frontend side, changes persist
    //check on error, though, if error try to reload
    $http.post(
      '/rooms/price',
      {
        date: $scope.currentYear + "-" + currentMonthNumericDouble + "-" + currentDay,
        room_type_id: room_type_id,
        price: price
      }
    );
  }

})