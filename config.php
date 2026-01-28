<?php

define("db_server","localhost");
define("db_user","root");
define("db_password","");
define("db_dname","jewelry");

$conn = mysqli_connect(db_server,db_user,db_password,db_dname);
 
if(!$conn){
    alert("error connecting the server".mysqli_connect_error());
}

?>