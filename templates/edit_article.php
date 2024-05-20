<!DOCTYPE html>
<html lang="en">
  <?php include 'common/header.php' ?> 
  <body>
    <?php include 'common/navigation.php' ?>

    <div class="container">
      <div class="section">
        <div class="row">
          <div class="col s12 m12">
            <form method="POST" action="?action=edit_news&articleId=<?php if(isset($data["article"])) {echo $data["article"]->id;} else echo "0" ?>" enctype="multipart/form-data">
            <div class="card">
              <div class="card-content">
                <div class="card-title">
                  <?php echo $data["action"]; ?>
                </div>
                <div class="row">
                  <?php if (isset($data["error"])) echo "<div class='.mdl-color-text--red'>" . $data["error"] . "</div>"; ?>
                  <input type="hidden" name="id" value="<?php if (isset($data["article"])) echo $data["article"]->id; ?>"/>
                  
                  <div class="input-field col m6 s12">
                    <input name="date" type="text" class="datepicker" id="date-input" value="<?php if (isset($data["article"])) echo $data["article"]->date; ?>" />
                    <label for="date-input">Tanggal</label>
                  </div>
                  
                  <div class="input-field col m3 s12">
                    <select name="art-type" required="required">
                      <option value="" disabled  <?php if (!isset($data["article"])) {echo "selected";} ?>>Choose Article Type</option>
                      <option value="N" <?php if (isset($data["article"])) {if($data["article"]->type == "N") echo "selected";} ?>>News</option>
                      <option value="E" <?php if (isset($data["article"])) {if($data["article"]->type == "E") echo "selected";} ?>>Event</option>
                      <option value="T" <?php if (isset($data["article"])) {if($data["article"]->type == "T") echo "selected";} ?>>Training</option>
                    </select>
                    <label>Article Type</label>
                  </div>
                  
                  <div class="input-field col m3 s12">
                    <select name="art-status" required="required">
                      <option value="D" <?php if (isset($data["article"])) {if($data["article"]->status == "D") echo "selected";} ?>>Draft</option>
                      <option value="P" <?php if (isset($data["article"])) {if($data["article"]->status == "P") echo "selected";} ?>>Published</option>
                    </select>
                    <label>Status</label>
                  </div>
                  
                  <div class="input-field col s12">
                    <input name="title" type="text" id="title" value="<?php if (isset($data["article"])) echo $data["article"]->title; ?>" />
                    <label for="title">Judul</label>
                  </div>
                  <div class="input-field col s12">
                    <textarea class="materialize-textarea" name="summary" id="summary" rows="3" data-length="200"><?php if (isset($data["article"])) echo trim($data["article"]->summary, " "); ?></textarea>
                    <label for="summary">Ringkasan (Max 1000 char)</label>
                  </div>
                  <div class="input-field col s12" style="margin-bottom: 10px;">
                    <textarea name="content" id="konten" style="height: 15em;width: 100%;"><?php if (isset($data["article"])) echo $data["article"]->content; ?></textarea>
                  </div>
                  <div class="file-field col s12">
                    <div class="btn">
                      <span>Main Image</span>
                      <input name="image_main" type="file">
                    </div>
                    <div class="file-path-wrapper">
                      <input class="file-path validate" type="text" placeholder="Upload one files">
                    </div>
                  </div>
                  <div class="file-field col s12">
                    <div class="btn">
                      <span>Additional Images</span>
                      <input name="image_additional[]" type="file" multiple>
                    </div>
                    <div class="file-path-wrapper">
                      <input class="file-path validate" type="text" placeholder="Upload one or more files">
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-action">
                <button class="waves-effect waves-teal btn-flat" type="submit" value="submit" name="save" >SAVE</button>
                <button class="waves-effect waves-teal btn-flat" type="button" value="cancel" name="cancel" onclick="window.history.back()">CANCEL</button>
              </div>
            </div>            
            </form>
          </div>
        </div>
      </div>

    </div>
    <?php include 'common/footer.php' ?>  

    <script src="templates/vendor/tinymce/tinymce.min.js" type="text/javascript"></script>
    <script>
      $(document).ready(function() {
        tinymce.PluginManager.add('charactercount', function (editor) {
          var self = this;

          function update() {
            editor.theme.panel.find('#charactercount').text(['Characters: {0}', self.getCount()]);
          }

          editor.on('init', function () {
            var statusbar = editor.theme.panel && editor.theme.panel.find('#statusbar')[0];

            if (statusbar) {
              window.setTimeout(function () {
                statusbar.insert({
                  type: 'label',
                  name: 'charactercount',
                  text: ['Characters: {0}', self.getCount()],
                  classes: 'charactercount',
                  disabled: editor.settings.readonly
                }, 0);

                editor.on('setcontent beforeaddundo', update);

                editor.on('keyup', function (e) {
                    update();
                });
              }, 0);
            }
          });

          self.getCount = function () {
            var tx = editor.getContent({ format: 'raw' });
            var decoded = decodeHtml(tx);
            var decodedStripped = decoded.replace(/(<([^>]+)>)/ig, "").trim();
            var tc = decodedStripped.length;
            return tc;
          };

          function decodeHtml(html) {
            var txt = document.createElement("textarea");
            txt.innerHTML = html;
            return txt.value;
          }
        });
        
        $('select').material_select();
        
        $('.datepicker').pickadate({
          selectMonths: true, // Creates a dropdown to control month
          selectYears: 15 // Creates a dropdown of 15 years to control year
        });
        
        tinymce.init({
          selector: '#konten',
          plugins: 'advlist autolink link image lists charmap print preview table media code charactercount',
          image_description: false,
          table_class_list: [
            {title: 'None', value: ''}
          ],
          file_browser_callback: RoxyFileBrowser,
          setup: function (editor) {
            editor.on('change', function () {
              editor.save();
              var count = this.plugins["charactercount"].getCount();
              if (count > 5000)
                $('#invalidContentHtml').show();
              else
                $('#invalidContentHtml').hide();
            });
          },
          init_instance_callback: function (editor) {
            $('.mce-tinymce').show('fast');
            $(editor.getContainer()).find(".mce-path").css("display", "none");
          }
        });
        
        function RoxyFileBrowser(field_name, url, type, win) {
          var roxyFileman = 'fileman/index.html';
          if (roxyFileman.indexOf("?") < 0) {
            roxyFileman += "?type=" + type;
          } else {
            roxyFileman += "&type=" + type;
          }
          roxyFileman += '&input=' + field_name + '&value=' + win.document.getElementById(field_name).value;
          if (tinyMCE.activeEditor.settings.language) {
            roxyFileman += '&langCode=' + tinyMCE.activeEditor.settings.language;
          }
          tinyMCE.activeEditor.windowManager.open({
            file: roxyFileman,
            title: 'Image Manager',
            width: 850,
            height: 650,
            resizable: "yes",
            plugins: "media",
            inline: "yes",
            close_previous: "no"
          }, {window: win, input: field_name});
          return false;
        }
      });
      
    </script>
  </body>
</html>