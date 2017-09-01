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
      			  <h2>Subject List</h2>
              
      			  <table class="table table-bordered">
      			    <thead>
      			      <tr>
                    <th>Subject ID </th>
      			        <th>Subject </th>
      			        <th>Book Name</th>
      			      </tr>
      			    </thead>
      			    <tbody>
      			    	<?php
      			 		   //$rows = $conn->query("SELECT * FROM students");
                   $sql="SELECT * FROM subjects";
                   $result = mysqli_query($conn, $sql);
                   if ($result->num_rows > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {

      					//	foreach ($rows as $row ) {
      						  echo "<tr>";
      						  echo "<td>".$row['subj_id']."</td>";
      						  echo "<td>".$row['subject']."</td>";
      						  echo "<td>".$row['subj_book']."</td>";
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
