<?php

//include('db.php');

//$instance = ConnectDb::getInstance();
//$conn = $instance->getConnection();


class Role
{
    protected $permissions;

    public function __construct() {
        $this->permissions = array();
    }

    // return a role object with associated permissions
    public static function getRolePerms($role_id) {
        $role = new Role();
        $sql = "SELECT t2.perm_desc FROM role_perm as t1
                JOIN permissions as t2 ON t1.perm_id = t2.perm_id
                WHERE t1.role_id = '".$role_id."'";


        $instance = ConnectDb::getInstance();
        $conn = $instance->getConnection();

        $result = mysqli_query($conn, $sql);
        if ($result->num_rows > 0) {
                    // output data of each row
             while($row = $result->fetch_assoc()) {
                $role->permissions[$row["perm_desc"]] = true;
             }

          return $role;
        }
    }

    // check if a permission is set
    function hasPerm($permission) {
        return isset($this->permissions[$permission]);
    }

}