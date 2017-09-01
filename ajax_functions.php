<?php

include('db.php');
$instance = ConnectDb::getInstance();
$conn = $instance->getConnection();

if( $_POST["action"] == "savestdnt"){
	savestdnt($conn);
}

if( $_POST["action"] == "delt_std"){
	delete_student($conn);
}

if( $_POST["action"] == "updatstd"){
	update_student($conn);
}

if( $_POST["action"] == "delete_intructor"){
	delete_intructor($conn);
}

if( $_POST["action"] == "delt_usr"){
	delt_usr($conn);
}


if( $_POST["action"] == "adduser"){
	add_user($conn);
}

if( $_POST["action"] == "get_perms"){
	get_perms($conn);
}

if( $_POST["action"] == "update_perms"){
	update_perms($conn);
}

function update_perms($conn){
		$perm_ids_post=$_POST["selected_perms"];
		$role_id= $_POST["role_id"];

	//delete all permision for a role
		$sql1="SET autocommit=0";
		mysqli_query($conn, $sql1);

		$sql2="START TRANSACTION";
		mysqli_query($conn, $sql2);

		//$sql3="SELECT * FROM role_perm WHERE role_id='".$role_id."'";
		//mysqli_query($conn, $sql3);


		$sql4="DELETE FROM role_perm WHERE role_id ='".$role_id."'";
		mysqli_query($conn, $sql4);

	//insert all permision for a role

		$perm_ids=explode(",",$perm_ids_post);

		foreach ($perm_ids as $perm_id) {
		    $sql5="INSERT INTO role_perm (`role_id`, `perm_id`) values ('".$role_id."','".$perm_id."')";
			mysqli_query($conn, $sql5);
		}

		$sql6="COMMIT";
		mysqli_query($conn, $sql6);

		echo "saved Successfully !";
   
}


function get_perms($conn){
     if(!empty($_POST["role_id"]) ){
      		 $sql="SELECT * FROM `role_perm` rp JOIN permissions p on rp.perm_id=p.perm_id WHERE rp.role_id=".$_POST["role_id"]."";
             $result = mysqli_query($conn, $sql);
             $permids;
             if ($result->num_rows > 0) {
             	$i=0;

                while($row = $result->fetch_assoc()) {
                	if($i==0){
                		$permids = $row['perm_id'];
                	}else{
                		$permids = $permids .",".$row['perm_id'];
                	}
                	$i++;
                }
               echo $permids;
                //return $arr_perms;
                
            }
    }
   
}


function add_user($conn){

	
	if(!empty($_POST["txtname"]) &&  !empty($_POST["txtusername"]) && !empty($_POST["txtpassword"]) && $_POST['userroleid'] >0 ){

		$name= $_POST["txtname"];
		$username= $_POST["txtusername"];

		$pass = trim($_POST['txtpassword']);
	    $pass = strip_tags($pass);
	    $pass = htmlspecialchars($pass);
	    // prevent sql injections / clear user invalid inputs
	    
	    $userpass = hash('SHA256', $pass); // password hashing using SHA256

		$sql1="SET autocommit=0";
		mysqli_query($conn, $sql1);

		$sql2="START TRANSACTION";
		mysqli_query($conn, $sql2);

		$sql3="INSERT INTO users (`user_id`, `name`, `username`, `userpass`) values ('','".$name."','".$username."','".$userpass."')";
		//echo $sql3;exit;
		mysqli_query($conn, $sql3);

		$last_id = mysqli_insert_id($conn);
		$temp_lastinsertid= $last_id;

		//echo  $last_id;
		//exit;
		if($last_id >0){
			
			$sql4="INSERT INTO `user_role`(`user_id`, `role_id`) VALUES ('".$last_id."','".$_POST['userroleid']."')";
			mysqli_query($conn, $sql4);
			

			$sql5="COMMIT";
			mysqli_query($conn, $sql5);
			echo "Save Success !";
			

		}else{
			$sql5="ROLLBACK";
			mysqli_query($conn, $sql5);		
			echo "insert failed !";
		}	
	}else{
		echo "Error!";
	}

}

function delete_intructor($conn){
	if(!empty($_POST["instr_id"])){

		$sql1="SET autocommit=0";
		mysqli_query($conn, $sql1);

		$sql2="START TRANSACTION";
		mysqli_query($conn, $sql2);

		$sql3="DELETE FROM instructors WHERE instr_id ='".$_POST["instr_id"]."'";
		mysqli_query($conn, $sql3);

		$sql4="COMMIT";
		mysqli_query($conn, $sql4);
		echo "Deleted Successfully !";
	}else{
		echo "Error!";
	}
}

function delt_usr($conn){
	if(!empty($_POST["user_id"])){

		$sql1="SET autocommit=0";
		mysqli_query($conn, $sql1);

		$sql2="START TRANSACTION";
		mysqli_query($conn, $sql2);

		$sql3="DELETE FROM users WHERE user_id ='".$_POST["user_id"]."'";
		mysqli_query($conn, $sql3);

		$sql4="COMMIT";
		mysqli_query($conn, $sql4);
		echo "Deleted Successfully !";
	}else{
		echo "Error!";
	}
}



function update_student($conn){
	if(!empty($_POST["txtname"]) &&  !empty($_POST["txtadd"]) && !empty($_POST["txtphone"]) && $_POST['selected_subjects'] !='null' ){

		$std_id= $_POST["std_id"];
		$name= $_POST["txtname"];
		$address= $_POST["txtadd"];
		$phone= $_POST["txtphone"];

		$selected_subjects = substr($_POST["selected_subjects"], 1, -1);
		$selctd_arr = explode(',', $selected_subjects);

	
		$sql1="SET autocommit=0";
		mysqli_query($conn, $sql1);

		$sql2="START TRANSACTION";
		mysqli_query($conn, $sql2);

		$sql3="SELECT * FROM students WHERE std_id='".$std_id."'";
		mysqli_query($conn, $sql3);

		$sql4="UPDATE students  SET  name='".$name."', address='".$address."', phone_no='".$phone."' WHERE std_id='".$std_id."'";
		$res_upd=mysqli_query($conn, $sql4);
		if($res_upd == 1)
		{
			$sql5="DELETE FROM students_following_subjects WHERE std_id ='".$_POST["std_id"]."'";
			mysqli_query($conn, $sql5);

			$selected_subjects = substr($_POST["selected_subjects"], 1, -1);
			$selctd_arr = explode(',', $selected_subjects);

			foreach ($selctd_arr as $key => $sub_id) {
				$sql6="INSERT INTO `students_following_subjects`(`id`, `std_id`, `subj_id`) VALUES ('','".$std_id."','".$sub_id."')";
				mysqli_query($conn, $sql6);
			}


			$sql7="COMMIT";
			mysqli_query($conn, $sql7);
			echo "Updated Successfully !";

		}else{
			echo "Updated failed !";
		}


		


	}else{

		echo "Error !";
	}
}

function delete_student($conn){
	if(!empty($_POST["std_id"])){

		$sql1="SET autocommit=0";
		mysqli_query($conn, $sql1);

		$sql2="START TRANSACTION";
		mysqli_query($conn, $sql2);

		$sql3="DELETE FROM students WHERE std_id ='".$_POST["std_id"]."'";
		mysqli_query($conn, $sql3);

		$sql4="COMMIT";
		mysqli_query($conn, $sql4);
		echo "Deleted Successfully !";
	}else{
		echo "Error!";
	}
}


function savestdnt($conn){

	if(!empty($_POST["txtname"]) &&  !empty($_POST["txtadd"]) && !empty($_POST["txtphone"]) && $_POST['selected_subjects'] !='null' ){


		$name= $_POST["txtname"];
		$address= $_POST["txtadd"];
		$phone= $_POST["txtphone"];

		$selected_subjects = substr($_POST["selected_subjects"], 1, -1);
		$selctd_arr = explode(',', $selected_subjects);

		//print_r($selctd_arr);



		$sql1="SET autocommit=0";
		mysqli_query($conn, $sql1);

		$sql2="START TRANSACTION";
		mysqli_query($conn, $sql2);

		$sql3="INSERT INTO `students`(`std_id`, `name`, `address`, `phone_no`) VALUES ('','".$name."','".$address."',".$phone.")";
		mysqli_query($conn, $sql3);

		$last_id = mysqli_insert_id($conn);
		$temp_lastinsertid= $last_id;


		//echo  $last_id;
		//exit;
		if($last_id >0){
			foreach ($selctd_arr as $key => $value) {
				$sql4="INSERT INTO `students_following_subjects`(`id`, `std_id`, `subj_id`) VALUES ('','".$last_id."','".$value."')";
				mysqli_query($conn, $sql4);
			}

			$sql5="COMMIT";
			mysqli_query($conn, $sql5);
			echo "Save Success !";
			

		}else{
			$sql5="ROLLBACK";
			mysqli_query($conn, $sql5);		
			echo "insert failed !";
		}	

		

		

		
		


		/*

		$sql1="SET autocommit=0";
		$sql2="START TRANSACTION";
		$sql3="SELECT name FROM students WHERE std_id = '8' FOR UPDATE";
		$sql4="UPDATE students SET name = 'hilmy' WHERE std_id ='8'";
		$sql5="COMMIT";


		mysqli_query($conn, $sql1);
		mysqli_query($conn, $sql2);
		mysqli_query($conn, $sql3);
		mysqli_query($conn, $sql4);
		mysqli_query($conn, $sql5);
		                            


		SET autocommit=0;
		START TRANSACTION;
		INSERT INTO `students`(`std_id`, `name`, `address`, `phone_no`) VALUES ('','svsfv','dscd','23234');
		SELECT * FROM `students` WHERE 1;
		COMMIT;




		SET autocommit=0;
		START TRANSACTION;
		SELECT name FROM students WHERE std_id = '8' FOR UPDATE;
		UPDATE students SET name = 'shazny' WHERE std_id ='8';
		COMMIT;

		*/

	}else{

		echo "Error !";
	}

}
			



?>