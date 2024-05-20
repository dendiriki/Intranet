<!DOCTYPE html>
<html lang="en">
  <?php include 'common/header.php' ?> 
  <body>
    <?php include 'common/navigation.php' ?>

    <div class="container">
      <div class="section">
        <div class="row">
          <div class="col s12 m12">
            <div class="card">
              <div class="card-content">
                <div class="card-title">
                  Manage News And Event
                </div>
                <p>
                  <?php if (isset($data["success"])) echo "<div class='teal-text text-lighten-2'>" . $data["success"] . "</div>"; ?>
                <ul class="collection with-header">
                  <li class="collection-header">
                    <a href="?action=edit_news&articleId=0" class="waves-effect waves-teal btn-flat">
                      ADD NEW ARTICLE
                    </a>
                  </li>
                  <?php
                  foreach ($data["article"] as $list) {
                    ?>
                    <li id="list-article" class="collection-item avatar">
                      <?php 
                      $icon = null;
                      $color = null;
                      switch ($list->type) {
                        case "N":
                          $icon = "&#xE8CD;";
                          $color = "teal";
                          break;
                        case "E":
                          $icon = "&#xE85A;";
                          $color = "amber";
                          break;
                        case "T":
                          $icon = "&#xE80C;";
                          $color = "light-blue";
                          break;
                        default:
                          break;
                      }
                      ?>
                      <i class="material-icons circle <?php echo $color; ?>"><?php echo $icon; ?></i>
                      <span class="title"><?php echo $list->date . " - " . $list->title; ?></span>
                      <p class="black-text">
                        <?php echo $list->summary; ?>
                      </p>
                      <a class="secondary-content" href="?action=edit_news&articleId=<?php echo $list->id; ?>"><i class="material-icons">mode_edit</i></a>
                    </li>            
                  <?php } ?>
                </ul>
                </p>
              </div>
              <div class="card-action">
                <a href="?action=edit_news&articleId=0" class="waves-effect waves-teal btn-flat">
                  ADD NEW ARTICLE
                </a>
              </div>
            </div>            

          </div>
        </div>
      </div>

    </div>
    <?php include 'common/footer.php' ?>  

  </body>
</html>