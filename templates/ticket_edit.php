<!DOCTYPE html>
<html lang="en">
  <?php include 'common/header.php' ?> 
  <body>
    <?php include 'common/navigation_blank.php' ?>
    
    <div class="container main-content">
      <div class="section">
        <form id="form-ticket" action="?action=it_ticket&ticket=<?php if(isset($data["inquiry"])) {echo $data["inquiry"]->id;} else {echo "0";} ?>&save=true" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="it_support" id="it_support" value="<?php echo $role_it_support; ?>">
          <input type="hidden" name="authcheck" id="authcheck" value="<?php if(isset($data["authcheck"])) {echo $data["authcheck"];} ?>" >
          <div class="card">
              <div class="card-image">
                <img src="templates/images/it_support.jpg" alt=""/>
                <span class="card-title"><?php if(isset($data["inquiry"])) {if($data["inquiry"]->id != 0) {echo "Ticket Number ".$data["inquiry"]->id." On ".$data["inquiry"]->create_date."";} else{echo "Open New Ticket";}}?></span>
              </div>
              <div class="card-content">
                <?php 
                if(isset($data["error"])) {
                  echo '<p class="red-text">'.$data["error"].'</p>';
                }

                if(isset($_GET["error"])) {
                  if(!empty($_GET["error"])) {
                    echo '<p class="red-text">'.$_GET["error"].'</p>';
                  }                
                }
                ?>

                <div class="row">
                  <input type="hidden" id="ticket_no" name="ticket_no" value="<?php if(isset($data["inquiry"])) {echo $data["inquiry"]->id;} else {echo "0";} ?>">
                  <div class="input-field col m5 s12">
                    <input id="req_by" name="req_by" type="text" class="autocomplete validate dis" required="required" 
                           value="<?php if(isset($data["inquiry"])) {
                                    $printed_name = $data["inquiry"]->req_by;
                                    if(!empty($data["inquiry"]->req_name)) {
                                      $printed_name .= " - ".$data["inquiry"]->req_name;
                                    }
                                    echo $printed_name;                                  
                                  } ?>">
                    <label for="req_by">On Behalf</label>
                  </div>
                  
                  <?php
                  if(isset($extension)) {
                  ?>
                  <div class="input-field col m1 s12">
                    <input name="telp_ext" id="telp_ext" type="text" value="<?php echo $extension; ?>" disabled="disabled" />
                    <label for="telp_ext">Ext. Number</label>
                  </div>
                  <?php
                  } 
                  ?>
                  
                  <div class="input-field col m3 s12">
                    <select onchange="getSubCategory()" id="up_kategori" name="up_kategori" required="required" class="dis validate">
                      <option value="">SELECT CATEGORY</option>
                      <option value="H" <?php if(isset($data["inquiry"])){if($data["inquiry"]->up_category == "H"){echo "selected";}} ?>>HARDWARE</option>
                      <option value="S" <?php if(isset($data["inquiry"])){if($data["inquiry"]->up_category == "S"){echo "selected";}} ?>>SOFTWARE</option>
                    </select>
                    <label for="kategori">Category</label>
                  </div>

                  <div class="input-field col m3 s12">
                    <input type="hidden" name="cek_kategori" id="cek_kategori" value="<?php if(isset($data["inquiry"])){echo $data["inquiry"]->category;} else {echo "0";} ?>">
                    <select id="kategori" name="kategori" required="required" class="dis validate">
                      <option value="">SELECT SUB CATEGORY</option>
                    </select>
                    <label for="kategori">Sub Category</label>
                  </div>
                  
                  <div class="input-field col s12">
                    <input id="subjek" 
                           name="subjek" 
                           type="text" 
                           class="validate dis" 
                           data-length="255"
                           value="<?php if(isset($data["inquiry"])) {echo htmlspecialchars($data["inquiry"]->subject);} ?>" 
                           required="required">
                    <label for="subjek">Subject</label>
                  </div>

                  <div class="input-field col s12">
                    <textarea id="detail" 
                              name="detail" 
                              class="materialize-textarea validate dis" 
                              data-length="4000" 
                              required="required"><?php if(isset($data["inquiry"])) {echo $data["inquiry"]->detail;} ?></textarea>
                    <label for="detail">Request Detail</label>
                  </div>

                  <?php 
                  if(!empty($data["replies"])) {
                    ?><div class="col s12 container">
                      <h6>Replies</h6>
                    <div class='row'><?php
                    foreach ($data["replies"] as $replies) {
                      echo "<div class='col s12'>"
                          . "<blockquote>"
                          . "<pre>"
                          . htmlspecialchars($replies["reply"])
                          . "</pre>"
                          . "<span class='small-text grey-text'>Replied on ".$replies["date"]." by ".$replies["reply_by"]." ".$replies["reply_name"]."</span>"
                          . "</blockquote></div>";
                    }
                    ?></div>
                    </div><?php
                  }
                  ?>              

                  <div class="input-field col s12 default-hidden" style="display: none;">
                    <textarea id="reply" 
                              name="reply" 
                              class="materialize-textarea" 
                              data-length="4000"></textarea>
                    <label for="reply">Reply Here</label>
                  </div>                

                  <div class="input-field col m6 s12">
                    <select id="priority" name="priority" class="validate dis auth">
                      <option value="L" <?php if(isset($data["inquiry"])) {if($data["inquiry"]->priority == "L"){echo "selected";}} ?>>LOW</option>
                      <option value="M" <?php if(isset($data["inquiry"])) {if($data["inquiry"]->priority == "M"){echo "selected";}} ?>>MIDDLE</option>
                      <option value="H" <?php if(isset($data["inquiry"])) {if($data["inquiry"]->priority == "H"){echo "selected";}} ?>>HIGH</option>
                    </select>
                    <label for="priority">Priority</label>
                  </div>

                  <div class="input-field col m6 s12">
                    <select id="status" name="status" class="validate auth" onchange="validatePIC()">
                      <option value="O" <?php if(isset($data["inquiry"])) {if($data["inquiry"]->status == "O"){echo "selected";}} ?>>OPEN</option>
                      <?php
                      if(isset($data["inquiry"])) {
                        if($data["inquiry"]->id > 0 || $data["it_support"] > 0) {
                      ?>
                      <option value="P" <?php if(isset($data["inquiry"])) {if($data["inquiry"]->status == "P"){echo "selected";}} ?>>ON PROGRESS</option>                    
                      <option value="N" <?php if(isset($data["inquiry"])) {if($data["inquiry"]->status == "N"){echo "selected";}} ?>>NEED CONFIRMATION</option>
                      <option value="X" <?php if(isset($data["inquiry"])) {if($data["inquiry"]->status == "X"){echo "selected";}} ?>>CLOSED</option>
                      <option value="C" <?php if(isset($data["inquiry"])) {if($data["inquiry"]->status == "C"){echo "selected";}} ?>>CANCELED</option>
                      <?php 
                        }                    
                      }
                      ?>
                    </select>
                    <label for="status">Status</label>
                  </div>
                  <?php
                  if($data["it_support"] >= 1 || $data["inquiry"]->id > 0) {
                  ?>
                    <div class="input-field col m6 s12">
                      <select onchange="changeStatus()" id="pic" name="pic" class="validate auth dis" >
                        <option value="" selected>Assign To</option>
                        <?php
                        $the_pic = null;
                        if(isset($data["inquiry"]->pic)) {
                          $the_pic = $data["inquiry"]->pic;
                        }
                        foreach($data["it_support_list"] as $it_list) {
                          if($it_list["username"] == $the_pic) {
                            echo "<option value='".$it_list["username"]."' selected>".$it_list["name"]."</option>";
                          } else {
                            echo "<option value='".$it_list["username"]."'>".$it_list["name"]."</option>";
                          }
                        }
                        ?>
                      </select>
                      <label for="pic">Person In Charge</label>
                    </div>
                  <?php 
                  }?>

                  <?php
                  if(isset($data["status_log"])) {
                  ?>
                    <div class="input-field col m6 s12">
                      <ul class="collection with-header">
                        <li class="collection-header"><h6>Status Log</h6></li>
                        <?php
                        foreach($data["status_log"] as $status_log) {
                          echo '<li class="collection-item"><p style="font-size:9px;">'.$status_log["date"].' - '.$status_log["status_desc"].' - '
                                  . 'By: '.$status_log["changed_name"].'</p></li>';
                        }
                        ?>

                      </ul>
                    </div>
                  <?php 
                  }
                  ?>

                  <?php 
                  if(isset($data["attachment"])) {
                    if(!empty($data["attachment"])) {
                      echo '<div class="col s12 container">'
                         . '<div class="card-panel">'
                         . '<div class="row">';
                      foreach ($data["attachment"] as $attachment) {
                        echo "<div class='col m6 s12'><a class='btn-flat wave-effect blue-text' href='media/ticket_attachment/".$data["inquiry"]->id."/$attachment' target='_blank'><i class='material-icons left'>&#xE2BC;</i>$attachment</a></div>";
                      }
                      echo '</div></div></div>';                
                    }
                  }
                  ?>
                  <div class="file-field col s12 attach">
                    <div class="btn">
                      <span>Attachment 1</span>
                      <input name="attachment1" type="file" class="attach">
                    </div>
                    <div class="file-path-wrapper">
                      <input class="file-path validate attach" type="text" placeholder="Upload Files Here">
                    </div>
                  </div>       

                  <div class="file-field col s12 attach">
                    <div class="btn">
                      <span>Attachment 2</span>
                      <input name="attachment2" type="file" class="attach">
                    </div>
                    <div class="file-path-wrapper">
                      <input class="file-path validate dis attach" type="text" placeholder="Upload Files Here">
                    </div>
                  </div>
                </div>
                <div id="loader-save" class="progress" style="display: none">
                  <div class="indeterminate"></div>
                </div>
              </div>
              <div class="card-action">
                <button id="btn-save" type="submit" name="save" value="save" class="btn waves-effect btn-auth"><i class="material-icons right">&#xE161;</i>Save</button>                
                <button id="btn-reply" style="display: none;" type="button" class="btn waves-effect reply-button btn-auth" onclick="replyAction()"><i class="material-icons right">&#xE15E;</i>Reply</button>
                <a id="btn-cancel" href="?action=it_ticket" class="btn waves-effect" ><i class="material-icons right">&#xE314;</i>Back</a>
              </div>

          </div>
        </form>
      </div>

    </div>
    <?php include 'common/footer_blank.php' ?>  
    
    <script>
      $(document).ready(function() {
        $('#detail').trigger('autoresize');
        
        var id = $("#ticket_no").val();
        if(id !== "0") {
          disableInput();
          $(".reply-button").show();
        }
        getSubCategory();
        
        $('select').material_select(); 
        
        $('select[required]').css({
          display: 'inline',
          position: 'absolute',
          float: 'left',
          padding: 0,
          margin: 0,
          border: '1px solid rgba(255,255,255,0)',
          height: 0, 
          width: 0,
          top: '1.5em',
          left: '11.5em'
        });
        
        $('input.autocomplete').autocomplete({
          data: {
            <?php
            $data_emp = array();
            if(isset($data["employee"])) {
              foreach($data["employee"] as $emp_list) {
                $data_emp[] = '"'.$emp_list["username"].' - '.$emp_list["name"].'":null';
              }
              echo implode(",",$data_emp);
            }
            ?>
          }
        });
        
        cekAuth();
        
        checkDocStatus();
      });
      
      function disableInput() {
        $(".dis").attr("disabled",true);
        $(".hid").hide();
        var it_support = $("#it_support").val();
        if(it_support >= 1) {
          $("#priority").removeAttr('disabled');
          $(".dis").removeAttr('disabled');
        }
        var status = $("#status").val(); 
        if(status == "X" || status == "C" ) {
          $(".attach").attr("disabled",true);
        }
      }
            
      function replyAction() {
        $(".default-hidden").show();
      }
      
      function getSubCategory() {
        var up_category = $("#up_kategori").val();
        var cek_category = $("#cek_kategori").val();
        if(!isEmpty(up_category)) {
          $.ajax({
            type: "GET",
            url: "index.php?action=ajax_get_category&sup_cat="+up_category,
            crossDomain: true,
            cache: false,
            success: function (data) {
              $("#kategori").empty();
              $("#kategori").append('<option value="">SELECT SUB CATEGORY</option>');
              var category = $.parseJSON(data);
              $.each(category, function(i, field){
                if(cek_category == "0") {
                  $("#kategori").append('<option value="'+field.id+'">'+field.desc+'</option>');
                } else {
                  if(field.id == cek_category) {
                    $("#kategori").append('<option value="'+field.id+'" selected>'+field.desc+'</option>');
                  } else {
                    $("#kategori").append('<option value="'+field.id+'">'+field.desc+'</option>');
                  }
                }                
              });
              $('select').material_select();
            }
          });
        } else {
          $("#kategori").empty();
          $("#kategori").append('<option value="">SELECT SUB CATEGORY</option>');
          $('select').material_select();
        }
      }
      
      function cekAuth() {
        var authcheck=$("#authcheck").val(); 
        if(authcheck == 1) {
          $(".btn-auth").hide();
          $(".attach").hide();
          $(".auth").attr("disabled",true);
          $(".dis").attr("disabled",true);
        }
      }
      
      function checkDocStatus() {       
        var status = $("#status").val(); 
        if(status == "X" || status == "C") {
          $(".btn-auth").hide();
          $(".auth").attr("disabled",true);
          $(".dis").attr("disabled",true);
          $(".attach").hide();
        }
      }
      
      function changeStatus() {
        var current_status = $("#status").val();
        var pic = $("#pic").val();
        if(pic.length > 0) {
          if(current_status == "O") {
            $("#status").val("P");
            $('select').material_select();
          }
        }
      }
      
      function validatePIC() {
        var current_status = $("#status").val();
        /*var is_it_support = $("#it_support").val();*/
        if(current_status == "X") {
          $("#pic").attr("required","required");
          $('select').material_select();
        }
      }
      
      function showProgress() {
        $("#btn-save").hide();
        $("#btn-reply").hide();
        $("#btn-cancel").hide();
        $("#loader-save").show();
               
      }
      
      function hideProgress() {
        $("#btn-save").show();
        $("#btn-reply").show();
        $("#btn-cancel").show();
        $("#loader-save").hide();
      }
      
      $("#form-ticket").submit(function(){
        $('.dis').removeAttr('disabled');
        showProgress();
        var category = $.trim($("#kategori").val());
        if(isEmpty(category)) {
          $('.dis').attr("disabled","disabled");
          hideProgress();
          return false;
        } else {
          var status = $("#status").val();
          if(status == "O") {
            return true;
          } else {
            var pic = $("#pic").val();
            if(isEmpty(pic)) {
              $('.dis').attr("disabled","disabled");
              hideProgress();
              return false;
            } else {
              return true;
            }
          }          
        }        
      });
    </script>
  </body>
</html>
