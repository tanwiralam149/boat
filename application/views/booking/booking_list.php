<div class="content">
                <div class="container">
                    <div class="page-title">
                        <h3>Booking List</h3>
                    </div>
                    <div class="row">
                       
                        <div class="col-md-12 col-lg-12">
                            <div class="card">
                                <!-- <div class="card-header">Basic DataTables Table</div> -->
                                <div class="card-body">
                                    <p class="card-title"></p>
                                    <table class="table table-hover" id="dataTables-example" width="100%">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Contact</th>
                                                <th>Boat</th>
                                                <th>Booking Date</th>
                                                <th>Booking Time</th>
                                                <th>Booking Hours</th>
                                                <!-- <th>Status</th> -->
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        <?php if(!empty($bookings)){ 
                                             foreach($bookings as $key=>$booking){  
                                                
                                                // Convert times to timestamps
                                                $start = strtotime($booking['booking_start_time']);
                                                $end = strtotime($booking['booking_end_time']);
                                                // Calculate the difference in seconds
                                                $difference = $end - $start;
                                                // Convert seconds to hours and minutes
                                                $hours = floor($difference / 3600); // Total hours
                                                $minutes = floor(($difference % 3600) / 60); // Remaining minutes
                                                $hours_minutes='';
                                                if( ($hours > 0) && ($minutes > 0)){
                                                     $hours_minutes="$hours hours and $minutes minutes";
                                                }elseif($hours > 0){
                                                    $hours_minutes="$hours hours ";
                                                }
                                               
                                        ?>
                                            <tr>
                                                <td><?php echo $key+1; ?></td>
                                                <td><?php echo $booking['customer_name'] ?></td>
                                                <td><?php echo $booking['customer_email'] ?> <br/> <?php echo $booking['customer_phone'] ?></td>
                                                <td><?php echo $booking['boat_name'] ?></td>
                                                <td><?php echo date('d-m-Y',strtotime($booking['booking_date'])); ?></td>
                                                <td><?php echo date('h:i A',strtotime($booking['booking_start_time'])); ?> - <?php echo date('h:i A',strtotime($booking['booking_end_time'])); ?> </td>
                                                <td><strong><?php  echo $hours_minutes; ?></strong></td>
                                                <!-- <td></td> -->
                                                <td><a data-id="<?php echo $booking['booking_id']; ?>" class="btn btn-danger btn-sm deleteBooking">Delete</a></td>
                                            </tr>
                                        <?php }}else{ ?>
                                            <tr>
                                                <td colspan="7">No Records found</td>
                                              
                                            </tr>
                                        <?php } ?>    
                                          
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                     
                    </div>
                </div>
            </div>


            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
            <script>
                $(document).ready(function(){
                    $(".deleteBooking").on('click',function(){
                        if(confirm('Do you want to delete booking..?')){
                            var bookingId=$(this).data('id');
                            
                            $.ajax({
                                 url:'<?php echo base_url('booking/delete'); ?>',
                                 type:'POST',
                                 data:{bookingId:bookingId},
                                 dataType: 'json',
                                 success: function(response) {
                                    toastr.success(response.message)
                                    //console.log(response);
                                    setTimeout(()=>{
                                        location.reload();
                                    }, 2000);
                                   
                                },
                                error: function() {
                                    toastr.error(response.message);
                                    //alert('An error occurred. Please try again.');
                                }
                            })
                        }
                    });
                });
            </script>

<script type="text/javascript">
      <?php if ($this->session->flashdata('success')): ?>
        toastr.success("<?php echo $this->session->flashdata('success'); ?>");
      <?php elseif ($this->session->flashdata('error')): ?>
        toastr.error("<?php echo $this->session->flashdata('error'); ?>");
      <?php endif; ?>
    </script>