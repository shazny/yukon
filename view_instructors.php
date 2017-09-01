<?php
include('header.php');
require_once "PrivilegedUser.php";

?>

<?php
if (isset($_SESSION["username"])) {
    $u = PrivilegedUser::getByUsername($_SESSION["username"],$conn);
}
if ($u->hasPrivilege("view_instructors") ) {

?>
      <!-- Main -->
      <div class="container-fluid">
          <div class="row">
              <?php include('side_menu.php'); ?> 

             
              <div class="col-sm-9">

                
                  <a href="#"><strong><i class="glyphicon glyphicon-dashboard"></i> My Dashboard</strong></a>
                  <hr>

                <div class="container">
            			  <h2>Instructor List</h2>
                    
            			  <table class="table table-bordered">
            			    <thead>
            			      <tr>
                          <th>Instructor ID </th>
            			        <th>Name </th>
            			        <th>Address</th>
                          <th>Phone </th>
                          <th>Subject</th>
                          <?php
                          if (isset($_SESSION["username"])) {
                              $u = PrivilegedUser::getByUsername($_SESSION["username"],$conn);
                          }
                          if ($u->hasPrivilege("delete_intructor") ) {
                              echo "<th>Actions</th>";   
                          }
                          ?>
                          
            			      </tr>
            			    </thead>
            			    <tbody>
            			    	<?php
                         $sql="SELECT * FROM instructors i JOIN subjects s ON i.subj_id=s.subj_id ORDER BY `instr_id` ASC";
                         $result = mysqli_query($conn, $sql);
                         if ($result->num_rows > 0) {
                          // output data of each row
                          while($row = $result->fetch_assoc()) {

            					//	foreach ($rows as $row ) {
            						  echo "<tr>";
            						  echo "<td>".$row['instr_id']."</td>";
            						  echo "<td>".$row['instr_name']."</td>";
            						  echo "<td>".$row['instr_add']."</td>";
                          echo "<td>".$row['instr_phone']."</td>";
                          echo "<td>".$row['subject']."</td>"; 

                         
                          if (isset($_SESSION["username"])) {
                              $u = PrivilegedUser::getByUsername($_SESSION["username"],$conn);
                          }
                          if ($u->hasPrivilege("delete_intructor") ) {
                              echo "<td>
                                    <a id='".$row['instr_id']."' onclick='delt_intrc(this)'><span class='glyphicon glyphicon-trash'></span></a>
                                    </td>";   
                          }

                                          
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


function delt_intrc(event){

  $(document).ready(function() {
    $.ajax({
          url: "./ajax_functions.php",
          type: "post",
          data: {'action': 'delete_intructor', 'instr_id': event.id},
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
