<!--  function parameter : host's url, username, password, database name
      logs in to mysql with given host url, username, and password
      selects the database you want to access
      and returns the connection
-->
<?php
  function db_init($host, $duser, $dpw, $dname) {
    $conn = mysqli_connect($host, $duser, $dpw);
    mysqli_select_db($conn, $dname);
    return $conn;
  }
 ?>
