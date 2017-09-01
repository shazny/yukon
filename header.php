<?php

include('db.php');


$instance = ConnectDb::getInstance();
$conn = $instance->getConnection();

ob_start();
session_start();


?>



<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8"> 
        <meta charset="utf-8">
        <title>Yukon - Mohamed Shazny</title>
        <meta name="generator" content="Bootply" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="description" content="Yukon- Shazny" />
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" rel="stylesheet">
        

        <link rel="apple-touch-icon" href="/bootstrap/img/apple-touch-icon.png">
        <link rel="apple-touch-icon" sizes="72x72" href="/bootstrap/img/apple-touch-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="114x114" href="/bootstrap/img/apple-touch-icon-114x114.png">


        
        <style type="text/css">
            .navbar-static-top {
  margin-bottom:20px;
}

i {
  font-size:16px;
}

.nav > li > a {
  color:#787878;
}
  
footer {
  margin-top:20px;
  padding-top:20px;
  padding-bottom:20px;
  background-color:#efefef;
}

/* count indicator near icons */
.nav>li .count {
  position: absolute;
  bottom: 12px;
  right: 6px;
  font-size: 9px;
  background: rgba(51,200,51,0.55);
  color: rgba(255,255,255,0.9);
  line-height: 1em;
  padding: 2px 4px;
  -webkit-border-radius: 10px;
  -moz-border-radius: 10px;
  -ms-border-radius: 10px;
  -o-border-radius: 10px;
  border-radius: 10px;
}

.container {
    width: 100% !important;
}
.panel {
    background-color: #dedede !important;
    }

.table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th{
  border: 1px solid #222222 !important;
}

        </style>

<div id="top-nav" class="navbar navbar-inverse navbar-static-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Dashboard</a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a role="button" href="#"><i class="glyphicon glyphicon-user"></i><?php  if ( isset($_SESSION['username'])!="" ){ echo $_SESSION['username'];}else{ echo "";} ?></a>
                   
                </li>
                <?php
                 
                 //session_start();

                 if ( isset($_SESSION['user'])!="" ) {
                  echo "<li><a href='./logout.php'><i class='glyphicon glyphicon-lock'></i> Logout</a></li>";
                 }else{
                  echo "<li><a href='./login.php'><i class='glyphicon glyphicon-lock'></i> Login</a></li>";
                 }
                
                ?>
            </ul>
        </div>
    </div>
    <!-- /container -->
</div>

</header>
<!-- /Header -->


