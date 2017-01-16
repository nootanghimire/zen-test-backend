<!DOCTYPE html>
<html lang="en" ng-app="ZenRoomsApp">
<head>
  <meta charset="UTF-8">
  <title>ZenRooms</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="css/layout.css">
  <link rel="stylesheet" href="css/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.1/angular.min.js"></script>
  <script src="js/core.js"></script>
</head>
<body>
  <div id="main">
    <div id="bulkOperations" ng-controller="BulkOperationsController">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">Bulk Operations</div>
        </div>
        <div class="row">
          <form action="" class="form-horizontal form-inline">
            <div class="col-md-1"><strong>Select Room:</strong></div>
            <div class="col-md-2">
              <select class = "form-control" name="" id="" ng-model="bulkOperations.roomSizeSelected" >
                <option ng-repeat="roomSize in roomSizeList" value="{{roomSize.id}}">{{roomSize.label}}</option>
              </select>
            </div>
          </form>
        </div>
        <div id="daysSection" class="row">
          <form action="" class="form-horizontal form-inline">
            <div class="col-md-1"><strong>Select Days:</strong></div>
            <div class="col-md-3">
              <div class="row">
                <div class="col-md-2">From:</div> <input type="date" class="form-control" ng-model="bulkOperations.dateFrom"/>
              </div>
              <div class="row">
                <div class="col-md-2">To:</div> <input type="date" class="form-control" ng-model="bulkOperations.dateTo"/>
              </div>
            </div>
            <div class="col-md-1">Refine Days:</div>
            <div class="col-md-2">
              <div class="checkbox">
                <label><input type="checkbox" ng-model="bulkOperations.allDays"> All Days</label>
              </div>
              <div class="checkbox">
                <label><input type="checkbox" ng-model="bulkOperations.allWeekdays"> All Weekdays</label>
              </div>
              <div class="checkbox">
                <label><input type="checkbox" ng-model="bulkOperations.allWeekends"> All Weekends</label>
              </div>
            </div>
            <div class="col-md-2">
              <div class="checkbox" ng-repeat="day in days | limitTo:3">
                <label><input type="checkbox" ng-checked="bulkOperations.selectedDays[day]" ng-click="toggleDaySelection(day)"> {{day}}</label>
              </div>
            </div>
            <div class="col-md-2">
              <div class="checkbox" ng-repeat="day in days | limitTo:3:3">
                <label><input type="checkbox" ng-checked="bulkOperations.selectedDays[day]" ng-click="toggleDaySelection(day)"> {{day}}</label>
              </div>
            </div>
            <div class="col-md-1">
              <div class="checkbox" ng-repeat="day in days | limitTo:1:6">
                <label><input type="checkbox" ng-checked="bulkOperations.selectedDays[day]" ng-click="toggleDaySelection(day)"> {{day}}</label>
              </div>
            </div>
          </form>
        </div>
        <div class="row">
          <div class="col-md-2"><strong>Change Price To: </strong></div>
          <div class="col-md-10 form-inline"><input type="text" class="form-control" ng-model="bulkOperations.changePriceTo"></div><br><br>
          <div class="col-md-2"><strong>Change Availability To: </strong></div>
          <div class="col-md-10 form-inline"><input type="text" class="form-control" ng-model="bulkOperations.changeAvailabilityTo"></div>
        </div>
        <div class="row">
          <button type="button" class="btn btn-default" ng-click="cancelEventHandler()">Cancel</button>
          <button type="button" class="btn btn-success" ng-click="submitEventHandler()">Update</button>
        </div>
      </div>
    </div>
    <div id="calendarView" ng-controller="CalendarViewController">
      <div class="container-fluid">
        <div class="room-headings">
          <table class="">
            <tr style="height: 44px"><td>&nbsp;</td></tr>
            <tr><td>Price and Availability</td></tr>
            <tr><td>&nbsp;</td></tr>
            <tbody ng-repeat="roomSizeName in roomSizeList">
              <tr class="roomSizeName" data-room-id="{{roomSizeName.id}}"><td>{{roomSizeName.label}}</td></tr>
              <tr class="roomAvailable"><td>Rooms Available</td></tr>
              <tr class="roomPrice"><td>Price</td></tr>
            </tbody>
          </table>
        </div>
        <div class="year-selector">
          <select name="" id="" ng-model="currentMonth" ng-change="updateCalendar()" class="form-control">
            <option  ng-repeat="month in months">{{month}}</option>
          </select>
          <select name="" id="" ng-model="currentYear" ng-change="updateCalendar()" class="form-control">
            <option ng-repeat="year in [] | range:25">{{year}}</option>
          </select>
        </div>
        <div class="room-content">
          <table class="">
            <tr><td ng-repeat="day in dayNames track by $index">{{day}}</td></tr>
            <tr><td ng-repeat="day in dayNames track by $index">{{$index+1}}</td></tr>
            <tbody ng-repeat="roomSizeName in roomSizeList">
              <tr class="roomSizeName"><td colspan="{{monthLength}}">&nbsp;</td></tr>
              <tr class="roomAvailable">
                <td ng-repeat="roomValues in roomAndPrice[roomSizeName.id] track by $index">
                  <div  ng-click="roomValues.editRoom=!roomValues.editRoom">{{roomValues.room}}</div> 
                  <div class="edit" ng-show="roomValues.editRoom">
                    <form name="editRoomForm">
                      <input type="text" name="room" class="form-control form-inline" ng-model="roomAndPrice[roomSizeName.id][$index].room" ng-model-options="{ updateOn: 'submit' }" ng-change="updateCell(roomValues.id, roomAndPrice[roomSizeName.id][$index].room, roomAndPrice[roomSizeName.id][$index].price)"> 
                      <button class="btn btn-primary" type="submit" ng-click="roomValues.editRoom=!roomValues.editRoom"><i class="fa fa-check" aria-hidden="true"></i></button>
                      <button class="btn btn-default" ng-click="editRoomForm.room.$rollbackViewValue();roomValues.editRoom=!roomValues.editRoom"><i class="fa fa-times" aria-hidden="true"></i></button>
                    </form>
                  </div>
                </td>
              </tr>
              <tr class="roomPrice">
                <td ng-repeat="roomValues in roomAndPrice[roomSizeName.id] track by $index">
                  <div ng-click="roomValues.editPrice=!roomValues.editPrice">{{roomValues.price}}</div> 
                  <div class="edit" ng-show="roomValues.editPrice">
                    <form name="editPriceForm">
                      <input type="text" name="price" class="form-control form-inline" ng-model="roomAndPrice[roomSizeName.id][$index].price" ng-model-options="{ updateOn: 'submit' }" ng-change="updateCell(roomValues.id, roomAndPrice[roomSizeName.id][$index].room, roomAndPrice[roomSizeName.id][$index].price)"> 
                      <button class="btn btn-primary" ng-click="roomValues.editPrice=!roomValues.editPrice;" type="submit"><i class="fa fa-check" aria-hidden="true"></i>
                      </button>
                      <button class="btn btn-default" ng-click="editPriceForm.price.$rollbackViewValue();roomValues.editPrice=!roomValues.editPrice"><i class="fa fa-times" aria-hidden="true"></i></button>
                    </form>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</body>
</html>