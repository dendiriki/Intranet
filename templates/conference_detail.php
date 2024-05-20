<!DOCTYPE html>
<html lang="en">
  <?php include 'common/header.php' ?> 
  <body>
    <?php include 'common/navigation.php' ?>

    <div class="container content">
      <div class="section">
        <div class="row">
          <h5 class="center"><?php echo $room["name"]. " Booking/Availability"; ?></h5>
          <div class="col s12">
            <?php 
            if(isset($successMsg)) {
              echo "<div class='center teal-text'>".$successMsg."</div>";
            }
            
            if(isset($errorMsg)) {
              echo "<div class='center red-text'>".$errorMsg."</div>";
            }
            ?>
            <button onclick="window.history.back()" class="waves-effect waves-light btn"><i class="material-icons left">arrow_back</i>Back</button>
            <button data-target="modal-book-room" class="waves-effect waves-light btn">book this room</button>
            <br>
            <table class="bordered striped">
              <thead>
                <tr>
                    <th>Date</th>
                    <th>Time Start</th>
                    <th>Time End</th>
                    <th>Booked By</th>
                    <th>Department</th>
                    <th>Remark</th>
                </tr>
              </thead>

              <tbody>
                <?php 
                if(!empty($book_list)) {
                  foreach($book_list as $book) {
                    ?>
                <tr>
                  <td><?php echo $book["date"]; ?></td>
                  <td><?php echo $book["start"]; ?></td>
                  <td><?php echo $book["end"]; ?></td>
                  <td><?php echo $book["by"]; ?></td>
                  <td><?php echo $book["dept"]; ?></td>
                  <td><?php echo $book["remark"]; ?></td>
                </tr>
                    <?php
                  }
                } else {
                  echo "<tr><td colspan='6'>This Room has not booked yet</td></tr>";
                }
                ?>
                
              </tbody>
            </table>
            <br />
            <button onclick="window.history.back()" class="waves-effect waves-light btn"><i class="material-icons left">arrow_back</i>Back</button>
            <button data-target="modal-book-room" class="waves-effect waves-light btn">book this room</button>
          </div>
          
        </div>
      </div>

    </div>
    
    <!-- Modal Structure -->
    <div id="modal-book-room" class="modal modal-fixed-footer modal-90">
      <form method="POST" action="?action=conf_list&room_id=<?php echo $room["id"]; ?>">
      <div class="modal-content">
        <h4>Book This Conference Room</h4>
        <div class="row">
          <div class="input-field col s12 m12">
            <input name="long_book" type="checkbox" class="filled-in" id="long_book" />
            <label for="long_book">Long Book</label>
          </div>
          <div class="input-field col s12 m3">
            <input name="date" id="date" type="date" class="datepicker validate" required="required">
            <label for="date">Date Start</label>
          </div>
          <div class="input-field col s12 m3">
            <input name="date2" id="date2" type="date" class="datepicker validate" disabled="true">
            <label for="date2">Date End</label>
          </div>
          <div class="input-field col s12 m3">
            <input name="start" id="time_start" class="timepicker" type="text" required="required">
            <label for="time_start">Time Start</label>
          </div>
          <div class="input-field col s12 m3">
            <input name="end" id="time_end" class="timepicker" type="text" required="required">
            <label for="time_end">Time End</label>
          </div>
          <div class="input-field col s12 m6">
            <input name="by" placeholder="Your Name" id="book_by" type="text" class="validate" required="required">
            <label for="book_by">Your Name</label>
          </div>
          <div class="input-field col s12 m6">
            <input name="dept" placeholder="Your Department" id="book_dept" type="text" class="validate" required="required">
            <label for="book_dept">Your Department</label>
          </div>
          <div class="input-field col s12 m12">
            <textarea name="remark" id="remark" class="materialize-textarea" data-length="1000" required="required"></textarea>
            <label for="remark">Remarks</label>
          </div>
        </div>
        <input type="hidden" name="room_id" value="<?php echo $room["id"]; ?>">
      </div>
      <div class="modal-footer">
        <button class="modal-action modal-close waves-effect waves-green btn-flat">Cancel</button>
        <button type="submit" name="save" value="save" class="modal-action waves-effect waves-green btn-flat">Book Now</button>
      </div>
      </form>
    </div>
    <?php include 'common/footer.php' ?>  
    <script>
    $(document).ready(function(){
      $('.datepicker').pickadate({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 15 // Creates a dropdown of 15 years to control year
      });
      
      //Time Picker:
      $('.timepicker').pickatime({
        default: 'now', // Set default time
        fromnow: 0,       // set default time to * milliseconds from now (using with default = 'now')
        twelvehour: false, // Use AM/PM or 24-hour format
        donetext: 'OK', // text for done-button
        cleartext: 'Clear', // text for clear-button
        canceltext: 'Cancel', // Text for cancel-button
        autoclose: false // automatic close timepicker
      });
      
      $("#long_book").change(function(){
        $("#date2").val("");
        if(this.checked) {
          $("#date2").removeAttr("disabled");
        } else {
          $("#date2").attr("disabled", true);
        }
      });
    });
    </script>
  </body>
</html>
