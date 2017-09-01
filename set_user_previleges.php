<?php
include('header.php');
?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>


<script type="text/javascript">



function check(browser) {

  $(document).ready(function() {
    $('input:checkbox').removeAttr('checked');
    $.ajax({
          url: "./ajax_functions.php",
          type: "post",
          data: {'action': 'get_perms', 'role_id': browser},
          success: function (response) {
           // alert(response); 
            var res = response.split(',');
           // alert(res.length);
            for (i = 0; i < res.length; i++) { 
                document.getElementById("chprm-"+res[i]).checked = true;
            }
    
          },
          error: function(jqXHR, textStatus, errorThrown) {
             console.log(textStatus, errorThrown);
          }

      });
  });

}


</script>


<!-- Main -->
<div class="container-fluid">
    <div class="row">
        <?php include('side_menu.php');?> 

       
        <div class="col-sm-9">

          
            <a href="#"><strong><i class="glyphicon glyphicon-dashboard"></i> My Dashboard</strong></a>
            <hr>

          <div class="container">
      
             
        <div class="panel panel-flat">
        <div class="panel-heading"><h3>Set User Previlges</h3></div>
        <div class="panel-body"> 
          <div class="row">   
             <form id="frm_set_prev">               
                  <div class="col-sm-6"><!-- left column -->
                    <?php

                     $sql="SELECT * FROM roles";
                     $result = mysqli_query($conn, $sql);
                     
                     //$rows = $conn->query("SELECT s.subject,s.subj_id,i.instr_name FROM subjects s JOIN instructors i ON s.instr_id=i.instr_id");
                      if ($result->num_rows > 0) {
                        // output data of each row
                          
                        while($row = $result->fetch_assoc()) {
    
                           echo"     
                                <input id='ddd' type='radio' name='role_id' onclick='check(this.value)' value='".$row['role_id']."'>".$row['role_dis_name']."<br>
                              
                              ";
                        }
                      }
                    ?>

                   
                  </div> 
                  <!--end left column -->

                   <!-- right column start -->  
                  <div class="col-sm-6"> 
                    <h4>Set User Permisions</h4>
                    <div class="col-sm-10"> 
                       <table class="table table-bordered">
                          <thead>
                            <tr>
                              <th>Permisions</th>
                              <th>Check</th>

                            </tr>
                          </thead>
                          <tbody>

                            <?php

                             $sql="SELECT * FROM permissions";
                             $result = mysqli_query($conn, $sql);
                             
                             //$rows = $conn->query("SELECT s.subject,s.subj_id,i.instr_name FROM subjects s JOIN instructors i ON s.instr_id=i.instr_id");
                              if ($result->num_rows > 0) {
                                // output data of each row
                                while($row = $result->fetch_assoc()) {
                                   echo "<div class='form-group'>"; 
                                   echo " <tr>";
                                   echo "   <th> ".$row['perm_descriptions']." </th>";
                                   echo "   <th>  <input type='checkbox' id=chprm-".$row['perm_id']." class='frmchkbx' name='permChekbx' value=".$row['perm_id']."> </th>";
                                   echo "</tr>";
                                   echo "</div>";
                                 }
                               }
                            ?>
                        </tbody>
                      </table>
                    </div>  
                  </div>  
                  

                  <div class="col-sm-12">
                  <div class="form-group">
                      <input type="submit" value="Save" />
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


<script>

$(document).ready (function() {

var request;
$("#frm_set_prev").submit(function(event){

    event.preventDefault();

    if (request) {
        request.abort();

    }

    var role_id = document.getElementsByName('role_id');
    var role_id_val;
    for(var i = 0; i < role_id.length; i++){
        if(role_id[i].checked){
            role_id_val = role_id[i].value;
        }
    }
    //alert(role_id_val);


    var $form = $(this);

    var $inputs = $form.find("input, checkbox, select, button, textarea");

    var checkedBoxes = document.querySelectorAll('input[name=permChekbx]:checked');
    
    var selected_value;
    for($i =0 ; $i<checkedBoxes.length; $i++){
      if($i==0){
        var selected_value=checkedBoxes[$i].value;
      }else{
         var selected_value= selected_value+','+checkedBoxes[$i].value;
      }
    }
    
    // Serialize the data in the form
    var serializedData = $form.serialize() +  '&selected_perms=' + selected_value  +  '&action=' + "update_perms" + '&role_id=' + role_id_val;


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
