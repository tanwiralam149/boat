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
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
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
                           <!-- <div class="card-header">Boat Booking</div> -->
                           <div class="card-body">
                              <h5 class="card-title">Booking Detail</h5>
                              <form  id="checkAvailabilityForm" >
                                 <input type="hidden" name="hidden_availability_id" id="hidden_availability_id" />
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
                                       <label for="booking_date" class="form-label">Booking Date</label>
                                       <input type="text" id="booking_date" class="form-control" name="booking_date"  required>
                                    </div>
                                    <div class="mb-3 col-md-3">
                                       <label for="booking_start_time" class="form-label">Start Time</label>
                                       <select class="form-control" name="booking_start_time" id="booking_start_time"  required>
                                          <option value="">Select Time</option>
                                       </select>
                                    </div>
                                    <div class="mb-3 col-md-3">
                                       <label for="booking_end_time" class="form-label">End Time</label>
                                       <select class="form-control" name="booking_end_time" id="booking_end_time"  required>
                                          <option value="">Select Time</option>
                                       </select>
                                    </div>
                                    <!-- <div class="mb-3 col-md-3">
                                       <label for="booking_start_time" class="form-label">Start Time</label>
                                       <input type="text" class="form-control" name="booking_start_time" id="booking_start_time"  required>
                                       </div>
                                       <div class="mb-3 col-md-3">
                                       <label for="booking_end_time" class="form-label">End Time</label>
                                       <input type="text" class="form-control" name="booking_end_time" id="booking_end_time" required>
                                       </div> -->
                                 </div>
                                 <div id="availabilityMessage"></div>
                                 <!-- <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Search</button> -->
                                 <button type="button" class="btn btn-primary" id="checkBoatAvailability" style="float:right;"> <i class="fas fa-search"></i>Search </button>
                              </form>
                           </div>
                           <!-- <div class="card-header">Customer Detail</div> -->
                           <div class="card-body" id="customer_div" style="display:none;">
                              <h5 class="card-title">Customer Detail</h5>
                              <form  id="addCustomerBookingForm" >
                                 <div class="row g-2">
                                    <div class="mb-3 col-md-4">
                                       <label for="customer_name" class="form-label">Name</label>
                                       <input type="text" id="customer_name" class="form-control" name="customer_name" placeholder="Enter customer name"  required>
                                    </div>
                                    <div class="mb-3 col-md-4">
                                       <label for="customer_email" class="form-label">Email</label>
                                       <input type="text" class="form-control" name="customer_email" id="customer_email" placeholder="Enter customer email"  required>
                                    </div>
                                    <div class="mb-3 col-md-4">
                                       <label for="customer_phone" class="form-label">Phoneno </label>
                                       <input type="number" class="form-control" name="customer_phone" id="customer_phone" placeholder="Enter customer phone" required>
                                    </div>
                                 </div>
                                 <button type="button" class="btn btn-primary" id="addCustomerBooking" style="float:right;">  Submit </button>
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
      <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
      <script>
         $( function() {
           $( "#booking_date" ).datepicker({ dateFormat: 'yy-mm-dd' });
         } );
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
                 $('#booking_start_time').empty();
                 $('#booking_end_time').empty();
         
                 // Manually destroy the timepicker instances
               //   $('#booking_start_time').timepicker('destroy');
               //   $('#booking_end_time').timepicker('destroy');
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
                         
                           var start_time=response.data[0].start_time;
                           var end_time=response.data[0].end_time;
                           
                           getBoatBookingTime(start_time,end_time);
                           
         
                        //   $('#booking_start_time').timepicker({
                        //         timeFormat: 'H:mm p',
                        //         minTime: response.data[0].start_time, // Set the minimum time
                        //         maxTime: response.data[0].end_time, // Set the maximum time
                        //         step: 30 // Set the step to 30 minutes (0.5 hour)
                        //   });  
                         
                        //   $('#booking_end_time').timepicker({
                        //         timeFormat: 'H:mm p',
                        //         minTime: response.data[0].start_time, // Set the minimum time
                        //         maxTime: response.data[0].end_time, // Set the maximum time
                        //         step: 30 // Set the step to 30 minutes (0.5 hour)
                        //   });   
                       } 
                    } 
                 }); 
              }
         
               function getBoatBookingTime(start_time,end_time){
                  
                     // Convert start and end times to minutes (from midnight)
                     var start_minutes = parseInt(start_time.split(":")[0]) * 60 + parseInt(start_time.split(":")[1]);
                     var end_minutes = parseInt(end_time.split(":")[0]) * 60 + parseInt(end_time.split(":")[1]);
                     // Generate the times array dynamically
                     var times = [];
                     for (var time = start_minutes; time <= end_minutes; time += 30) {
                        var hours = Math.floor(time / 60);
                        var minutes = time % 60;
                        var timeString = String(hours).padStart(2, '0') + ":" + String(minutes).padStart(2, '0');
                        times.push(timeString);
                     }
         
                     // Append each time to the dropdown
                     times.forEach(function(time) {
                        $("#booking_start_time").append(new Option(time, time));
                        $("#booking_end_time").append(new Option(time, time));
                     });
               }
         
         });
      </script>  
      <script>
         $("#checkBoatAvailability").click(function() {
             var boat_id = $("#boat_id").val();
             var booking_date = $("#booking_date").val();
             var start_time = $("#booking_start_time").val();
             var end_time = $("#booking_end_time").val();
         
             if (boat_id && booking_date && start_time && end_time) {
                 $.ajax({
                     type: "POST",
                     url: "<?= base_url('booking/check_boat_availability'); ?>",
                     data: { boat_id: boat_id, booking_date: booking_date, start_time: start_time, end_time: end_time },
                     dataType: "json",
                     success: function(response) {
                         if (response.success) {
                              $("#customer_div").show();
                             $("#availabilityMessage").html("<span style='color: green;'>" + response.message + "</span>");
                         } else {
                           $("#customer_div").hide();
                             $("#availabilityMessage").html("<span style='color: red;'>" + response.message + "</span>");
                         }
                     }
                 });
             } else {
                 alert("Please fill all fields.");
             }
         });
      </script>
      <script>
         $("#addCustomerBooking").click(function(){
            // e.preventDefault();
            $("#availabilityMessage").html('');
         
             var boat_id = $("#boat_id").val();
             var booking_date = $("#booking_date").val();
             var start_time = $("#booking_start_time").val();
             var end_time = $("#booking_end_time").val();
         
             var name=$("#customer_name").val();
             var email=$("#customer_email").val();
             var phone=$("#customer_phone").val();
             var hidden_availability_id=$("#hidden_availability_id").val();
               // Validate required fields
            if (!name || !email || !phone) {
               alert("Please fill in all customer details.");
               return; // Stop execution if validation fails
            }
         
            if (!boat_id || !booking_date || !start_time || !end_time) {
               alert("Please ensure all booking details are selected.");
               return; // Stop execution if validation fails
            }
         
                 $.ajax({
                     type:"POST",
                     url:"<?php echo base_url('booking/create_boat_booking')?>",
                     data:{
                        name:name,
                        email:email,
                        phone:phone,
                        boat_id:boat_id,
                        booking_date:booking_date,
                        start_time:start_time,
                        end_time:end_time,
                        hidden_availability_id:hidden_availability_id
                     },
                     dataType: "json",
                     success:function(response){
         
                        console.log(response);
                        if (response.success) {
                              $("#customer_div").hide();
                             // $("#availabilityMessage").html("<span style='color: green;'>" + response.message + "</span>"); 
                             toastr.success(response.message);
                         } else {
                             $("#customer_div").show();
                             toastr.error(response.message);
                            // $("#availabilityMessage").html("<span style='color: red;'>" + response.message + "</span>");
                         }
                     }
                  });
          
         });
      </script>
   </body>
</html>