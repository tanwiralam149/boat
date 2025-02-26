<!-- jQuery Timepicker CSS -->
<div class="content">
   <div class="container">
      <a href="<?php echo base_url('list') ?>" class="btn btn-primary btn-sm" style="float:right;"> <i class="fas fa-list"></i>  Boat List</a>
      <div class="page-title">
         <h3>Boat / Update</h3>
      </div>
      <div class="row">
         <div class="col-lg-12">
            <div class="card">
               <div class="card-header">Boat Detail</div>
               <div class="card-body">
                  <!-- <h5 class="card-title">Example form with inline field validations</h5> -->
                  <form method="POST" action="<?php echo base_url("update") ?>" class="" >
                     <div class="row g-2">
                        <div class="mb-3 col-md-6">
                           <label for="boat_name" class="form-label">Boat Name</label>
                           <input type="text" class="form-control" value="<?php echo $boat['boat_name']; ?>" name="boat_name" placeholder="Enter Boat Name" required>
                           <input type="hidden" class="form-control" value="<?php echo $boat['id']; ?>" name="boat_id"  >
                        </div>
                     </div>
                     <div class="row g-2">
                        <div class="mb-3 col-md-6">
                           <div class="card-header">Boat Availability</div>
                        </div>
                        <div class="mb-3 col-md-6">
                           <div class="mb-3 col-md-3">
                              <label for="end_time" class="form-label"></label>
                              <button type="button" class="btn btn-success btn-sm" id="add-availability" style="margin-top:20px;"><i class="fas fa-plus"></i> </button><br><br>
                           </div>
                        </div>
                     </div>
                     <?php $counter = 1; ?>
                     <?php 
                     if($boat['availabilities']){
                       foreach($boat['availabilities'] as $availability){ ?>
                     <div class="row g-2" id="add_<?php echo $counter; ?>">
                        <div class="mb-3 col-md-3">
                           <label for="availability_type" class="form-label">Select Availability</label>
                           <select name="availability_type_<?php echo $counter; ?>" class="form-select" required>
                              <option value="" >Select Availability</option>
                              <option value="weekend" <?php echo $availability['availability_type']=='weekend' ? 'selected' :'' ?>>Weekend</option>
                              <option value="weekdays" <?php echo $availability['availability_type']=='weekdays' ? 'selected' :'' ?>>Weekdays</option>
                           </select>
                        </div>
                        <div class="mb-3 col-md-3">
                           <label for="start_time" class="form-label">Start Time</label>
                           <input type="text" class="form-control start_time" name="start_time_<?php echo $counter; ?>" 
                              id="start_time" value="<?php echo $availability['start_time']?>" placeholder="Start Time" required>
                        </div>
                        <div class="mb-3 col-md-3">
                           <label for="end_time" class="form-label">End Time</label>
                           <input type="text" class="form-control end_time" value="<?php echo $availability['end_time']?>" id="end_time" name="end_time_<?php echo $counter; ?>" placeholder="End Time" required>
                        </div>
                        <div class="mb-3 col-md-3">
                           <label for="end_time" class="form-label"></label>
                           <button type="button" class="btn btn-danger btn-sm remove-availability" data-id="<?php echo $counter; ?>"  style="margin-top:30px;"><i class="fas fa-trash"></i> </button>
                        </div>
                     </div>
                     <?php $counter++; ?>
                     <?php } } ?>
                     <div class="row g-2" id="append_div"></div>
                     <input type="hidden" id="counter" name="counter" value="<?php echo $counter-1; ?>" />
                     <!-- <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update</button> -->
                     <div class="row g-2" style="margin-top:30px;">
                        <div class="mb-3 col-md-9"></div>
                        <div class="mb-3 col-md-2">
                        <button type="submit" class="btn btn-primary"> Update</button>
                        </div>
                        
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- jQuery Timepicker JS -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script> -->
<script>
   $(document).ready(function() {
     $('.start_time').timepicker({
         timeFormat: 'H:mm p',
         interval: 30,
         minTime: '6:00am',
         maxTime: '11:30pm',
         defaultTime: '',
         startTime: '6:00am',
         dynamic: false,
         dropdown: true,
         scrollbar: true
     });
   
     $('.end_time').timepicker({
         timeFormat: 'H:mm p',
         interval: 30,
         minTime: '6:00am',
         maxTime: '11:30pm',
         defaultTime: '',
         startTime: '6:00am',
         dynamic: false,
         dropdown: true,
         scrollbar: true
     });
   });
</script>
<script>
   $(document).ready(function(){
   // var counter="<?php echo $counter-1; ?>";
   let counter = <?php echo count($boat['availabilities']) ; ?>;
     $("#add-availability").click(function(){
        counter++;
        let newAvailability=
        `            <div class="row" id="add_${counter}">
                     <div class="mb-3 col-md-3">
                           <label for="availability_type" class="form-label">Select Availability</label>
                           <select name="availability_type_${counter}" class="form-select" required>
                              <option value="" >Select Availability</option>
                              <option value="weekend">Weekend</option>
                              <option value="weekdays">Weekdays</option>
                           </select>
                        </div>
                        <div class="mb-3 col-md-3">
                           <label for="start_time" class="form-label">Start Time</label>
                           <input type="text" class="form-control start_time" name="start_time_${counter}" 
                              id="start_time_${counter}" placeholder="Start Time" required>
                        </div>
                        <div class="mb-3 col-md-3">
                           <label for="end_time" class="form-label">End Time</label>
                           <input type="text" class="form-control end_time" id="end_time_${counter}" name="end_time_${counter}" placeholder="End Time" required>
                        </div>
                        <div class="mb-3 col-md-3">
                        <label for="end_time" class="form-label"></label>
                        
                        <button type="button" class="btn btn-danger remove-availability btn-sm" data-id="${counter}"  style="margin-top:30px;"><i class="fas fa-trash"></i> </button>
                        </div>
                         </div>
        `;
        $('#append_div').append(newAvailability);
        $("#counter").val(counter);
             
            $('#start_time_'+counter).timepicker({
                timeFormat: 'H:mm p',
                interval: 30,
                minTime: '6:00am',
                maxTime: '11:30pm',
                defaultTime: '12:00pm',
                startTime: '6:00am',
                dynamic: false,
                dropdown: true,
                scrollbar: true
            });
        
            $('#end_time_'+counter).timepicker({
                timeFormat: 'H:mm p',
                interval: 30,
                minTime: '6:00am',
                maxTime: '11:30pm',
                defaultTime: '12:00pm',
                startTime: '6:00am',
                dynamic: false,
                dropdown: true,
                scrollbar: true
            });
       
     });
   
   
   
   
        // $(document).on('click', '.remove-availability', function() {
        //     $(this).parent().remove();
        // });
   
           $(document).on('click', '.remove-availability', function() {
                let id = $(this).data('id');
               
                $('#add_' + id).remove();
                $("#counter").val(--counter);
            });
   });
   
</script>