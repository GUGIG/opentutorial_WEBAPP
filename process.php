<!-- process.php sends data to the designated database -->
<?php
  require_once("config/config.php");
  require_once("lib/db.php");


// db의 커텍션을 얻어낸다.
  $conn = db_init($config["host"], $config["duser"], $config["dpw"], $config["dname"]);


// 이전 페이지에서 POST로 받은 데이터를 변수에 저장한다. db에 들어갈 데이터이므로 escape 시킨다.
  $title        = mysqli_real_escape_string($conn, $_POST['title']);
  $description  = mysqli_real_escape_string($conn, $_POST['description']);
  $name         = mysqli_real_escape_string($conn, $_POST['name']);
  $password     = mysqli_real_escape_string($conn, $_POST['password']);

  $sql_user_select = "SELECT * FROM user WHERE name='".$name."'"; // '".$name."' == '{$name}' 나중에 이렇게 고쳐서 쓰자.. ㅅㅂ
  $sql_user_insert = "INSERT INTO user(name, password) VALUES('$name', '$password')";


// user에 동일한 이름의 저자가 있는지를 확인한다. 이 때, 동일한 이름의 저자가 없는 경우 user에 추가시킨다.
  $result = mysqli_query($conn, $sql_user_select);
  $row = mysqli_fetch_assoc($result);

  if($row['name'] != $name) {
    mysqli_query($conn, $sql_user_insert);
    $result = mysqli_query($conn, $sql_user_select);
    $row = mysqli_fetch_assoc($result);
  }


// 해당 이름의 저자의 user.id를 알아낸다.
  $author = $row['id'];


// topic에 제목, 설명, 저자의 user.id, 글쓴 일시의 정보를 갖는 새 튜플을 추가한다.
  $sql_topic = "INSERT INTO topic(title, description, author, created) VALUES('$title', '$description', '$author', now())";
  mysqli_query($conn, $sql_topic);

// 홈 페이지로 리다이렉트한다.
  header('Location: /index.php');
?>
