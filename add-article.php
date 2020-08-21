<?php

require_once('backend/index.php');

session_start();

if(!isset($_SESSION['covid_app_user']) || $_SESSION['covid_app_user'] != 'admin'){
  header("Location: login.php?redirect=add-article.php");
}

if(isset($_GET['id'])){
  $query = "select * from blog where blog_id=?;";

  if($stmt = $con->prepare($query)){
    $stmt->bind_param("s",$_GET['id']);

    if($stmt->execute()){
      $result = $stmt->get_result();

      if(mysqli_num_rows($result) == 1){
        $row = $result->fetch_assoc();
      }
    }
  }
}

?>
<!Doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <title>Add article</title>

    <style type="text/css">
      .sample-toolbar{
        border: solid 1px #ddd;
        background: #f4f4f4;
        padding: 5px;
        border-radius: 3px;
      }

      .sample-toolbar > span{
        cursor: pointer;
      }

      .sample-toolbar > span:hover{
        text-decoration: underline;
      }

      .editor{
        border:solid 1px #ccc;
        padding: 20px;
        min-height:200px;
      }

      .fa{
        color: black;
      }
      
    </style>
    <link rel="stylesheet" href="css/font-awesome.min.css">
  </head>
  <body class="bg-light">
    <div class="container-fluid bg-primary" style="display: flex; justify-content: space-between;">
      <div>
        <h3 style="color: white; margin-top: 5px;">Covidbeds.org</h3>
      </div>
      <div style="display: flex; margin-top: 10px;">
        <a style="color: white; padding-right: 20px;" href="admin-home.php">Home</a>
        <p id="logout_btn" style="color: white;" onclick="logout()">Logout</p>
      </div>
    </div>

    <div class="container" style="background: white; margin-top: 20px;">

      <center><h1>Add new article</h1></center>

      <form>
        <div class="row">
          <div class="col-md-6">
            <label for="title">Title</label>
            <input id="title" type="text" class="form-control" placeholder="Article title" value="<? if(isset($_GET['id'])) echo $row['blog_title'];?>">
          </div>
          <div class="col-md-6">
            <label for="slug">Slug</label>
            <input id="slug" type="text" class="form-control" placeholder="article-name" value="<? if(isset($_GET['id'])) echo $row['blog_slug'];?>">
          </div>
          <div class="col-md-6" style="margin-top: 10px;">
            <label for="author">Author name</label>
            <input id="author" type="text" class="form-control" placeholder="Author name" value="<? if(isset($_GET['id'])) echo $row['blog_author'];?>">
          </div>
          <div class="col-md-6" style="margin-top: 10px;">
            <label for="date">Published on</label>
            <input id="date" type="datetime-local" class="form-control" placeholder="Publish date" value="<? if(isset($_GET['id'])) echo substr(date_format(date_create($row['blog_date']), DATE_ISO8601), 0, 19)?>">
          </div>
          <div class="col-md-6" style="margin-top: 20px; padding-left: 20px;">
            <input type="file" class="custom-file-input" id="customFile">
            <label class="custom-file-label" for="customFile" style="margin-left: 20px;">Featured image</label>
            <?
              if(isset($_GET['id'])){
                echo '<img src="'.$row['blog_img'].'" style="margin-top: 20px; width: 100%;">';
              }
            ?>
          </div>
        </div>
      </form>

      <br>

      <small>content</small>
      <div class="sample-toolbar">
        <a href="javascript:void(0)" onclick="format('bold')"><span class="fa fa-bold fa-fw"></span></a>
        <a href="javascript:void(0)" onclick="format('italic')"><span class="fa fa-italic fa-fw"></span></a>
        <a href="javascript:void(0)" onclick="format('underline')"><span class="fa fa-underline fa-fw"></span></a>
        <a href="javascript:void(0)" onclick="format('strikethrough')"><span class="fa fa-strikethrough fa-fw"></span></a>
        <a href="javascript:void(0)" onclick="changeFontSize('dec')"><span class="fa fa-font fa-fw"></span><span class="fa fa-sort-desc fa-fw" style="margin-left: -5px; font-size: 14px; margin-top: -5px"></span></a>
        <a href="javascript:void(0)" onclick="changeFontSize('inc')"><span class="fa fa-font fa-fw"></span><span class="fa fa-sort-up fa-fw" style="margin-left: -5px; font-size: 14px;"></span></a>
        <input type="color" id="myColor" style="width: 30px;">
        <input type="color" id="backColor" style="width: 30px;">
        <span style="color: grey;">|</span>
        <a href="javascript:void(0)" onclick="format('justifyLeft')"><span class="fa fa-align-left fa-fw"></span></a>
        <a href="javascript:void(0)" onclick="format('justifyCenter')"><span class="fa fa-align-center fa-fw"></span></a>
        <a href="javascript:void(0)" onclick="format('justifyRight')"><span class="fa fa-align-right fa-fw"></span></a>
        <a href="javascript:void(0)" onclick="format('justifyFull')"><span class="fa fa-align-justify fa-fw"></span></a>
        <span style="color: grey;">|</span>
        <a href="javascript:void(0)" onclick="format('insertunorderedlist')"><span class="fa fa-list fa-fw"></span></a>
        <a href="javascript:void(0)" onclick="format('insertorderedlist')"><span class="fa fa-list-ol fa-fw"></span></a>
        <span style="color: grey;">|</span>
        <a href="javascript:void(0)" onclick="document.getElementById('addImg').click()"><span class="fa fa-file-image-o fa-fw"></span></a>
        <a href="javascript:void(0)" onclick="setUrl()"><span class="fa fa-link fa-fw"></span></a>
        <span><input id="txtFormatUrl" placeholder="url" class="form-control"></span>
      </div>
      <input id="addImg" type="file" style="display: none;">

      <div class="editor" id="sampleeditor">
        <?
          if(isset($_GET['id'])){
            echo $row['blog_content'];
          }
        ?>
      </div>

      <center>
        <button id="submitBtn" class="btn btn-primary" style="width: 50%; margin-top: 20px; margin-bottom: 20px;">Submit</button>
      </center>

    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

    <script>

      let fontSize = 3;
      let featImgData = '';

      let id = <? if(isset($_GET['id'])) echo $_GET['id']; else echo -1;?>

      $(document).ready(function(){
        $("#customFile").change(function(event){
          $(".custom-file-label").html(($(this).val()));

          if (event.target.files && event.target.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
              featImgData = e.target.result;
            }

            reader.readAsDataURL(event.target.files[0]);
          }
        })

        $("#myColor").change(function(){
          setColor('foreColor', $(this).val());
        })

        $("#backColor").change(function(){
          setColor('hiliteColor', $(this).val());
        })

        $("#addImg").change(function(event){

          if (event.target.files && event.target.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
              document.execCommand('insertHTML', false, '<img style="width: 80%" src="'+e.target.result+'">');
            }

            reader.readAsDataURL(event.target.files[0]);
          }
        });


        $("#submitBtn").click(function(){
          if(featImgData == ''){
            featImgData = <? echo "'".$row['blog_img']."'";?>
          }

          let data1 = {
            add_blog: 1,
            title: $("#title").val(),
            slug: $("#slug").val(),
            author: $("#author").val(),
            date: $("#date").val(),
            img: featImgData,
            content: $("#sampleeditor").html()
          };

          if(id != -1){
            data1['blog_id'] = id;
          }

          $.ajax({
            url: 'backend/index.php',
            method: 'post',
            data: data1,
            beforeSend: function() {
              $("#submitBtn").html(`<div class="spinner-border text-white" role="status">
                                        <span class="sr-only">Loading...</span>
                                      </div>`).attr('disabled', 'true');
            },
            success: function(data){
              console.log(data);

              $("#submitBtn").html('Submit').removeAttr('disabled');

              data = JSON.parse(data);

              if(data.response == 'success'){
                window.location.href = './blog/' + $("#slug").val() + '.php';
              }
              else{
                alert('Something went wrong');
              }
            }, 
            error: function(data){
              $("#submitBtn").html('Submit').removeAttr('disabled');
              alert('Something went wrong');
            }
          })
        })

      });


      window.addEventListener('load', function(){
        document.getElementById('sampleeditor').setAttribute('contenteditable', 'true');
        document.getElementById('sampleeditor2').setAttribute('contenteditable', 'true');
        document.execCommand('enableObjectResizing', false);
      });

      function format(command, value) {
        document.execCommand(command, false, value);
      }

      function setUrl() {
        var url = document.getElementById('txtFormatUrl').value;
        var sText = document.getSelection();
        document.execCommand('insertHTML', false, '<a href="' + url + '" target="_blank">' + sText + '</a>');
        document.getElementById('txtFormatUrl').value = '';
      }

      function changeFontSize(dir) {
        if(dir == 'inc'){
          fontSize += 1;
        }
        else{
          fontSize -= 1;
        }

        console.log(fontSize);

        document.execCommand('styleWithCSS', false, true);
        document.execCommand('fontSize', false, fontSize);
      }

      function setColor(type, color) {
        document.execCommand('styleWithCSS', false, true);
        document.execCommand(type, false, color);
      }
    </script>

  </body>
</html>
