<!DOCTYPE html>
<html lang="en">
  <?php include 'common/header.php' ?> 
  <body>
    <?php include 'common/navigation.php' ?>

    <div class="container">
      <div class="section">
        <div class="row">
          <div class="col s12 m12">
            <h5 class="center">Application for Annual Leave</h5>
            <div class="card-panel">
              <?php $id = $_GET["id"]; ?>
              <form action="?action=annual_leave_appl&id=<?php echo $id; ?>&save=true" method="POST">
                <input type="hidden" name="payroll" value="<?php if(isset($employee)) echo $employee->payroll ?>">
                <div class="input-field">
                  <input disabled id="name" type="text" class="validate" value="<?php if(isset($employee)) echo $employee->name ?>">
                  <label for="name">Name</label>
                </div>            
                <div class="input-field">
                  <input name="designation" id="designation" type="text" class="validate">
                  <label for="designation">Designation</label>
                </div>
                <input name="request" type="radio" id="lv" value="L" checked />
                <label for="lv">Leave</label>
                <input name="request" type="radio" id="ec" value="E" />
                <label for="ec">Encashment</label>
                <div>
                  <div class="input-field inline">
                    <input name="from" id="from" type="date" class="datepicker lvgrp">
                    <label for="from">Leave From</label>
                  </div>              
                  <div class="input-field inline">  
                    <input name="to" id="to" type="date" class="datepicker lvgrp">
                    <label for="from">To</label>
                  </div>            
                  <div class="input-field inline">  
                    <input id="duration" type="number" disabled>
                    <label for="duration">Duration</label>
                  </div>
                  <input type="hidden" name="duration" id="real-duration">
                  days
                </div>
                <div>
                  <div class="input-field inline">  
                    <input name="encashment" id="encashment" type="number" class="validate ecgrp">
                    <label for="encashment">Encashment for</label>
                  </div>
                  days
                </div>
                <button class="waves-effect waves-light btn" name="apply" type="submit" value="apply">Apply</button>
              </form>
            </div>
          </div>
        </div>
      </div>

    </div>
    <?php include 'common/footer.php' ?>  

    <script>
      $(document).ready(function(){
        $('.datepicker').pickadate({
          selectMonths: true, // Creates a dropdown to control month
          selectYears: 15, // Creates a dropdown of 15 years to control year
          format: "dd-mm-yyyy"
        });
        
        $("#designation").focus();
        
        if($("#lv").is(':checked')) {
          $(".ecgrp").attr("disabled", true);
        } else {
          $(".lvgrp").attr("disabled", true);
        }
        
        $('input[name="request"]').change(function(){
          if($('#lv').prop('checked')){
            $(".ecgrp").attr("disabled", true);
            $(".lvgrp").removeAttr("disabled");
          }else{
            $(".lvgrp").attr("disabled", true);
            $(".ecgrp").removeAttr("disabled");
          }
        });
        
        $('#to').change(function(){
          if($("#from").val() === null || $("#from").val() === "" ) {
            $("#from").focus();
          } else {
            hitungTanggal();
          }
        });
        
        $("#from").change(function(){
          if($("#to").val() === null || $("#to").val() === "" ) {
            $("#to").focus();
          } else {
            hitungTanggal();
          }
        });
      });
      
      function hitungTanggal() {
        var dateFrom = new Date(toISODate($("#from").val()));
        var dateTo = new Date(toISODate($("#to").val()));
        var duration = new Date(dateTo - dateFrom);
        var days = (duration/1000/60/60/24) + 1;
        $("#duration").val(days);
        $("#real-duration").val(days);
        
        if(days < 1) {
          alert("Date From cannot overlap date To");
          $("#from").focus();
        }
        Materialize.updateTextFields();
      }
      
      /* date input format = dd-mm-yyyy
       * date output format = yyyy-mm-dd*/
      function toISODate(date) {
        var temp = date.split("-");
        return temp[2]+"-"+temp[1]+"-"+temp[0];
      }
    </script>
  </body>
</html>
