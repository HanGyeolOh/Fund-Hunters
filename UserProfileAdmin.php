<!-- User Profile Admin Page -->
<html>
<head>
<title>Admin User Profile</title>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width = device-width, initial-scale = 1">
<title>User Profile Admin Page</title>
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

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
.thumbnail {
    border:0;
    padding: 10px;
}
.text-description {
  line-height: 2.5ex;
  height: 10ex; /* 2.5ex for each visible line */
  overflow: hidden;
}
.black-font{
  color: #000000;
}
.project-img{
  height:180px;
  max-width:340px;
}
.thumbnail{
  height:400px;
  width:350px;
  margin-left: 40px;
}
.my-footer{
  position: absolute;
  width:100%;
  bottom:15;
  height:40px;
}
.text-narrow{
  font-size:12px;
  line-height: 0.5;
}
.text-title{
  font-size:16px;
  line-height: 1.2;
  font-weight: bold;
}
.text-strong{
  font-weight: bold;
  font-size:12.5px;
  line-height: 0.5;
}
.progress{
  height:10px;
  margin-bottom:4px;
  width:340px;
}
</style>
</head>

<body>

  <?php
      session_start();
      require('dbconn.php');

      $email = $_SESSION['username'];
      $query = "SELECT * FROM users WHERE email = '$email';";
      $result = pg_query($dbconn, $query);
      if(pg_num_rows($result) == 1) {
        $name = pg_fetch_result($result, 0, 0);
        $dob = pg_fetch_result($result, 0, 2);
        $address = pg_fetch_result($result, 0, 3);
        $image_url = pg_fetch_result($result, 0, 5);
      }
      else {
        die('Error fetching the user profile data. username: '.$_SESSION['username']);
      }
  ?>

<?php
  require('NavigationBar.php');
?>

<!-- User Profile -->
<div class="container">

  <div class="row jumbotron">

    <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
      <!-- Profile Picture Thumbnail -->
      <?php
        echo "<img src='$image_url' id='profilepic' class='img-thumbnail pull-left' width='200' height='300'>";
      ?>
    </div>

    <!-- Profile Info Table -->
    <div class="col-lg-7 col-md-7 col-sm-6 col-xs-12">
      <p>
        <?php echo '<h2 class="text-primary">'.$name.'</h2>'; ?>
      </p>
      <p>
        <span class="glyphicon glyphicon-envelope"></span>
        <?php echo $email; ?>
      </p>
      <p>
        <span class="glyphicon glyphicon-calendar"></span>
        <?php echo $dob; ?>
      </p>
      <p>
        <span class="glyphicon glyphicon-home"></span>
        <?php echo $address; ?>
      </p>
    </div>

    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
      <a role="button" class="btn-warning btn btn-lg pull-center" href="EditUserProfile.php" style="margin-top:25px; margin-bottom:25px;">Edit Profile Details</a>
      <a role="button" class="btn-danger btn btn-lg pull-center" data-toggle="modal" data-target="#modal-1" style="margin-top:25px; margin-bottom:25px;">Delete Account</a>
      <?php
        require('DeleteUserPopup.php');
      ?>
    </div>
  </div>

<?php
    $query = "SELECT * FROM thumbnail_info WHERE publisher_email = '$email'";
    $result = pg_query($dbconn, $query) or die('Query failed: ' . pg_last_error());
    $date_today = date("Ymd");
    if (pg_num_rows($result) > 0) {
      echo "
        <div class='page-header'>
          <h1><small>Projects Created</small></h1>
        </div>

        <div class='row'>
          <ul class='list-group'>";

          while ($row = pg_fetch_row($result)) {
            $title = $row[0];
            $description = $row[1];
            $id = $row[2];
            $logo_url = $row[3];
            $owner_name = $row[4];
            $start_date = $row[5];
            $end_date = $row[6];
            $target_amount = number_format($row[7]);
            $current_amount = number_format($row[8]);
            $publisher_email = $row[9];

            $current_date = date("Y/m/d");

            $days_left = ceil(abs(strtotime($end_date) - strtotime($current_date)) / 86400);
            $progress = round ( (((float)((int)$row[8] / (int)$row[7])) * 100), 0);

            $query = "SELECT COUNT(*)
                FROM projects p, investments i
                WHERE p.project_id = i.project_id AND p.project_id = '$id'";
            $result_two = pg_query($dbconn, $query) or die('Query failed: ' . pg_last_error());
            $num_investor = pg_fetch_result($result_two, 0, 0);
             echo "
        <div class='thumbnail col-lg-3 col-md-3 col-sm-4 col-xs-6'>
          <div>
            <a href='ProjectProfile.php?id=$id'>
            <img class= 'img-rounded btn center-block' src='$logo_url' style='height:180px; max-width:340px;'></a>
          </div>
          <div class='caption'>
            <p><a class='text-title black-font' href='ProjectProfile.php?id=$id'>$title</a></p>
            <p>
              <a class='text-title black-font'>by</a>
              <a class='text-title black-font' href='UserProfile.php?email=$publisher_email'>$owner_name</a>
            </p>
            <p class='text-justify'>$description</p>
            <div>
              <a role='button' class='btn-info btn' href='ProjectProfileAdmin.php?id=$id' style='margin-left:10px;'>Project Summary</a>
              <a role='button' class='btn-warning btn pull-right' href='EditProjectProfile.php?id=$id' style='margin-left:10px;'>Edit Project</a>
            </div>
          </div>";
        if(strtotime($date_today) > strtotime($end_date)) { //Time elapsed case
          echo "
          <div class='my-footer-past'><hr>
            <div class='caption'>
              <div class='col-lg-9'>
                <p class='text-strong'>$$current_amount</p>
                <p class='text-narrow'>invested of $$target_amount target</p>
              </div>
              <div class='col-lg-3'>
                <p class='text-strong'>$num_investor</p>
                <p class='text-narrow'>investors</p>
              </div>
            </div>
          </div>
        </div>";
          } else {  //Still funding case
            echo "
            <div class='my-footer'>
              <div class='progress'>";
            if ($progress >= 100) {
              echo "
                  <div class='progress-bar progress-bar-success' role='progressbar' aria-valuenow=$progress aria-valuemin='0' aria-valuemax='100' style='width: $progress%'></div>";
              } else {
                echo "
                  <div class='progress-bar' role='progressbar' aria-valuenow=$progress aria-valuemin='0' aria-valuemax='100' style='width: $progress%'></div>";
              }
              echo"
                </div>
              <div class='caption'>
                <div class='col-lg-4'>
                  <p class='text-strong'>$progress %</p>
                  <p class='text-narrow'>funded</p>
                </div>
                <div class='col-lg-4'>
                <p class='text-strong'>$$current_amount</p>
                <p class='text-narrow'>invested</p>
              </div>
                <div class='col-lg-4'>
                  <p class='text-strong'>$days_left</p>
                  <p class='text-narrow'>days to go</p>
                </div>
              </div>
            </div>
          </div>";
          }
        }
      echo "
        </ul>
      </div>";
    }
  ?>

  <?php
    $query = "SELECT * FROM thumbnail_info
                  WHERE project_id IN (SELECT project_id FROM investments WHERE investor_email = '$email')";
    $result = pg_query($dbconn, $query) or die('Query failed: ' . pg_last_error());
    $date_today = date("Ymd");
    if (pg_num_rows($result) > 0) {
      echo "
        <div class='page-header'>
          <h1><small>Projects Backed</small></h1>
        </div>

        <div class='row'>
          <ul class='list-group'>";

          while ($row = pg_fetch_row($result)) {
            $title = $row[0];
            $description = $row[1];
            $id = $row[2];
            $logo_url = $row[3];
            $owner_name = $row[4];
            $start_date = $row[5];
            $end_date = $row[6];
            $target_amount = number_format($row[7]);
            $current_amount = number_format($row[8]);
            $publisher_email = $row[9];

            $current_date = date("Y/m/d");

            $days_left = ceil(abs(strtotime($end_date) - strtotime($current_date)) / 86400);
            $progress = round ( (((float)((int)$row[8] / (int)$row[7])) * 100), 0);

            $query = "SELECT COUNT(*)
                FROM projects p, investments i
                WHERE p.project_id = i.project_id AND p.project_id = '$id'";
            $result_two = pg_query($dbconn, $query) or die('Query failed: ' . pg_last_error());
            $num_investor = pg_fetch_result($result_two, 0, 0);
             echo "
        <div class='thumbnail col-lg-3 col-md-3 col-sm-4 col-xs-6'>
          <div>
            <a href='ProjectProfile.php?id=$id'>
            <img class= 'img-rounded btn center-block' src='$logo_url' style='height:180px; max-width:340px;'></a>
          </div>
          <div class='caption'>
            <p><a class='text-title black-font' href='ProjectProfile.php?id=$id'>$title</a></p>
            <p>
              <a class='text-title black-font'>by</a>
              <a class='text-title black-font' href='UserProfile.php?email=$publisher_email'>$owner_name</a>
            </p>
            <p class='text-justify'>$description</p>
          </div>";
        if(strtotime($date_today) > strtotime($end_date)) { //Time elapsed case
          echo "
          <div class='my-footer-past'><hr>
            <div class='caption'>
              <div class='col-lg-9'>
                <p class='text-strong'>$$current_amount</p>
                <p class='text-narrow'>invested of $$target_amount target</p>
              </div>
              <div class='col-lg-3'>
                <p class='text-strong'>$num_investor</p>
                <p class='text-narrow'>investors</p>
              </div>
            </div>
          </div>
        </div>";
          } else {  //Still funding case
            echo "
            <div class='my-footer'>
              <div class='progress'>";
            if ($progress >= 100) {
              echo "
                  <div class='progress-bar progress-bar-success' role='progressbar' aria-valuenow=$progress aria-valuemin='0' aria-valuemax='100' style='width: $progress%'></div>";
              } else {
                echo "
                  <div class='progress-bar' role='progressbar' aria-valuenow=$progress aria-valuemin='0' aria-valuemax='100' style='width: $progress%'></div>";
              }
              echo"
                </div>
              <div class='caption'>
                <div class='col-lg-4'>
                  <p class='text-strong'>$progress %</p>
                  <p class='text-narrow'>funded</p>
                </div>
                <div class='col-lg-4'>
                <p class='text-strong'>$$current_amount</p>
                <p class='text-narrow'>invested</p>
              </div>
                <div class='col-lg-4'>
                  <p class='text-strong'>$days_left</p>
                  <p class='text-narrow'>days to go</p>
                </div>
              </div>
            </div>
          </div>";
          }
        }
      echo "
        </ul>
      </div>";
    }
  ?>

</div>


<?php
  pg_close($dbconn);
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>
