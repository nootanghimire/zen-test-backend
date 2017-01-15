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

  //$http GET Request
  //$http.get("URL").then(function(response)){
  //  response.data
  //}

  // Set this from backend
  $scope.bulkOperations = {
    roomSizeSelected : "Single Room",
    dateFrom : new Date(),
    dateTo : new Date(),
    allDays : false,
    allWeekdays : false,
    allWeekends : false,
    selectedDays : {Mondays:false, Tuesdays:false, Wednesdays: false, Thursdays: false, Fridays: false, Saturdays: false, Sundays: false},
    changePriceTo : 0,
    changeAvailabilityTo : 0
  }

  // Toggle day checkboxes
  $scope.toggleDaySelection = function(day) {
    $scope.bulkOperations.selectedDays[day] = !$scope.bulkOperations.selectedDays[day];
  }

  // Reset Form
  $scope.cancelEventHandler = function() {
    $scope.bulkOperations = {
      roomSizeSelected : "1",
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

  /*
  $scope.roomAndPrice = {
    //Single Room
    "Single Room" : [{room : 1, price: 1000}, {},..],
    //Double Room
    "Double Room" : []
    //More Arrays For More Rooms
  }
  */

  $scope.roomAndPrice = {};

  //Change function name to something like getRoomAndPrice();
  $scope.getRoomAndPrice = function(year, month){
    //Get values from 'year' and 'month' from db
    for(var i = 0; i < $scope.roomSizeList.length; i++) {
      $scope.roomAndPrice[$scope.roomSizeList[i].id] = [];
      for(var j = 1; j <= $scope.monthLength; j++) {
        $scope.roomAndPrice[$scope.roomSizeList[i].id].push({

          //Set Id, room available, and price from backend
          id:"id-"+i+"-"+j,
          editRoom: false, // Necessary
          editPrice: false, // Necessary
          room: parseInt(Math.random() * 5),
          price: parseInt(Math.random() * 10000)
        })
      }
    }
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

    $scope.getRoomAndPrice($scope.currentYear, $scope.currentMonthNum);
  }


  $scope.updateCell = function(id, room, price){
    //Get updated room and price of id. Send to backend
    console.log(id, room, price);
  }
})