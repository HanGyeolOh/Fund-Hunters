<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width = device-width, initial-scale = 1">

  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <link rel="stylesheet" href="bootstrap.min.css">
  <link href="css/bootstrap-imgupload.css" rel="stylesheet">

  <style>
  .jumbotron{
    background-color:#2C3539;
    color:white;
  }
  /* Adds borders for tabs */
  .tab-content {
    border-left: 1px solid #ddd;
    border-right: 1px solid #ddd;
    border-bottom: 1px solid #ddd;
    padding: 10px;
  }
  .nav-tabs {
    margin-bottom: 0;
  }
  .col-centered{
    float: none;
    margin: 0 auto;
  }
  .carousel{
    background: #2f4357;
    margin-top: 20px;
  }
  .carousel .item img{
    margin: 0 auto; /* Align slide image horizontally center */
  }
  .bs-example{
    margin: 20px;
  }
  .carousel-inner > .item > img {
    width:640px;
    height:360px;
  }
  </style>
</head>

<body>
  <?php
      require('dbconn.php');
  ?>
  <?php
      require('NavigationBar.php');
  ?>

  <form action="ProjectCreationForm.php" method="post" enctype="multipart/form-data" name="form">
  <div class="container">
    <div class="container">
      <h2 style="padding-left:0px" color="black">Project Creation</h2>
      <h4 style="padding-left:0px">Please input your Project's information below!</h4>
    </div>
    <div class="jumbotron">
      <br>
      <div class="container">
        <div class="form-group row">
          <label for="example-text-input" class="col-2 col-form-label">Project Title</label>
          <div class="col-10">
            <input class="form-control" type="text" id="example-text-input" name="title" required/>
          </div>
        </div>
        <div class="form-group row">
          <label for="example-email-input" class="col-2 col-form-label">Target Amount</label>
          <div class="col-10">
            <input class="form-control" type="number" id="example-email-input" name="target_amount" required/>
          </div>
        </div>
        <div class="form-group row">
          <label for="example-date-input" class="col-2 col-form-label">Start Date</label>
          <div class="col-10">
            <input class="form-control" type="date" value="2011-01-01" id="example-date-input" name="start_date" required/>
          </div>
        </div>
        <div class="form-group row">
          <label for="example-date-input" class="col-2 col-form-label">End Date</label>
          <div class="col-10">
            <input class="form-control" type="date" value="2011-01-01" id="example-date-input" name="end_date" required/>
          </div>
        </div>
        <div class="form-group row">
          <label for="example-text-input" class="col-2 col-form-label">Brief Description</label>
          <div class="col-10">
            <input class="form-control" type="text" id="example-text-input" name="description" required/>
          </div>
        </div>
        <div class="form-group row">
          <label for="example-text-input" class="col-2 col-form-label">Category</label>
          <div class="col-10">
            <select class="form-control" type="text" id="example-text-input" name="category" required/>
              <option>Technology</option>
              <option>Arts</option>
            </select>
          </div>
        </div>

        <input type="submit" name="submit" value="Submit" class="btn btn-default" id="SubmitButton" align="right"/>

        <div class="container">
              <div class="container">
                <div style="max-width: 650px; margin: auto;">
                  <h2 class="page-header">Project Image Upload</h2>
                  <p class="lead">Select a PNG or JPEG image, having maximum size <span id="max-size"></span> KB.</p>
                </div>
                <div class="form-group" align="center">
                  <input type="file" name="file" id="file" required/>
                </div>
              </div>
          </div>
      </div>
    </div>
  </div>
</form>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  <script src="//code.jquery.com/jquery-1.12.2.min.js"></script>
  <script src="js/bootstrap-imgupload.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
</body>
</html>