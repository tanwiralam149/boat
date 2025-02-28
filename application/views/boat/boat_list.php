

<div class="content">
                <div class="container">
                <a href="<?php echo base_url('add') ?>" class="btn btn-primary btn-sm" style="float:right;"> <i class="fas fa-plus"></i> Add Boat </a>
                    <div class="page-title">
                        <h3>Boat Lists</h3>
                   
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
                                                <th>Boat Name</th>
                                                <th>Type</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php if (!empty($all_boats)){ ?>
                                        <?php foreach($all_boats as $key=>$boat) {  ?>
                                            <tr >
                                                <td rowspan="<?php echo count($boat['availabilities']) ?: 1; ?>"><?php echo $key+1; ?></td>
                                                <td rowspan="<?php echo count($boat['availabilities']) ?: 1; ?>"><?php echo $boat['boat_name']; ?></td>
                                                <?php  foreach($boat['availabilities'] as $index =>$availabilitie){  ?>
                                                    <?php if ($index > 0) echo '<tr>'; ?>
                                                    <td><?php echo ucfirst($availabilitie['availability_type']); ?></td>
                                                    <td><?php echo date('h:i A',strtotime($availabilitie['start_time'])); ?></td>
                                                    <td><?php echo date('h:i A',strtotime($availabilitie['end_time'])); ?></td>
                                                   
                                                    <?php if ($index == 0){?> <!-- Only add actions once per boat -->
                                                        <td rowspan="<?php echo count($boat['availabilities']) ?: 1; ?>">
                                                          

                                                               <?php if ($boat['status'] == 1) { ?>
                                                                   <a data-boat-id="<?php echo $boat['boat_id']; ?>" data-current-status="<?php echo $boat['status']; ?>" class="toggle-status btn btn-danger btn-sm">Inactive</a>
                                                                <?php } elseif ($boat['status'] == 0) { ?>
                                                                    <a data-boat-id="<?php echo $boat['boat_id']; ?>" data-current-status="<?php echo $boat['status']; ?>" class="toggle-status btn btn-success btn-sm">Active</a>
                                                                <?php } ?>
                                                        </td>
                                    <td class="actions" rowspan="<?php echo count($boat['availabilities']) ?: 1; ?>">
                                        <a href="<?php echo site_url('edit/'.$boat['boat_id']); ?>" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
                                        <a href="<?php echo site_url('delete/'.$boat['boat_id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')"><i class="fas fa-trash"></i></a>     
                                    </td>
                                <?php } ?>
                               
                                                    </tr>
                                                <?php  } ?>

                                              
                                            </tr>
                                          <?php } ?>
                                          
                                          <?php }else{ ?>
                                            <tr><td colspan="6">No Boats Available</td></tr>
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
                   $(".toggle-status").on('click',function(){
                     if(confirm('Do you want to change status .?')){
                        var boatId=$(this).data('boat-id');
                        var status=$(this).data('current-status') == 0 ? 1 : 0;
                        $.ajax({
                                url :"<?php echo base_url('update-status'); ?>",
                                type:'POST',
                                data: {
                                    boat_id: boatId,
                                    status: status
                                }, 
                                success: function(response) {
                                    location.reload();
                            },
                            error: function() {
                                alert('An error occurred. Please try again.');
                            }

                            });
                     }
                   });
                });
            </script>

              <!-- Toastr Notifications Script -->
    <script type="text/javascript">
      <?php if ($this->session->flashdata('success')): ?>
        toastr.success("<?php echo $this->session->flashdata('success'); ?>");
      <?php elseif ($this->session->flashdata('error')): ?>
        toastr.error("<?php echo $this->session->flashdata('error'); ?>");
      <?php endif; ?>
    </script>