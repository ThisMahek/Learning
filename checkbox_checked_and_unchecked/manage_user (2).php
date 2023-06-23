<?php include('includes/header.php')?>
<?php include('includes/sidebar.php')?>


 <div class="card shadow">
     <div class="card-header">
      <?= $this->session->flashdata('error')?>
      <?= $this->session->flashdata('success')?>
      <div id="show_message"></div>
       <!--<div id="show_message2"></div>-->
     <div class="row">
             <div class="col-md-8 col-8">
                 <h4 class="mb-sm-0 font-size-18">Manage Users</h4>
             </div>
             <div class="col-md-4 col-4">
                 <button class="btn btn-primary float-right"  data-bs-toggle="modal" data-bs-target="#add"     data-add_user    onclick= "show_pincode_field()">+ Add
                 </button>
             </div>
     </div>
     </div>
            <div class="card-body">
                <!--filter-->
        <div class="data-filters">
            <!--<h6>Filters</h6>-->
            <div class="row">
                
                    <div class="col-md-2">
                         <div class="mb-3">
                             <label class="mb-2">Type</label>
                            <select class="form-control" name="type"   data-users_filter   required id="select_user_type">
                                <option value="">select user type</option>
                               <option  value = "1">Team</option>
                              <option value= "0">Individual player</option>
                            </select>
                         </div>
                     </div> 
                
                
                
                <div class="col-md-2">
                    <div class="mb-3">
                        <label class="mb-2">Game Category</label>
                        <select class="form-control" name="sports" data-users_filter required>
                            <option value="">all games</option>
                            <?php if(!empty($manage_game)):?>
                            <?php foreach($manage_game as $row):?>
                            <option value="<?= $row['id']?>" data-sportid="<?=$row['id'] ?>"><?= $row['title']?>
                            </option>
                            <?php endforeach;?>
                            <?php endif;?>
                        </select>
                    </div>
                </div>
             
                <div class="col-md-2">
                    <div class="mb-3">
                        <label class="mb-2">State</label>
                        <select class="form-control" data-users_filter name="state" id="state_filter" required>
                            <option value="">select state</option>
                            <?php  if(!empty($manage_state)):?>
                            <?php foreach($manage_state as $row):?>
                            <option value="<?= $row['id']?>"><?= $row['name']?></option>
                            <?php endforeach;?>
                            <?php endif;?>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="mb-3">
                        <label class="mb-2">City</label>
                        <select class="form-control" data-users_filter name="city" id="city_filter" required>
                            <option value="">select city</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="mb-2">Status</label>
                        <select data-users_filter class="form-control" name="now_playing" required>
                            <option value="">All</option>
                            <option value="1">Open To Play</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <!--filter-->
                  <button class="btn btn-primary" onclick="show_and_hide_mobile_no('0')" >Show</button>
        <button class="btn btn-primary" onclick="show_and_hide_mobile_no('1')" >Hide</button> 
     <table  data-result_list_table  class="table table-bordered table-responsive  nowrap w-100 desktop_responsive" >
                                            <thead>
                                            <tr>
                                                <th class="text-center"><input onclick="select_all(this);" type="checkbox" data-all_select>Show/Hide</th>
                                                <th>Sr.No.</th>
                                                <th>Type</th>
                                                <th>Name</th>
                                                <th>Mobile No</th>
                                                <th>Password</th>
                                                <th>Email</th>
                                                <th>Game Category</th>
                                                 <th>State</th>
                                                 <th>City</th>
                                                 <th>Pincode</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                     <tbody id="select_users">
                     </tbody>
          </table>
     </div>
 </div>
 <!--add modal-->
   <div class="modal fade" id="add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                      <div class="modal-header">
                          
                        <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <form   action="<?= base_url('Users/add_users')?>" method="post" enctype="multipart/form-data"  form_payment>
                          <div class="modal-body">
                                    <div class="mb-3">
                                       <label class="mb-2">Name</label>
                                       <input type="text" name="name" class="form-control" required  oninput="FullnameValidation(this.value,'name_span','submit')"   >
                                       <span id="name_span"></span>
                                    </div>
                                    
                                      <div class="mb-3">
                                       <label class="mb-2">Username</label>
                                       <input type="text" name="username" class="form-control" required  oninput="UsernameValidation(this.value,'username_span','submit')"   >
                                       <span id="username_span"></span>
                                    </div>
                                   
                                    <div class="mb-3">
                                       <label class="mb-2">Type</label>
                                       <!-- <input type="text" name="name" class="form-control" required> -->
                                       <select   name="type" class="form-control"  data-user_select_type  id="select_type"  required>
                                        <option>Select option</option>
                                       <option  value = "1">Team</option>
                                       <option value= "0">Individual player</option>
                                       </select>
                                    </div>
                                   
                                    <div class="mb-3">
                                       <label class="mb-2">Experience</label>
                                       <input type="text" name="experience" class="form-control"  required>
                                       <span id="experience_span"></span>
                                    </div>
                                    
                                    <div class="mb-3">
                                      <label class="mb-2">Image</label>
                                        <input type="file"  class="hidden-field" name="image" id="slider0" onchange="preview(this,0)" >
                                         <img src="" alt="" id="image0" >
                                        <label class="w-100" for="slider0"><span class="dashed-border"><i class="bx bx-image-add"></i> Image</span></label>
                                    </div>
                                    
                                  <span id="image_span" style="color:red"></span>
                                   <div class="mb-3">
                                       <label class="mb-2">Email(Optional)</label>
                                       <input type="email" class="form-control" name="email"    oninput="validatemail(this.value)"  id="email" >
                                       <span id="emaierror" style="color:red"></span>
                                       <div id= "alert_message_email"></div> 
                                   </div>
                                   
                                      <div class="mb-3">
                                       <label class="mb-2">Password</label>
                                       <input type="password" name="password" class="form-control" required>
                                       </div>
                                   
                                   <div class="mb-3">
                                       <label class="mb-2">Mobile No</label>
                                       <input type="text" class="form-control" name="phone" maxlength="10" oninput="phonenumberValidation(this.value,'pnumber','submit')"  id="phone"   onkeypress="return isNumber(event)" required>
                                       <span id="pnumber" style="color:red"></span>
                                   </div>
                                  <!--<div class="mb-3">
                                       <label class="mb-2">Password</label>
                                       <input type="password" class="form-control" value="" name="password"> 
                                   </div> -->
                                <!--    <div class="mb-3">
                                       <label class="mb-2">Address</label>
                                       <textarea class="form-control"  name="address"></textarea>
                                   </div> -->
                                   
                                   
                      <div class="col-md-12   data-filters" >
                     <div class="mb-3">
                         <label class="mb-2">Game category</label>
                        <select class="form-control"  name="game_category"id="game_category	" required>
                        <option value="">select game</option>
                            <?php  if(!empty($manage_game)):?>
                            <?php foreach($manage_game as $game_row):?>
                            <option value="<?= $game_row['id']?>"><?= $game_row['title']?></option>
                            <?php endforeach;?>
                            <?php endif;?>
                            </select> 
                     </div>
                </div>
                                   
                                   
                    <div class="col-md-12   data-filters" >
                     <div class="mb-3">
                         <label class="mb-2">State</label>
                        <select class="form-control" data-filter name="state" id="state" required>
                        <option value="">select state</option>
                            <?php  if(!empty($manage_state)):?>
                            <?php foreach($manage_state as $row):?>
                            <option value="<?= $row['id']?>"><?= $row['name']?></option>
                            <?php endforeach;?>
                            <?php endif;?>
                            </select> 
                     </div>
                </div>
                
            
                <div class="col-md-12">
                     <!-- <input type="text" class="form-control" name="city" value="" required>  -->
                     <div class="mb-3">
                     <label class="mb-2">District</label>
                     <select class="form-control" data-filter name="district" id="district" required>
                     <option value="">select district</option>
                     </select>
                    </div>
                </div>
                
                
                <div class="col-md-12">
                     <!-- <input type="text" class="form-control" name="city" value="" required>  -->
                     <div class="mb-3">
                     <label class="mb-2">City</label>
                     <select class="form-control" data-filter name="city" id="city" required>
                     <option value="">select city</option>
                     </select>
                    </div>
                </div>
             
                <!--   <div class="col-md-12"   id="pincode_div" >-->
                     <!-- <input type="text" class="form-control" name="city" value="" required>  -->
                <!--     <div class="mb-3">-->
                <!--     <label class="mb-2">Pincode</label>-->
                <!--     <select class="form-control" data-filter name="pincode" id="pincode" >-->
                <!--     <option value="">select pincode</option>-->
                <!--     </select>-->
                <!--    </div>-->
                <!--</div>-->
                
                <div class="mb-3"    id="pincode_div">
                   <label class="mb-2">Pincode</label>
                   <input type="text" class="form-control" name="pincode" data-pincode  onkeypress="return isNumber(event)" maxlength="6"   id="pincode"  >
                   <span id="pincode_span" style="color:red"></span>
                </div>
    
                 <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                    <input type="checkbox" class="form-check-input" id="active"  name="status" <?= ('checked')?'1':'0'?> checked>
                     <label class="form-check-label" for="active"></label>
                  </div>
                 </div>
                 
                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="submit" class="btn btn-primary" id="submit">Submit</button>
                  </div>
                  
                      </form>
                    </div>
                  </div>
                </div>

<!--</div>-->
<!--</div>-->













 <!--add modal-->
   <div class="modal fade" id="update" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Update User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <form action="<?= base_url('users/update_users')?>"  method="post" enctype="multipart/form-data">
                          <div class="modal-body">
                                   <div class="mb-3">
                                       <label class="mb-2">Name</label>
                                       <input type="text" name="name" class="form-control" value ="" >
                                   </div>
                                   
                                      <div class="mb-3">
                                       <label class="mb-2">Username</label>
                                       <input type="text" name="username" class="form-control" value ="" >
                                   </div>
                                   
                                   <div class="mb-3">
                                       <label class="mb-2">Type</label>
                                       <select   name="type" class="form-control" id="type_update"  data-user_select_type_update required>
                                        <!--<option>Select option</option>-->
                                       <!--<option  value = "1" >Team</option>-->
                                       <!--<option value= "0" >Individual player</option>-->
                                       </select>
                                   </div>
                                   
                                   
                                     <div class="mb-3">
                                       <label class="mb-2">Experience</label>
                                       <input type="text" name="experience" class="form-control" value ="" >
                                   </div> 
                                   
                                   
                                   
                                   <input type="hidden" name="id" value=""> 
                                    <div class="mb-3">
                                      <label class="mb-2">Image</label>
                                        <input type="file"   name="image" id="slider0" onchange="preview(this,1)">
                                        <!-- <input type="file"  class="hidden-field" name="image" id="slider0" onchange="preview(this,0)" required> -->
                                         <img src="" alt="" id="image0" height = "100px" name="show_image" >
                                       <label class="w-100" for="slider0"><span class="dashed-border"><i class="bx bx-image-add"></i> Image</span></label>
                                  </div>
                                  
                                   <div class="mb-3">
                                       <label class="mb-2">Email</label>
                                       <input type="email"  class="form-control"  name="email" value="" readonly>
                                   </div>
                                   
                                     <div class="mb-3">
                                       <label class="mb-2">Password</label>
                                       <input type="password" class="form-control"  name="password" value=""  readonly>
                                     </div>
                                   
                                   <div class="mb-3">
                                       <label class="mb-2">Mobile No</label>
                                       <input type="type"  name="mobile" class="form-control" value=""readonly>
                                   </div>
                              
                                               
                                   <div class="col-md-12   data-filters" >
                                 <div class="mb-3">
                                     <label class="mb-2">Game category</label>
                                    <select class="form-control"  name="game_category"id="game_cat" required>
                                    <!--<option value="">select game</option>-->
                                        </select> 
                                 </div>
                            </div>
                                 
                                   
                   <div class="col-md-12" >
                     <div class="mb-3">
                         <label class="mb-2">State</label>
                        <select class="form-control" data-filter_update name="state" id="state_update" required>
                        <!--<option value="">select state</option>-->
                           
                            </select> 
                     </div>
                </div>
                
            
                <div class="col-md-12">
                     <div class="mb-3">
                     <label class="mb-2">District</label>
                     <select class="form-control" data-filter_update name="district" id="district_update" required>
                     <!--<option value="">select district</option>-->
                     </select>
                    </div>
                </div>
                
                
                <div class="col-md-12">
                     <div class="mb-3">
                     <label class="mb-2">City</label>
                     <select class="form-control" data-filter_update name="city" id="city_update" required>
                     <!--<option value="">select city</option>-->
                     </select>
                    </div>
                </div>
             
                <!--<div class="col-md-12"   id="pincode_div" >-->
                <!--     <div class="mb-3">-->
                <!--     <label class="mb-2">Pincode</label>-->
                <!--     <select class="form-control" data-filter_update name="pincode" id="pincode_update" >-->
                <!--     <option value="">select pincode</option>-->
                <!--     </select>-->
                <!--    </div>-->
                <!--</div>-->
                
                
                    <div class="mb-3"  data-pincode_div_update>
                       <label class="mb-2">Pincode</label>
                       <input type="text" name="pincode"  onkeypress="return isNumber(event)" maxlength="6"  id="pincode" class="form-control" value ="" >
                    </div>
                
                 <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                    <input type="checkbox" class="form-check-input" id="active"   name="status">
                     <label class="form-check-label" for="active"></label>
                  </div>
                  
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            <button  class="btn btn-primary" type="submit"  name="update">Submit</button>
                          </div>
                      </form>
                    </div>
                  </div>
 </div>
 <!--add modal-->


<?php include('includes/footer.php')?>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
    integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
<script>
function validatemail() {
    var email = document.getElementById("email").value;
    // var phone = ("#phone").val();
    // alert(phone);
    var reg = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
    if (email != '') {
        // console.log(typeof email,reg.test(email))
        if (reg.test(email)) {
            document.getElementById("emaierror").innerHTML = "";
            document.getElementById("submit").disabled = false;
            
            
            $.ajax({
                type: "post",
                url: "<?= base_url()?>Users/check_email",
                data: {
                    email: email,
                },
                dataType: "dataType",
                complete: function (response) {
                    // console.log(JSON.parse(response.responseText))
                let success=JSON.parse(response.responseText).success;
                    if (success) {
                        $("#emaierror").html("<span style='color:red'></span>");
                    }
                    else {
                             let res=JSON.parse(response.responseText);
                              $("#emaierror").html("<span style='color:red'>"+res.emessage+"</span>"); 
                              document.getElementById("submit").disabled = true;
                              return false;
                         }
                }
            });
            
        }
        else {
            document.getElementById("emaierror").innerHTML = "Please Enter valid email";
            document.getElementById("submit").disabled = true;
        }
    }else{
        document.getElementById("emaierror").innerHTML = "";
            document.getElementById("submit").disabled = false; 
    }
}


   </script>
   
   



               <script>
            function phonenumberValidation(vals,msg,btn)
            {
            let reg = /^[56789]{1}[0-9]{9}$/;
              if(vals == '')
                 {
                     $("#"+msg).html("");
                     $("#"+btn).attr('disabled',false);
                 }
               else  if(!reg.test(vals))
                 {
                     $("#"+msg).html("<span style='color:red'>Please enter valid mobile number.</span>");
                     $("#"+btn).attr('disabled',true);  
                    return;
                 }
                 else{
                 $("#"+msg).html("");
                 $("#"+btn).attr('disabled',false); 
                 $.ajax({
                type: "post",
                url: "<?= base_url()?>Users/check_phone",
                data: {
                    phone : vals,
                },
                dataType: "dataType",
                complete: function (response) {
                    // console.log(JSON.parse(response.responseText))
                let success=JSON.parse(response.responseText).success;
                    
                    if (success) {
                        // alert(JSON.parse(response.responseText).message);
                        //   location.reload();
                        // // window.location.href="<?=base_url()?>User_Controller/login";
                        // $("#form_payment .total_balance").text(JSON.parse(response.responseText).wallet_balance);
                        // $("#form_payment .withdraw_amount").val('');
                        // document.getElementById("form_payment").reset(); 
                        $("#pnumber").html("<span style='color:red'></span>");
                    }
                    else {
                        
                       let res=JSON.parse(response.responseText);
                          $("#pnumber").html("<span style='color:red'>"+res.emessage+"</span>"); 
                          document.getElementById("submit").disabled = true;
                          return false;
                    }
                }
            });
                 }
 }
              </script>


            <script>
                function FullnameValidation(vals,msg,btn)
            {
            let reg = /^[a-zA-Z\s]*$/;
            if(!reg.test(vals))
            {
                $("#"+msg).html("<span style='color:red'>Please Enter valid  Name</span>");
                     $("#"+btn).attr('disabled',true);  
                 }
                 else
                 {
                     $("#"+msg).html("");
                     $("#"+btn).attr('disabled',false);
                 }
 }
            </script>
            
            
            
            
            
                       <script>
                function UsernameValidation(vals,msg,btn)
                    {
                    
                    // /^[a-zA-Z0-9](_(?!(\.|_))|\.(?!(_|\.))|[a-zA-Z0-9]){6,18}[a-zA-Z0-9]$/;
                    
                    let reg =/^(?:[a-zA-Z0-9%^&@#$^*:'.\-_]+)$/;
                    
                    if(vals == ''){
                          $("#"+msg).html("");
                         $("#"+btn).attr('disabled',false);
                    }
                    else if(!reg.test(vals))
                {
                $("#"+msg).html("<span style='color:red'>Username must be minimum 8 character or maximum 18 character </span>");
                     $("#"+btn).attr('disabled',true);  
                 }
                 else
                 {
                     $("#"+msg).html("");
                     $("#"+btn).attr('disabled',false);
                 }
                }
            </script>

<script>
    // var remaining2=0;
    // $("#email").onchange(function (e) {  
    //   function  register(){
    //     e.preventDefault();
    //     if(remaining2<=0){
    //         $.ajax({
    //             type: "post",
    //             url: "<?= base_url()?>Users/sign_up",
    //             data: {
    //                 email : $("#email").val(),
    //                   },
    //                  dataType: "dataType",
    //                   complete: function (response) {
    //                 console.log(JSON.parse(response.responseText))
    //                 let success=JSON.parse(response.responseText).success;
    //                 if(success)
    //                         {
    //                     let email=JSON.parse(response.responseText).email;
    //                          $("#email").attr('disabled',true); 
    //                          $("#alert_message_email").empty();
    //                          }
    //                          else{
    //                          let res=JSON.parse(response.responseText);
    //                          if(res.emessage!=undefined){
    //                       $("#alert_message_email").html("<span style='color:red'>"+res.emessage+"</span>"); 
    //                       return;
    //                       }
    //                       $('#alert_message_email').fadeIn(300,(e)=>{
    //                       $(e).delay(3000).queue(
    //                       $('#alert_message_email').fadeOut(3000)
    //                         )
    //                       });
    //                              }
    //                           }

    //                       });
      
    //                       }
                        
    //   }
           
</script>




       <script>
$(document).ready(function() {
    $("[data-add_user]").on('click',functon(){
             $("#pincode_div").hide();
             
            //  alert('xxx');
             $("[data-pincode]").removeAttr('required');
            //  return true;
    });
});
       </script>


       <script>
        $(document).ready(function() {
            $("[data-user_select_type]").on('change',function(){
                // let filter_attr =this.getAttribute("name");
                 var typeID = $(this).val();
                 if(typeID == 1)
                 {
                     $("#pincode_div").show();
                     $("[data-pincode]").prop('required',true);
                    //  $("#pincode_span").html("Please fill this field");
                 }else{
                     $("#pincode_div").hide();
                     $("[data-pincode]").prop('required',false);
                     $("#pincode_div").val('');
                 }
                    
            });
        });
       </script>
       
       
       
       
          <script>
        $(document).ready(function() {
         
            $("[data-user_select_type_update]").on('change',function(){
                // let filter_attr =this.getAttribute("name");
        
                 var typeID = $(this).val();
                 if(typeID == 1)
                 {
                     $('[data-pincode_div_update]').show();
                      $("[data-user_select_type]").setAttr("required");
                 }else{
                     $("[data-pincode_div_update]").hide();
                     
                      $(`#update [name='pincode']`).val(''); 
                 }
                    
            });
        });
       </script>
       <script>
          function show_pincode_field()
          {
                $("#pincode_div").hide();
                 $("#pincode").val('');
                    $("[data-pincode]").prop('required',false);
                 
                //  return true;
          }
       </script>





 <script>
$(document).ready(function() {
    
    $("[data-filter]").on('change', (function() {
        let filter_attr =this.getAttribute("name");
       
        if(filter_attr=='state'){
            $('#district').empty()
            $('#city').empty()
            $('#pincode').empty()
        }
        if(filter_attr=='district'){
            $('#city').empty()
            $('#pincode').empty()
        }
        if(filter_attr=='city'){
            $('#pincode').empty()
        }
        
        let getInput = [];
        $.map($(`select[data-filter]`), (v, i) => {
            getInput.push(`${$(v).attr('name')}=${$(v).find(':selected').val()}`);
        })
        getInput = getInput.join('&');
        var stateID = $(this).val();
        if (stateID) {
            $.ajax({
                type: "POST",
                url: "<?= base_url()?>Users/fetch_state_city_district_pincode?" + getInput,
                data: "",
                success: function(html) {
                    // $(`[data-filter] [name="city"]`).empty();
                   console.log(filter_attr)
                    let res = JSON.parse(html);
                    if(filter_attr == 'state')
                    {
                        $(`#district`).empty();
                        $.map(res.district_list, function(v, i) {
                            $(`#district`).append(`
                                  ${v}
                            `);
                        });
                        
                         $.map(res.city_list, function(v, i) {
                            $(`#city`).append(`
                                  ${v}
                            `);
                        });
                        
                        $.map(res.pincode_list, function(v, i) {
                            $(`#pincode`).append(`
                                  ${v}
                            `);
                        });
                    }
                  else if((filter_attr == 'district'))
                    {
                          $(`#city`).empty();
                        $.map(res.city_list, function(v, i) {
                            $(`#city`).append(`
                                  ${v}
                            `);
                        });
                        
                          $.map(res.pincode_list, function(v, i) {
                        $(`#pincode`).append(`
                              ${v}
                        `);
                    });
                        
                    }
     else if((filter_attr == 'city'))
                    {
                              $(`#pincode`).empty();
                           $.map(res.pincode_list, function(v, i) {
                            $(`#pincode`).append(`
                                  ${v}
                            `);
                        });
                    }
                    
                }
            });

        } else {
            $('#city').html('<option value="">select state first</option>');
        }

    }))
});
</script>












 <script>
// $(document).ready(function() {

    
//     $("[data-filter_update]").on('change', (function() {
//         let filter_attr =this.getAttribute("name");
//         let mymodel=$(this).closest(`.model`);
//         console.log(mymodel);
//         if(filter_attr=='state'){
//             $(mymodel).find('#district_update').empty()
//             $(mymodel).find('#city_update').empty()
//             $(mymodel).find('#pincode_pincode').empty()
//         }
//         if(filter_attr=='district'){
//             $(mymodel).find('#city_update').empty()
//             $(mymodel).find('#pincode_update').empty()
//         }
//         if(filter_attr=='city'){
//             $(mymodel).find('#pincode_update').empty()
//         }
        
//         let getInput = [];
//         console.log($(mymodel).find(`select[data-filter_update]`))
//         $.map($(mymodel).find(`select[data-filter_update]`), (v, i) => {
//             getInput.push(`${$(v).attr('name')}=${$(v).find(':selected').val()}`);
//         })
//         getInput = getInput.join('&');
//         var stateID = $(this).val();
//         if (stateID) {
//             $.ajax({
//                 type: "POST",
//                 url: "<?= base_url()?>Users/fetch_state_city_district_pincode?" + getInput,
//                 data: "",
//                 success: function(html) {
//                     // $(`[data-filter] [name="city"]`).empty();
//                   console.log(filter_attr)
//                     let res = JSON.parse(html);
//                     if(filter_attr == 'state')
//                     {
//                         $(mymodel).find(`#district`).empty();
//                         $.map(res.district_list, function(v, i) {
//                             $(mymodel).find(`#district_update`).append(`
//                                   ${v}
//                             `);
//                         });
                        
//                          $.map(res.city_list, function(v, i) {
//                             $(mymodel).find(`#city_update`).append(`
//                                   ${v}
//                             `);
//                         });
                        
//                         $.map(res.pincode_list, function(v, i) {
//                             $(mymodel).find(`#pincode_update`).append(`
//                                   ${v}
//                             `);
//                         });
//                     }
//                   else if((filter_attr == 'district'))
//                     {
//                           $(`#city`).empty();
//                         $.map(res.city_list, function(v, i) {
//                             $(mymodel).find(`#city_update`).append(`
//                                   ${v}
//                             `);
//                         });
                        
//                           $.map(res.pincode_list, function(v, i) {
//                         $(mymodel).find(`#pincode_update`).append(`
//                               ${v}
//                         `);
//                     });
                        
//                     }
                    
//                  else if((filter_attr == 'city'))
//                     {
//                               $(mymodel).find(`#pincode_update`).empty();
//                           $.map(res.pincode_list, function(v, i) {
//                             $(mymodel).find(`#pincode_update`).append(`
//                                   ${v}
//                             `);
//                         });
                        
//                     }
                    


//                 }
//             });

//         } else {
//             $(mymodel).find('#city_update').html('<option value="">select state first</option>');
//         }

//     }))
// });
</script>



  <script src="<?= base_url()?>assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="<?= base_url()?>assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<script>
$(document).ready(function() {
let  result_list_table = '';
    $("[data-users_filter]").on('change', (function() {
        let filter_attr =this.getAttribute("name");
        
        let getInput = [];
        $.map($(`select[data-users_filter]`), (v, i) => {             
            getInput.push(`${$(v).attr('name')}=${$(v).find(':selected').val()}`);
        })
        getInput = getInput.join('&');
        
        console.log(getInput);
        getlist(getInput,filter_attr)
    }))
    var stateID = $(this).val();
    function getlist(getInput ="",filter_attr="") {
        $.ajax({
            type: "POST",
            url: "<?= base_url()?>users/fetch_users_filter?" + getInput,
            data: "",
            success: function(html) {
                let res = JSON.parse(html);
                console.log(res);
                if(filter_attr != 'city' && filter_attr != 'now_playing' && filter_attr != 'sports' &&  filter_attr != 'pincode')
                    $(`#city_filter`).empty();
                $.map(res.city_list, function(v, i) {
                    $(`#city_filter`).append(`
                              ${v}
                            `);
                });
                          if (result_list_table != '') 
                          {
                             result_list_table.clear()
                             result_list_table.destroy();
                         } 
                         var i=1;
                $.map(res.user_list, function(v, i) {
                    var btn_text = '';
                    var user_type = '';
                    i++;
                    if (v.status == 1) {
                        var btn_text = `<a onclick="return confirm('Are you sure you want to inactive?')" href='<?= base_url()?>users/update_users_status?id=${v.uid}&status=${v.status}'><button
                        class="btn btn-success btn-sm">Active</button></a>`;
                    }  if (v.status == 0) {
                        btn_text = `<a onclick="return confirm('Are you sure you want to active?')" href='<?= base_url()?>users/update_users_status?id=${v.uid}&status=${v.status}'><button
                             class="btn btn-danger btn-sm">Deactive</button></a>`;
                    }
                    
                    if(v.type == 0)
                    {
                        user_type = "individual player";
                    }if(v.type== 1)
                    {
                        user_type = "team";
                    }
                    $(`#select_users`).append(`     
                     <tr>
                      <td><input value="${v.uid}" type="checkbox" data-single_select class="messageCheckbox" ></td>
                    <td>${i}</td>
                     <td>${user_type}</td>
                    <td><img src="<?= base_url()?>${v.image}"
                    class="user-img">${v.name}</td>
                    <td>${v.mobile}</td>
                    
                      <td>${atob(v.password)}</td>
                    <td>${v.email}</td>
                    <td>${v.title}</td>
                    <td>${v.sname}</td>
                    <td>${v.cname}</td>
                    <td>${v.pincode}</td>
                    <td>
                    ${btn_text}                                    
                    </td>
                    <td>
                        <div class="action-btn">
                    
             <button class="btn btn-primary btn-edit btn-sm" onclick="show_model(${v.uid})" ><i class=" bx bxs-pencil"></i></button>

                            <a href="<?= base_url('tournaments/delete_tournament')?>/${v.uid}"><button
                                    type="button"
                                    onclick="return confirm('Are you sure you want to delete this tournament?');"
                                    class="btn btn-danger btn-sm"><i class="bx bxs-trash" aria-hidden="true"></i>
                                </button></a>
                        </div>
                    
                    </td>
                    </tr>
                        `);
                    
                });
                //result_list_table = $(`[data-result_list_table]`).DataTable();
                result_list_table = $(`[data-result_list_table]`).DataTable({
                "aLengthMenu": [
                [10,25, 50, 100, -1],
                [10,25, 50, 100, "All"]
                ],
                "iDisplayLength": 10,
                });
            }
        });
    }
    getlist("", "");
  
  
});
</script>

<script>
    
               function  show_model(id)
                        {
                              $.ajax({
                                    type: "POST",
                                    url: "<?= base_url()?>users/fetch_model_data",
                                    data: { user_id : id},
                                        success: function(html)
                                        {
                                          let res = JSON.parse(html);
                                          $(`#update`).modal('show');
                                             console.log(typeof (res.user_list.pincode));
                                            //   $("#myform input[name='amount']").val($(this).text())
                                           
                                            if((res.user_list.pincode.length) > 0)
                                            {
                                             $(`#update [name='pincode']`).val(res.user_list.pincode);       
                                            }else{
                                                 $(`#update [data-pincode_div_update]`).hide(); 
                                                 $(`#update [name='pincode']`).val(''); 
                                            }
                                               
                                       
                                          $(`#update [name='name']`).val(res.user_list.name);
                                          
                                          
                                              $(`#update [name='username']`).val(res.user_list.username);
                                              
                                                  $(`#update [name='password']`).val(res.user_list.password);
                                                  
                                                      $(`#update [name='experience']`).val(res.user_list.experience);
                                                      
                                                      
                                          $(`#update [name='email']`).val(res.user_list.email);
                                          $(`#update [name='mobile']`).val(res.user_list.mobile);
                                          $(`#update [name='id']`).val(res.user_list.uid);
                                          $(`#update [name='status']`).val(res.check_status);
                                          $(`#update [name='show_image']`).attr('src',res.user_list.image);
                                           
                                            $(`#state_update`).empty();
                                            $.map(res.state_list, function(v, i) {
                                            $(`#state_update`).append(` ${v} `);});
                                                
                                            $(`#district_update`).empty();
                                            $.map(res.district_list, function(v, i) {
                                            $(`#district_update`).append(` ${v}`); });
                                                           
                                            $(`#city_update`).empty();            
                                            $.map(res.city_list, function(v, i) {
                                            $(`#city_update`).append(`${v}`); });
                                                        
                                            $(`#type_update`).empty();            
                                            $.map(res.type_list, function(v, i) {
                                            $(`#type_update`).append(`  ${v} `);  });
                                             
                                            $(`#game_cat`).empty(); 
                                            $.map(res.game_list, function(v, i) {
                                            $(`#game_cat`).append(`  ${v} `);  });
                                                       
                                                       
                                        }   
                        
                                 });
                        }      
    
</script>









 <script>
$(document).ready(function() {
    
    $("[data-filter_update]").on('change', (function() {
        let filter_attr =this.getAttribute("name");
       
        if(filter_attr=='state'){
            $('#district').empty()
            $('#city').empty()
            $('#pincode').empty()
        }
        if(filter_attr=='district'){
            $('#city').empty()
            $('#pincode').empty()
        }
        if(filter_attr=='city'){
            $('#pincode').empty()
        }
        
        let getInput = [];
        $.map($(`select[data-filter_update]`), (v, i) => {
            getInput.push(`${$(v).attr('name')}=${$(v).find(':selected').val()}`);
        })
        getInput = getInput.join('&');
        var stateID = $(this).val();
        if (stateID) {
            $.ajax({
                type: "POST",
                url: "<?= base_url()?>Users/fetch_state_city_district_pincode?" + getInput,
                data: "",
                success: function(html) {
                    // $(`[data-filter] [name="city"]`).empty();
                   console.log(filter_attr)
                    let res = JSON.parse(html);
                    if(filter_attr == 'state')
                    {
                        $(`#district_update`).empty();
                        $.map(res.district_list, function(v, i) {
                            $(`#district_update`).append(`
                                  ${v}
                            `);
                        });
                        
                         $.map(res.city_list, function(v, i) {
                            $(`#city_update`).append(`
                                  ${v}
                            `);
                        });
                   
                    }
                  else if((filter_attr == 'district'))
                    {
                          $(`#city_update`).empty();
                        $.map(res.city_list, function(v, i) {
                            $(`#city_update`).append(`
                                  ${v}
                            `);
                        });
                        
                    }
                }
            });

        } else {
            $('#city').html('<option value="">select state first</option>');
        }

    }))
});
</script>





<script>

function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

</script>


<script>
function select_all(obj) {
    if ($(obj).is(':checked')) {
        $(`[data-single_select]`).prop('checked', true);
    } else {
        $(`[data-single_select]`).prop('checked', false);
    }
}
function show_and_hide_mobile_no(val)
{ 
    let all="";
    var button_type=val;
    var type=$('#select_user_type').val();
    var checkedValues = $('.messageCheckbox:checked');//$(`[data-single_select]`);
    var allcheckedandincheckedvalue=$(`[data-single_select]`);
    let CollectArr = [];
    let AllCollectArr = [];
    checkedValues.each(function () {
          CollectArr.push($(this).val());
    });
     allcheckedandincheckedvalue.each(function () {
          AllCollectArr.push($(this).val());
    });
     if(JSON.stringify(CollectArr)==JSON.stringify(AllCollectArr))
     {
          all='all_values';
     }
        $.ajax({
        url: "<?= base_url('admin/Update_Show_Hide_Mobile_Status') ?>",
        method: "post",
        data: {'id':CollectArr,'type':type,'button_type':button_type,'all':all},
        success:function(data)
        {
            if(CollectArr!=""){
            if(data==1)
                {
                    setTimeout(function(){
                    $('#show_message').html('<div class="alert alert-success text-center" >Status changed successfully!</div>');
                    window.location.reload();
                    },1000
                    );
                }else{
                    setTimeout(function(){
                    $('#show_message').html('<div class="alert alert-danger text-center" >Unable to change status!</div>');
                    window.location.reload();
                    },1000
                    );
                }
            }
            else{
                
                 $('#show_message').html('<div class="alert alert-danger text-center" >Please checked atleast one user!</div>');
            }
        
        }
        })
}

// function isExperience(evt) {
//     evt = (evt) ? evt : window.event;
//     var charCode = (evt.which) ? evt.which : evt.keyCode;
//     if (( charCode.match(/^[0-9]{6}\.[0-9]{3}$/))) {
//         return false;
//     }
//     return true;
// }
</script>





