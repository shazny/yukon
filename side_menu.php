<?php
require_once "PrivilegedUser.php";
?>
<html>
 <div class="col-sm-3">
            <!-- Left column -->
            <strong><i class="glyphicon glyphicon-dashboard"></i><a href="./index.php"> Dashboard</a></strong>

      
            <hr>

           <strong><i class="glyphicon glyphicon-user"></i>  Students</strong>

            <ul class="nav nav-stacked">   
                    <ul class="nav nav-stacked collapse in" id="userMenu">
                        <li class="active"> <a href="./view_students.php"><i class="glyphicon glyphicon-list-alt"></i> View Students</a></li>      
                        <li><a href="./add_students.php"><i class="glyphicon glyphicon-plus"></i> Add Student</a></li>

                    </ul>      
            </ul>

            <strong><i class="glyphicon glyphicon-user"></i>  Instructors</strong>

            <ul class="nav nav-stacked">    
                    <ul class="nav nav-stacked collapse in" id="userMenu">
                        <li class="active"> <a href="./view_instructors.php"><i class="glyphicon glyphicon-list-alt"></i> View Instructors</a></li>      
                        <li><a href="./add_instructor.php"><i class="glyphicon glyphicon-plus"></i> Add Instructors</a></li>
                    </ul>
            </ul>

            <strong><i class="glyphicon glyphicon-book"></i>  Subjects</strong>

            <ul class="nav nav-stacked">    
                    <ul class="nav nav-stacked collapse in" id="userMenu">
                        <li class="active"> <a href="./view_subjects.php"><i class="glyphicon glyphicon-list-alt"></i> View Subjects</a></li>      
                    </ul>
            </ul>

            <?php
            if (isset($_SESSION["username"])) {
                $u = PrivilegedUser::getByUsername($_SESSION["username"],$conn);
            }
            if ($u->hasPrivilege('user_manage') ) {
                echo"
                    <strong><i class='glyphicon glyphicon-user'></i>  Users</strong>

                    <ul class='nav nav-stacked'>    
                            <ul class='nav nav-stacked collapse in' id='userMenu'>
                                <li class='active'> <a href='./view_users.php'><i class='glyphicon glyphicon-list-alt'></i> View Users</a></li> 
                                <li class='active'> <a href='./add_users.php'><i class='glyphicon glyphicon-plus'></i> Add Users</a></li>      
                                <li><a href='./set_user_previleges.php'><i class='glyphicon glyphicon-tasks'></i> Set Previleges</a></li>
                            </ul>
                    </ul>";
            }
            ?>

        </div>
        <!-- /col-3 -->
</html>

