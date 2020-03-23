<!-- write.php -->

<?php
  require("config/config.php");
  require("lib/db.php");
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

  <script>
  UPLOADCARE_PUBLIC_KEY = 'e45197d57d41484dfd15';
  UPLOADCARE_LOCALE = 'ko';
  UPLOADCARE_EFFECTS = 'crop';
  UPLOADCARE_PREVIEW_STEP = true;
  UPLOADCARE_CLEARABLE = true;
  </script>

  <script src="https://ucarecdn.com/libs/widget/3.x/uploadcare.full.min.js"></script>
  <script src="https://ucarecdn.com/libs/widget-tab-effects/1.x/uploadcare.tab-effects.js"></script>

  <script>
    uploadcare.registerTab('preview', uploadcareTabEffects)
  </script>

  <style>
  .uploader-button .uploadcare--widget__button_type_open {
    background-color: #efab5b;
  }
  </style>

  <script>
    UPLOADCARE_LOCALE_TRANSLATIONS = {
      buttons: {
        choose: {
          files: {
            one: 'Upload image'
          }
        }
      }
    }
  </script>
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
        <form action="/process.php" method="post">

          <div class="form-group">
            <label for="form-title">제목</label>
            <input type="text" class="form-control" placeholder="제목" name="title" id="form-title">
          </div>

          <div class="form-group">
            <label for="form-name">작성자</label>
            <input type="text" class="form-control" placeholder="작성자 이름을 적어주세요" name="name" id="form-name"> <!-- name="author"이었음. -->
          </div>

          <div class="form-group">
            <label for="form-password">비밀번호</label>
            <input type="text" class="form-control" placeholder="작성자 비밀번호를 적어주세요" name="password" id="form-password"> <!-- name="author"이었음. -->
          </div>

          <div class="form-group">
            <label for="">본문</label>
            <textarea rows="8" class="form-control" placeholder="form-description" name="description" id="form-description">얍</textarea>
          </div>

          <span class="uploader-button">
            <input
              type="hidden"
              role="uploadcare-uploader"
              data-tabs="file camera facebook instagram dropbox gdrive gphotos onedrive evernote"
              data-crop="free, 1024x768 upscale" />
          </span>

          <input type="submit" class="btn btn-success">
        </form>
      </article> <!-- col-md-7 -->

      <script type="text/javascript">
        var singleWidget = uploadcare.SingleWidget('[role=uploadcare-uploader]');
        singleWidget.onUploadComplete(function(info) {
          document.getElementById('form-description').value += '<img src="' + info.cdnUrl + '" />';
        });
      </script>

      <div class="col-md-2" id="buttons"> <!-- previous class="buttons" -->
        <div class="btn-group">
          <input type="button" value="white" onclick="white()" class="btn btn-default btn-sm">
          <input type="button" value="black" onclick="black()" class="btn btn-default btn-sm">
        </div>
        <a href="/write.php" class="btn btn-success btn-sm">쓰기</a>
      </div> <!-- col-md-2 -->
    </div> <!-- end of row div -->

  </div> <!-- end of container div -->

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
