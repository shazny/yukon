<?php
include('header.php');
//require_once "Role.php";
require_once "PrivilegedUser.php";


if( $_GET["stdnt_id"]){
 


//session_start();



  //echo $_GET["stdnt_id"];

   $sql_stndts="SELECT * FROM students WHERE std_id='".$_GET["stdnt_id"]."'";
   $result_stdnts = mysqli_query($conn, $sql_stndts);
   if ($result_stdnts->num_rows > 0) {
    // output data of each row
    while($row = $result_stdnts->fetch_assoc()) {


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
        <div class="panel-heading"><h3>Student Details</h3></div>
        <div class="panel-body"> 
          <div class="row">   
             <form id="stdfrm">               
                  <div class="col-sm-6"><!-- left column -->
                   
                      <h4>Students Details</h4>
                       <div class="form-group">
                        <label> Name :</label>
                          <input type="text" class="form-control" value="<?php echo $row['name'] ?>" name="txtname" id="txtname">
                        </div>
                        <div class="form-group">
                          <label> Address :</label>
                          <input type="text" class="form-control" value="<?php echo $row['address'] ?>" name="txtadd" id="txtadd">
                        </div>
                        <div class="form-group">
                          <label>Phone Number :</label>
                          <input type="text" class="form-control" value="<?php echo $row['phone_no'] ?>" name="txtphone" id="txtphone">
                        </div>
                        <input type="hidden" value="<?php echo $row['std_id'] ?>" name="std_id" id="std_id">
                  </div> 
                  <!--end left column -->

                  <!-- right column start -->  
                  <div class="col-sm-6"> 
                    <h4>Select Subjects</h4>
                    <div class="col-sm-10"> 
                       <table class="table table-bordered">
                          <thead>
                            <tr>
                              <th>Subject</th>
                              <th>Instructor Name</th>
                              <th>Check</th>

                            </tr>
                          </thead>
                          <tbody>

                            <?php

                             $sql="SELECT s.subject,s.subj_id,i.instr_name FROM subjects s JOIN instructors i ON s.subj_id=i.subj_id";
                             $result = mysqli_query($conn, $sql);
                             
                             //$rows = $conn->query("SELECT s.subject,s.subj_id,i.instr_name FROM subjects s JOIN instructors i ON s.instr_id=i.instr_id");
                              if ($result->num_rows > 0) {
                                // output data of each row
                                while($row1 = $result->fetch_assoc()) {
                                   echo "<div class='form-group'>"; 
                                   echo " <tr>";
                                   echo "   <th> ".$row1['subject']." </th>";
                                   echo "   <th> ".$row1['instr_name']." </th>";

                                   // tick if the studnet is following a subject
                                    $sql_std_subj="SELECT subj_id FROM students_following_subjects WHERE std_id='".$row['std_id']."'";                                
                                    $result_sql_std_subj = mysqli_query($conn, $sql_std_subj);
                                    if ($result_sql_std_subj->num_rows > 0) {
                                      // output data of each row

                                      $rowsarr = [];
                                      while($row_ = $result_sql_std_subj->fetch_assoc())
                                      {  
                                          $rowsarr[] = $row_['subj_id'];
                                      }
                                     // print_r($rowsarr); exit;
                                      echo "<th>";

                                      if (in_array($row1['subj_id'],  $rowsarr)) {
          
                                         echo "<input type='checkbox' checked class='frmchkbx' name='subchekbx' value=".$row1['subj_id']."> ";
                                    
                                      }else{
                                         echo "<input type='checkbox' class='frmchkbx' name='subchekbx' value=".$row1['subj_id']."> ";
                        
                                      }
                                     
                                      echo "</th>";

                                    }else{
                                       echo "<th><input type='checkbox' class='frmchkbx' name='subchekbx' value=".$row1['subj_id']."> </th>";    
                                    }

                                  
                                   

                                   echo "</tr>";
                                   echo "</div>";
                                 }
                               }
                            ?>
                        </tbody>
                      </table>
                    </div>  
                  </div>  

                  <?php
                    if (isset($_SESSION["username"])) {
                        $u = PrivilegedUser::getByUsername($_SESSION["username"],$conn);
                    }
                    //print_r($u);

                   // echo $u->hasPrivilege("edit_update_students");
                    if ($u->hasPrivilege("edit_update_students") ) {
                          
                      echo "<div class='col-sm-12'>";
                      echo "<div class='form-group'>";
                      echo "<input type='submit' value='Update' />";
                      echo "</div>";
                      echo "</div>";
                    }
                

                  ?>

                  


                  <!--end right column -->
                   </form>
            </div>

          </div>
          </div>
         
        </div>
      </div>
    </div>
   </div>
<!-- /Main -->





<?php
}
}

}else{




}
?>


<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript">



$(document).ready (function() {

  


  var request;
  $("#stdfrm").submit(function(event){
   var boolupdate = confirm("Do you wish to update students details ?");
   if (boolupdate == true) {

          event.preventDefault();

          if (request) {
              request.abort();
          }

          var $form = $(this);


          var $inputs = $form.find("input, checkbox, select, button, textarea");

          var selected_value=null;
          var i=0
          $(".frmchkbx:checked").each(function(){
                if(i==0){selected_value=$(this).val();}
                else{
                selected_value=selected_value+','+$(this).val();
                }
                i++;
          });

          // Serialize the data in the form
          var serializedData = $form.serialize() +  '&selected_subjects=' + JSON.stringify(selected_value)  +  '&action=' + "updatstd";


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
      }

  });


  });






</script>


        


<?php
include('footer.php');
?>
        
    </body>
</html>
