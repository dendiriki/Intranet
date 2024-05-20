<!DOCTYPE html>
<html lang="en">
  <?php include 'common/header.php' ?> 
  <body>
    <?php include 'common/navigation.php' ?>
    <div class="section"></div>
    <div class="container">
      <div class="card-panel">
        <div class="center">
          <div class="row">
            <div class="input-field col s3">
              <input placeholder="Sales Order No." id="vbeln" type="text" class="validate">
              <label for="vbeln">Sales Order No.</label>
            </div>
            <div class="input-field col s3">
              <a class="waves-effect waves-light btn" onclick="checkSO()">check</a>
            </div>
            <div class="input-field col s3">
              <input placeholder="Max Doscount" id="kbetr_max" type="number" class="validate">
              <label for="kbetr_max">Max Discount</label>
            </div>
            <div class="input-field col s3">
              <a class="waves-effect waves-light btn" onclick="updateDisc()">update</a>
            </div>
            <div class="col s12">
              <table class="striped bordered">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>SO Doc.</th>
                    <th>Item</th>
                    <th>Material</th>
                    <th>Sold To</th>
                    <th>Max Discount</th>
                  </tr>
                </thead>
                <tbody id="table-so">
                  
                </tbody>
              </table>
            </div>
          </div>
            
        </div>
      </div>
    </div>
    <?php include 'common/footer.php' ?>  
    <script>
    function checkSO() {
      $("#table-so").empty();
      var vbeln = $("#vbeln").val();
      if(vbeln) {
        $.ajax({
          type: "POST",
          url: "index.php?action=diskon&ajax_get_so=true",
          crossDomain: true,
          cache: false,
          data: {vbeln:vbeln},
          success: function (data) {
            var obj = $.parseJSON(data);
            if (obj.status == true) {
              var data = obj.data; 
              var i = 1;
              $.each(data, function(index, value){
                var str_append = "<tr><td>"+i+"</td><td>"+value.VBELN+"</td><td>"+value.POSNR+"</td><td>"+value.MATNR+"</td><td>"+value.NAME1+"</td><td>"+value.KBETR_MAX+"</td></tr>";
                $("#table-so").append(str_append);
                i++;
              });
            } else {
              Materialize.toast(obj.message, 4000);
            }
          }
        });
      } else {
        $("#vbeln").focus();
        Materialize.toast("SO Kosong!!!", 4000);
      }
        
    }
    
    function updateDisc() {
      var vbeln = $("#vbeln").val();
      var kbetr_max = $("#kbetr_max").val();
      if(kbetr_max && vbeln) {
        $.ajax({
          type: "POST",
          url: "index.php?action=diskon&ajax_update_disc=true",
          crossDomain: true,
          cache: false,
          data: {vbeln:vbeln, kbetr_max:kbetr_max},
          success: function (data) {
            checkSO();
            var obj = $.parseJSON(data);
            if (obj.status == true) {
              Materialize.toast("Discount Updated", 4000);
            } else {
              Materialize.toast(obj.message, 4000);
            }
          }
        });
      } else {
        Materialize.toast("SO / Diskon Kosong!!!", 4000);
      }
    }
    </script>
  </body>
</html>
