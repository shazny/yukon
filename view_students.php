<?php
include('header.php');
require_once "PrivilegedUser.php";

?>

<?php
if (isset($_SESSION["username"])) {
    $u = PrivilegedUser::getByUsername($_SESSION["username"],$conn);
}

if ($u->hasPrivilege("view_students") ) {



?>
      <!-- Main -->
      <div class="container-fluid">
          <div class="row">
              <?php include('side_menu.php'); ?> 

             
              <div class="col-sm-9">

                
                  <a href="#"><strong><i class="glyphicon glyphicon-dashboard"></i> My Dashboard</strong></a>
                  <hr>

                <div class="container">
            			  <h2>Student List</h2>
                    
            			  <table class="table table-bordered">
            			    <thead>
            			      <tr>
            			        <th>Student ID</th>
            			        <th>Name</th>
            			        <th>Address</th>
            			        <th>Phone #</th>
                          <th>Actions</th>

            			      </tr>
            			    </thead>
            			    <tbody>
            			    	<?php
            			 		   //$rows = $conn->query("SELECT * FROM students");
                         $sql="SELECT * FROM students";
                         $result = mysqli_query($conn, $sql);
                         if ($result->num_rows > 0) {
                          // output data of each row
                          while($row = $result->fetch_assoc()) {

            					//	foreach ($rows as $row ) {
            						  echo "<tr>";
            						  echo "<td>".$row['std_id']."</td>";
            						  echo "<td>".$row['name']."</td>";
            						  echo "<td>".$row['address']."</td>";
            						  echo "<td>".$row['phone_no']."</td>";
                          echo "<td><a id='".$row['std_id']."' href='./student_details.php?stdnt_id=".$row['std_id']."'><span class='glyphicon glyphicon-pencil'></span> </a>
                                    &nbsp;&nbsp";

                                  
                                  if (isset($_SESSION["username"])) {
                                      $u = PrivilegedUser::getByUsername($_SESSION["username"],$conn);
                                  }
                                  if ($u->hasPrivilege("delete_intructor") ) {
                                    echo "<a id='".$row['std_id']."' onclick='delt_std(this)'><span class='glyphicon glyphicon-trash'></span></a>";
                                  }


                          echo      "</td>";
            						  echo "</tr>";


            						}
                      }
            					?>

            			     
            			    </tbody>
            			  </table>
      			     </div>


              
                  
              </div>
              <!--/col-span-9-->
          </div>
      </div>

<?php
}else{
  echo "This user does not have previledge to view student list";
}
?>


<script type="text/javascript">


function delt_std(event){

  $(document).ready(function() {
    $.ajax({
          url: "./ajax_functions.php",
          type: "post",
          data: {'action': 'delt_std', 'std_id': event.id},
          success: function (response) {
             alert(response);  
             location.reload();               

          },
          error: function(jqXHR, textStatus, errorThrown) {
             console.log(textStatus, errorThrown);
          }


      });
  });

}



</script>




<!-- /Main -->


<?php
include('footer.php');
?>
        
    </body>
</html>
