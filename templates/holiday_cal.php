<!DOCTYPE html>
<html lang="en">
  <?php include 'common/header.php' ?> 
  <body>
    <?php include 'common/navigation.php' ?>

    <div class="container">
      <div class="section">
        <div class="row">        
          <div class="col s12">
            <div id='calendar'></div>
          </div>  
        </div>
      </div>
    </div>
    <?php include 'common/footer.php' ?>
    <script src="templates/vendor/fullcalendar/lib/moment.min.js" type="text/javascript"></script>
    <script src="templates/vendor/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
    <script>
      $(document).ready(function () {

        $('#calendar').fullCalendar({
          header: {
            left : "prev,next today",
            center: 'title',
            right: 'listYear,month,basicWeek'
          },
          navLinks: true, // can click day/week names to navigate views
          editable: false,
          eventLimit: true, // allow "more" link when too many events
          defaultView: "listYear",
          locale: "id",
          events: {
            url: 'index.php?action=holiday_cal',
            type: 'POST',
            data: {
                get_events: 'true',
            },
            error: function() {
                alert('there was an error while fetching events!');
            }
          }       
        });

      });

    </script>
  </body>
</html>
