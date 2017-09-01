<?php
include('header.php');
?>

<!-- Main -->
<div class="container-fluid">
    <div class="row">
        <?php include('side_menu.php');?> 

       
        <div class="col-sm-9">

          
            <a href="#"><strong><i class="glyphicon glyphicon-dashboard"></i> My Dashboard</strong></a>
            <hr>

          <div class="container">
      
             
        <div class="panel panel-flat">
        <div class="panel-heading"><h3>Add New User</h3></div>
        <div class="panel-body"> 
          <div class="row">   
             <form id="frm_add_user">               
                  <div class="col-sm-6"><!-- left column -->
                          <div class="form-group">
                        <label> Full Name :</label>
                          <input type="text" class="form-control" name="txtname" id="txtname">
                        </div>
                        <div class="form-group">
                          <label> Username :</label>
                          <input type="text" class="form-control" name="txtusername" id="txtusername">
                        </div>
                        <div class="form-group">
                          <label>Password :</label>
                          <input type="password" class="form-control" name="txtpassword" id="txtpassword">
                        </div>
                        <label> User Role :</label>
                        
                        <?php

                             $sql="SELECT * FROM roles";
                             $result = mysqli_query($conn, $sql);
                             
                             if ($result->num_rows > 0) {
                                // output data of each row
                                echo "<select id='dropdRole'>";
                                while($row = $result->fetch_assoc()) {
                                   echo " <option value='".$row['role_id']."'>".$row['role_dis_name']."</option>";
                                }
                                 echo "</select>";
                               }
                            ?>

                          


                        </div>
                  </div> 
                  <!--end left column -->



                  <div class="col-sm-12">
                  <div class="form-group">
                      <input type="submit" value="Add User" />
                  </div>
                  </div>
                 
              </form>
            </div>

          </div>
          </div>
         
        </div>
      </div>
    </div>
   </div>


<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<script type="text/javascript">



$(document).ready (function() {


var request;
$("#frm_add_user").submit(function(event){


    event.preventDefault();

    if (request) {
        request.abort();
    }

    var $form = $(this);


    var $inputs = $form.find("input, checkbox, select, button, textarea");

    var userroleid = document.getElementById("dropdRole");
    var userroleid = dropdRole.options[dropdRole.selectedIndex].value;

    // Serialize the data in the form
    var serializedData = $form.serialize() +  '&userroleid=' + userroleid  +  '&action=' + "adduser";


    $inputs.prop("disabled", true);

    request = $.ajax({
        url: "./ajax_functions.php",
        type: "post",
        data: serializedData
    });

  // Callback handler 
    request.done(function (response, textStatus, jqXHR){
        console.log("Hooray, it worked!");
        alert(response);
        location.reload();
    });

    // Callback handler 
    request.fail(function (jqXHR, textStatus, errorThrown){
        console.error(
            "The following error occurred: "+
            textStatus, errorThrown
        );
    });

    // Callback handler that will be called regardless
    // if the request failed or succeeded
    request.always(function () {
        // Reenable the inputs
        $inputs.prop("disabled", false);
    });

});


});





</script>
        
<!-- /Main -->

<?php
include('footer.php');
?>
        
    </body>
</html>
