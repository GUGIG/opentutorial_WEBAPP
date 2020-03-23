<?php
  require_once("config/config.php");
  require_once("lib/db.php");
  $conn = db_init($config["host"], $config["duser"], $config["dpw"], $config["dname"]);
  $result = mysqli_query($conn, "SELECT * FROM topic"); // $result holds the whole table of 'topic'.
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA_Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags-->
  <title>index</title>

  <link rel="stylesheet" type="text/css" href="/css/style.css">
  <!-- Bootstrap -->
  <link href="/bootstrap-3.3.4-dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="/javascript/buttonFunctions.js"></script>
</head>
<body id="target"> <!-- id="target" style="padding:1%;"-->
  <div class="container"> <!-- try "container-fluid"! it's cool -->
    <header class="text-center jumbotron"> <!-- class="row" -->
      <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcSBedi4XSOJQFY-RSrdvhaohUPzLy1LPfKkgfB6sTIwyJ_QdMWR" alt="생활코딩" id="logo" class="img-circle"/> <!-- class="col-md-1"   https://s3.ap-northeast-2.amazonaws.com/opentutorials-user-file/course/94.png-->
      <h1><a href="/index.php">:P</a></h1> <!--  class="col-md-11" -->
    </header>

    <div class="row"> <!-- row below header -->
      <nav class="col-md-3" id="navigation">
        <ol class="nav nav-pills nav-stacked">
          <?php
          while($row = mysqli_fetch_assoc($result)) { // 쿼리로 받은 테이블을 연관배열 형식으로 받는다..? 이런거임.
            echo '<li><a href="/index.php?id='.$row['id'].'">'.htmlspecialchars($row['title']).'</a></li>'."\n"; // 'title'은 <script>같은 걸로 사용자가 스크립트공격을 할 수 있으므로 htmlspecialchars 사용.
          }
          ?>
        </ol>
      </nav> <!-- col-md-3 -->
      <article class="col-md-7" id="main">
        <?php
        $id = mysqli_real_escape_string( $conn, $_GET[ 'id' ] ) ; // id에 쿼리문을 집어넣던가 하는 것을 막기 위해 escape 한다.
        if( !empty( $id ) ) { // $id => $_GET['id']였음.
          //$sql = 'SELECT topic.description, topic.author FROM topic WHERE id='.$id; // $sql -> sql 쿼리 string으로 갖고있음.
          $sql = 'SELECT topic.id, topic.title, topic.description, user.name, topic.created FROM topic LEFT JOIN user ON topic.author = user.id WHERE topic.id = '.$id;
          $result = mysqli_query( $conn, $sql ); // $result -> 위에서 정의한 SELECT쿼리를 날려서 받은 결과를 갖고있음.
          $row = mysqli_fetch_assoc( $result ); // $row -> $result의 어떤 한 행을 갖고있음.

          echo '<h2>'.htmlspecialchars( $row[ 'title' ] ).'</h2>'; //
          $allowedTags = '<a><h1><h2><h3><ul><ol><li><img>';
          echo strip_tags( $row[ 'description' ], $allowedTags ); // '<a><h1><h2><h3><ul><ol><li>'  $allowedTags
          echo '<br><br> Written by - '.htmlspecialchars( $row[ 'name' ] ).' -<br>';
          echo file_get_contents( "./lib/disqusComment.txt" ); // disqus Comment code.
        } else {
          echo '<h2>홈 페이지 입니다.</h2>';
        }
        ?>
      </article> <!-- col-md-7 -->

      <div class="col-md-2" id="buttons"> <!-- previous class="buttons" -->
        <div class="btn-group">
          <input type="button" value="white" onclick="white()" class="btn btn-default btn-sm">
          <input type="button" value="black" onclick="black()" class="btn btn-default btn-sm">
        </div>
        <a href="/write.php" class="btn btn-success btn-sm">쓰기</a>
      </div> <!-- col-md-2 -->
    </div> <!-- end of row div -->

  </div>


  <!--Start of Tawk.to Script-->
  <script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
      var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
      s1.async=true;
      s1.src='https://embed.tawk.to/5e579d39a89cda5a18883745/default';
      s1.charset='UTF-8';
      s1.setAttribute('crossorigin','*');
      s0.parentNode.insertBefore(s1,s0);
    })();
  </script>
  <!--End of Tawk.to Script-->

  <!-- jQuery (necessary for Bootstrap's Javascript plugins)-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include indivisual files as needed -->
  <script src="/bootstrap-3.3.4-dist/js/bootstrap.min.js"></script>
</body>
</html>
