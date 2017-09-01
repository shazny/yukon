<?php

class User
{
    protected $username;    // using protected so they can be accessed
    protected $password; // and overidden if necessary


    public function __construct($username, $password) 
    {
       $this->username = $username;
       $this->password = $password;
    }


    public function login()
    {
        $user = $this->_checkCredentials();
        if ($user) {
            $this->username = $user; // store it so it can be accessed later
            $_SESSION['username'] = $user;
            return $user['username'];
        }
        return false;
    }

    protected function _checkCredentials()
    {

        $instance = ConnectDb::getInstance();
        $conn = $instance->getConnection();


        $sql="SELECT * FROM users WHERE username ='".$this->username."'";
        $result = mysqli_query($conn, $sql);
        $row=$result->fetch_assoc();
        $count = $result->num_rows; // if uname/pass correct it returns must be 1 row
       
       if( $count == 1 && $row['userpass']== $this->password ) {
            return $this->username;

       } else {
            return false;
       }

    }

    public function getUser()
    {
        return $this->username;
    }
}


?>