<!doctype html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title> BOAT BOOKING</title>
      <link href="<?php echo base_url(); ?>assets/vendor/fontawesome/css/fontawesome.min.css" rel="stylesheet">
      <link href="<?php echo base_url(); ?>assets/vendor/fontawesome/css/solid.min.css" rel="stylesheet">
      <link href="<?php echo base_url(); ?>assets/vendor/fontawesome/css/brands.min.css" rel="stylesheet">
      <link href="<?php echo base_url(); ?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
      <link href="<?php echo base_url(); ?>assets/css/master.css" rel="stylesheet">
      <link href="<?php echo base_url();?>assets/css/jquery.timepicker.css" rel="stylesheet">
      <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
   </head>
   <body>
      <div class="wrapper">
         <!-- sidebar navigation component -->
         <!-- end of sidebar component -->
         <div id="body" class="active">
            <!-- navbar navigation component -->
            <!-- end of navbar navigation -->
            <div class="content">
               <div class="container">
                  <div class="page-title">
                     <h3>BOAT BOOKING</h3>
                  </div>
                  <div class="row">
                     <div class="col-lg-12">
                        <div class="card">
                           <div class="card-header">Boat Booking</div>
                           <div class="card-body">
                              <h5 class="card-title">Booking Detail</h5>
                              <form class="needs-validation" novalidate accept-charset="utf-8">

                              <input type="text" name="hidden_availability_id" id="hidden_availability_id" />
                                 <div class="row g-2">
                                    <div class="mb-3 col-md-3">
                                       <label for="boat_id" class="form-label">Select Boat</label>
                                       <select name="boat_id" id="boat_id" class="form-select" required>
                                          <option value="" >Select boat...</option>
                                          <?php foreach($boats as $boat){ ?>
                                              <option value="<?php echo $boat['id'];?>"><?php echo $boat['boat_name'];?></option>
                                          <?php } ?>
                                        
                                       </select>
                                    </div>
                                    <div class="mb-3 col-md-3">
                                       <label for="email" class="form-label">Booking Date</label>
                                       <input type="text" id="booking_date" class="form-control" name="booking_date"  required>
                                    </div>
                                    <div class="mb-3 col-md-3">
                                       <label for="booking_start_time" class="form-label">Start Time</label>
                                       <input type="text" class="form-control" name="booking_start_time" id="booking_start_time"  required>
                                    </div>
                                    <div class="mb-3 col-md-3">
                                       <label for="booking_end_time" class="form-label">End Time</label>
                                       <input type="text" class="form-control" name="booking_end_time" id="booking_end_time" required>
                                    </div>
                                 </div>
                                 <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Search</button>
                              </form>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
      <script src="<?php echo base_url(); ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
      <script src="<?php echo base_url(); ?>assets/js/form-validator.js"></script>
      <script src="<?php echo base_url(); ?>assets/js/script.js"></script>
      <script src="<?php echo base_url();?>assets/js/jquery.timepicker.js"></script>
      <script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
      <script>
         $( function() {
           $( "#booking_date" ).datepicker({ dateFormat: 'yy-mm-dd' });
         } );
      </script>
      <script>
         // $(document).ready(function() {
         //   $('#booking_start_time').timepicker({
         //       timeFormat: 'H:mm p',
         //       interval: 30,
         //       minTime: '6:00am',
         //       maxTime: '11:30pm',
         //       defaultTime: '',
         //       startTime: '6:00am',
         //       dynamic: false,
         //       dropdown: true,
         //       scrollbar: true
         //   });
         
         //   $('#booking_end_time').timepicker({
         //       timeFormat: 'H:mm p',
         //       interval: 30,
         //       minTime: '6:00am',
         //       maxTime: '11:30pm',
         //       defaultTime: '',
         //       startTime: '6:00am',
         //       dynamic: false,
         //       dropdown: true,
         //       scrollbar: true
         //   });
         // });
      </script>

      <script>
          $(document).ready(function(){
           
            $("#booking_date").on('change',function(){
               getAvailabilityTime();
            });
            $("#boat_id").on('change',function(){
               getAvailabilityTime();
            });

             function getAvailabilityTime(){
                  $('#booking_start_time').val('');
                  $('#booking_end_time').val('');
                
                  var bookingDate=$("#booking_date").val();
                  var boatId=$("#boat_id").val();
                 
                  $.ajax({
                      url:"<?php echo base_url('check-availability-type-time-acc-to-date'); ?>",
                      type:'POST',
                      dataType: "json",
                      data:{bookingDate:bookingDate,boatId:boatId},
                      success: function(response) {

                        console.log(response);
                        if (response.success) {

                           $("#hidden_availability_id").val(response.data[0].id);
                          
                           $('#booking_start_time').timepicker('remove'); 
                           $('#booking_start_time').timepicker({
                                 timeFormat: 'HH:mm',
                                 minTime: response.data[0].start_time, // Set the minimum time
                                 maxTime: response.data[response.data.length - 1].end_time, // Set the maximum time
                                 step: 30 // Set the step to 30 minutes (0.5 hour)
                           });  
                           $('#booking_end_time').timepicker('remove'); 
                           $('#booking_end_time').timepicker({
                                 timeFormat: 'HH:mm',
                                 minTime: response.data[0].start_time, // Set the minimum time
                                 maxTime: response.data[response.data.length - 1].end_time, // Set the maximum time
                                 step: 30 // Set the step to 30 minutes (0.5 hour)
                           });  

                        } 
                     } 
                  });
                 
            }
           
          });
      </script>   
   </body>
</html>
