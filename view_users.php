<?php
include('header.php');
?>

<!-- Main -->
<div class="container-fluid">
    <div class="row">
        <?php include('side_menu.php'); ?> 

       
        <div class="col-sm-9">

          
            <a href="#"><strong><i class="glyphicon glyphicon-dashboard"></i> My Dashboard</strong></a>
            <hr>

          <div class="container">
              <h2>Users List</h2>
              
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>User ID </th>
                    <th>Full Name </th>
                    <th>Username</th>
                    <th>User Role</th>
                    <th>Actions</th>


                  </tr>
                </thead>
                <tbody>
                  <?php
                   //$rows = $conn->query("SELECT * FROM students");
                   $sql="SELECT * FROM roles r JOIN user_role ur ON r.role_id=ur.role_id join users u on u.user_id=ur.user_id ";
                   $result = mysqli_query($conn, $sql);
                   if ($result->num_rows > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {

                //  foreach ($rows as $row ) {
                    echo "<tr>";
                    echo "<td>".$row['user_id']."</td>";
                    echo "<td>".$row['name']."</td>";
                    echo "<td>".$row['username']."</td>";
                    echo "<td>".$row['role_dis_name']."</td>";
                    echo "<td>
                              <a id='".$row['user_id']."' onclick='delt_usr(this)'><span class='glyphicon glyphicon-trash'></span></a>
                          </td>";
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

<script type="text/javascript">


function delt_usr(event){

  $(document).ready(function() {
    $.ajax({
          url: "./ajax_functions.php",
          type: "post",
          data: {'action': 'delt_usr', 'user_id': event.id},
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
