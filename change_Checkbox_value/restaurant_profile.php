<?php include('includes/header.php')?>
<?php include('includes/sidebar.php')?>
<style>
    .ms-profile-cover {
     background-image: url(<?= base_url()?>assets/img/admin/banner-1000x370.jpg);
    }
    .ms-profile-information tr td {
    text-align: right;
    white-space: initial;
}
</style>

<?= $this->session->flashdata('error');?>
 <?= $this->session->flashdata('success');?>
 <div id="show_message"></div>
<!-- Body Content Wrapper -->
         <div class="ms-content-wrapper">
            <div class="ms-profile-overview">
               <div class="ms-profile-cover">
                  <img class="ms-profile-img" src="<?= base_url()?><?=$restaurant_data->image?>" alt="people">
                  <div class="ms-profile-user-info">
                     <h4 class="ms-profile-username text-white"><?=$restaurant_data->rest_name?></h4>
                     <h2 class="ms-profile-role"><i class="fa fa-map"></i> <?=$restaurant_data->branch_name?></h2>
                  </div>
                  <!--<div class="ms-profile-user-buttons">-->
                  <!--   <a href="#" class="btn btn-primary"> <i class="material-icons">person_add</i> Follow</a>-->
                  <!--   <a href="#" class="btn btn-light"> <i class="material-icons">file_download</i> Download Resume</a>-->
                  <!--</div>-->
               </div>
               <ul class="ms-profile-navigation nav nav-tabs tabs-bordered" role="tablist">
                  <li role="presentation"><a href="#tab1" aria-controls="tab1" class="active show" role="tab" data-toggle="tab"> Restaurant Profile  </a></li>
                  <li role="presentation"><a href="#tab2" aria-controls="tab2" role="tab" data-toggle="tab"> Stop Delivering   </a></li>
                  <!--<li role="presentation"><a href="#tab3" aria-controls="tab3" role="tab" data-toggle="tab"> Portfolio </a></li>-->
               </ul>
             </div>
             <div class="tab-content">
                  <div class="tab-pane active" id="tab1">
                        <div class="row">
                           <div class="col-xl-6 col-md-12">
                              <div class="ms-panel ms-panel-fh">
                                 <div class="ms-panel-body">
                                    <h2 class="section-title">Shop Details</h2>
                                    <table class="table ms-profile-information">
                                       <tbody>
                                          <tr>
                                             <th scope="row">Shop Name </th>
                                             <td><?=isset($restaurant_data->rest_name)?$restaurant_data->rest_name:'__'?></td>
                                          </tr>
                                          <tr>
                                             <th scope="row">Branch Name</th>
                                             <td><?=isset($restaurant_data->branch_name)?$restaurant_data->branch_name:'__'?></td>
                                          </tr>
                                          <tr>
                                             <th scope="row">Mobile Number</th>
                                             <td><?=isset($restaurant_data->mobile)?$restaurant_data->mobile:'__'?></td>
                                          </tr>
                                          <tr>
                                             <th scope="row">Email Address</th>
                                             <td><?=isset($restaurant_data->email)?$restaurant_data->email:'__'?></td>
                                          </tr>
                                          <tr>
                                             <th scope="row">Restaurants Start Time- Close Time</th>
                                             <td><?=$restaurant_data->open_time?> - <?=$restaurant_data->closing_time?></td>
                                          </tr>
                                         
                                          <tr>
                                             <th scope="row">Servicing area</th>
                                             <td><?=isset($restaurant_data->service_area)?$restaurant_data->service_area:'__'?></td>
                                          </tr>
                                          <tr>
                                             <th scope="row">Category</th>
                                             <td><?=isset($restaurant_data->cat_name)?$restaurant_data->cat_name:'__'?></td>
                                          </tr>
                                          <tr>
                                             <th scope="row">Sub Category</th>
                                             <td><?=isset($restaurant_data->subcat_name)?$restaurant_data->subcat_name:'__'?></td>
                                          </tr>
                                       </tbody>
                                    </table>
                                 </div>
                              </div>
                           </div>
                           <div class="col-xl-6 col-md-12">
                              <div class="ms-panel ms-panel-fh">
                                 <div class="ms-panel-body">
                                    <h2 class="section-title">Shop Address</h2>
                                    <table class="table ms-profile-information">
                                       <tbody>
                                          <tr>
                                             <th scope="row">Address</th>
                                             <td><?=isset($restaurant_data->address)?$restaurant_data->address:'__'?></td>
                                          </tr>
                                          <tr>
                                             <th scope="row">State</th>
                                             <td><?=isset($restaurant_data->state_name)?$restaurant_data->state_name:'__'?></td>
                                          </tr>
                                          <tr>
                                             <th scope="row">District </th>
                                             <td><?=isset($restaurant_data->district_name)?$restaurant_data->district_name:'__'?></td>
                                          </tr>
                                          <tr>
                                             <th scope="row">City</th>
                                             <td><?=isset($restaurant_data->city_name)?$restaurant_data->city_name:'__'?></td>
                                          </tr>
                                          <tr>
                                             <th scope="row">Pin code </th>
                                             <td><?=isset($restaurant_data->pincode)?$restaurant_data->pincode:'__'?></td>
                                          </tr>
                                          <!--<tr>-->
                                          <!--   <th scope="row">Email Address</th>-->
                                          <!--   <td>example@mail.com</td>-->
                                          <!--</tr>-->
                                          <!--<tr>-->
                                          <!--   <th scope="row">Location</th>-->
                                          <!--   <td>New York, USA</td>-->
                                          <!--</tr>-->
                                       </tbody>
                                    </table>
                                 </div>
                              </div>
                           </div>
                        </div>
                  </div>
                  <div class="tab-pane" id="tab2">
                       <div class="ms-panel ms-panel-fh">
                        <form  >
                                 <div class="ms-panel-body">
                                     <p>Stop delivery due to no dishes available or Restaurant not ready to deliver the food</p>
                                      <label class="ms-switch">
                                      <!-- <input type="checkbox" <?= ($restaurant_data->stop_delivery==1)?'checked':''?> name="status"  data-user_id="<?= $row['id']?>" data-on_status_change onchange="change_stop_delivery_status(this.value)" > -->
                                          <input type="checkbox" id="stop_delivery" name="status"  <?=($restaurant_data->stop_delivery)==1?'checked':""?> data-on_status_change >
                                          <span class="ms-switch-slider round"></span>
                                      </label>
                                 </div>
</form>
                       </div>
                       
                  </div>
                  <!--<div class="tab-pane" id="tab3">-->
                  <!--</div>-->
               </div>
           
         </div>
     <!-- JQUERY FUNCTIONALITY CDN -->
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
    integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script> 
 <!-- ALERT FUNCIONALITY CDN -->
 
              </script>
         <script>
             $(document).ready(function() { 
             $(document).on('change',`[data-on_status_change]`,function(e){
               e.preventDefault();
//function change_stop_delivery_status()
   //   {
      let obj = $(this);
      let check_status = obj.find("input[name='status']");
   let  chkId ='';
    if (obj.is(':checked')) {
        chkId = 1;
    }  else{
      chkId =0;
    }
    //alert(chkId);
      var stop_delivery=chkId;
      // alert(stop_delivery);
      $.ajax({
	            url: "<?php echo base_url('Restaurant/stop_delivery')?>",
	            method: "post", 
	            // dataType: 'json',
	           data: {stop_delivery:stop_delivery},
	            success: function(response)
              {
               if(response==1)
               {
                  $('#show_message').html('<div class="alert alert-success alert-dismissible" role="alert"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>Status change successfully!</div>').show(); 
               }else{
                  $('#show_message').html("<div class='alert alert-danger alert-dismissible' role='alert'><i class='fa fa-danger'></i><button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>Unable to chnage status</div>").show();
               }
              // alert(response);
	           }
         });
          });
         });
      </script>
<?php include('includes/footer.php')?>
