<?php
include('header.php');
require_once "PrivilegedUser.php";

?>


<?php
if (isset($_SESSION["username"])) {
    $u = PrivilegedUser::getByUsername($_SESSION["username"],$conn);
}
//print_r($u);

// echo $u->hasPrivilege("edit_update_students");
if ($u->hasPrivilege("add_intructor") ) {
      

                            

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
                    <div class="panel-heading"><h3>New Instructor</h3></div>
                    <div class="panel-body"> 
                      <div class="row">   
                         <form id="frm-inst">               
                              <div class="col-sm-6"><!-- left column -->
                               
                                  <h4> Enter Instructor Details</h4>
                                   <div class="form-group">
                                    <label> Instructor Name :</label>
                                      <input type="text" class="form-control" name="txtname" id="txtname">
                                    </div>
                                    <div class="form-group">
                                      <label> Address :</label>
                                      <input type="text" class="form-control" name="txtadd" id="txtadd">
                                    </div>
                                    <div class="form-group">
                                      <label>Phone Number :</label>
                                      <input type="text" class="form-control" name="txtphone" id="txtphone">
                                    </div>
                                    <div class="form-group">
                                      <?php
                                        $sql="SELECT * FROM `subjects` WHERE `subj_id` NOT IN (SELECT subj_id FROM `instructors`)";
                                        $result = mysqli_query($conn, $sql);
                                         
                                         //$rows = $conn->query("SELECT s.subject,s.subj_id,i.instr_name FROM subjects s JOIN instructors i ON s.instr_id=i.instr_id");
                                        if ($result->num_rows > 0) {
                                            // output data of each row
                                            echo "<label>Select Subject:</label>";
                                            echo "<select name='opt-subj'>";

                                             while($row1 = $result->fetch_assoc()) {
                                            
                                                echo "<option value =".$row1['subj_id']." >".$row1['subject']."</option>";

                                            }
                                            echo "</select>";
                                        }
                                      ?>     


                                    </div>

                              </div> 
                              <!--end left column -->

                             

                              <div class="col-sm-12">
                              <div class="form-group">
                                  <input type="submit" value="Save" />
                              </div>
                              </div>
                              <!--end right column -->
                               </form>
                        </div>

                      </div>
                      </div>
                     
                    </div>
                  </div>
                </div>
               </div>


<?php
}else{
  echo  " This User hase no permission to add students";
}

?>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript">


$(document).ready (function() {

var request;
$("#frm-inst").submit(function(event){

    event.preventDefault();

    if (request) {
        request.abort();
    }

    var $form = $(this);


    var $inputs = $form.find("input, checkbox, select, button, textarea");

   
    // Serialize the data in the form
    var serializedData = $form.serialize() +  '&action=' + "savesInstr";


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




  var selected = new Array();

    function savestd() {
      var selected_value = [];
      $(".frmchkbx:checked").each(function(){
          selected_value.push($(this).val());
      });


      var data = {
      "name": document.getElementById("txtname").value,
      "add": document.getElementById("txtadd").value,
      "phone" :document.getElementById("txtphone").value,

      };
      data = $(this).serialize() + "&" + $.param(data);

      $.ajax({
               type: "POST",
               //dataType: "json",
               action: "test",
               url: "./ajax_functions.php",
               data: "data",
               success: function(datas) {
                    alert(datas);                   
               }
        });

  }

</script>
        
<!-- /Main -->

<?php
include('footer.php');
?>
        
    </body>
</html>
