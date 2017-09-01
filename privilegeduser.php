<?php
require_once "user.php";

include('role.php');
//include('db.php');

//$instance = ConnectDb::getInstance();
//$conn = $instance->getConnection();



class PrivilegedUser extends User
{
    private $roles;

   // public function __construct() {
   //     parent::__construct();
   // }


    public static function getByUsername($username,$conn) {
       // $user_id='1';
        //$username='shazny';
        //$password="a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3";

        $sql = "SELECT * FROM users WHERE username = '".$username."'";
        $result = mysqli_query($conn, $sql);
        $row=$result->fetch_assoc();

        if (!empty($result)) {
            $privUser = new PrivilegedUser($username,$row['userpass']);
            $privUser->user_id = $row['user_id'];
            $privUser->username = $username;
            $privUser->password = $row['userpass'];
            $privUser->initRoles($row['user_id']);
            return $privUser;
        } else {
            return false;
        }
    }

    // populate roles with their associated permissions
    protected function initRoles($user_id) {
        $this->roles = array();
        $sql = "SELECT t1.role_id, t2.role_name FROM user_role as t1
                JOIN roles as t2 ON t1.role_id = t2.role_id
                WHERE t1.user_id = '".$user_id."'";


        $instance = ConnectDb::getInstance();
        $conn = $instance->getConnection();

        $result = mysqli_query($conn, $sql);
        //echo("<script>console.log('PHP: ".$user_id."');</script>");
        if ($result->num_rows > 0) {

            while($row = $result->fetch_assoc()) {
                $this->roles[$row["role_name"]] = Role::getRolePerms($row["role_id"]);
            }
        }
    }

    // check if user has a specific privilege
    public function hasPrivilege($perm) {
        //echo("<script>console.log('PHP: ".'has prevelgde consile'."');</script>");
        //$role=new Role();
        foreach ($this->roles as $role) {
            if ($role->hasPerm($perm)) {
                return true;
            }
        }
        return false;
    }
}