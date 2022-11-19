<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="style.css">
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Send Money</title>
  <!-- font -->
  <link href="https://fonts.googleapis.com/css2?family=Ubuntu&display=swap" rel="stylesheet" />
  <link rel="shortcut icon" href="img/logo.png" type="image/x-icon">
  <!-- styling -->
  <style>
    <?php include 'style.css'; ?>
  </style>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
</head>

<body>
  <?php include 'config.php'; ?>
  <div id="lock"><br>
    <p style="color:black; margin-top: 25px;" class="lock"><b>Please rotate the device. </b><br>We support only landscape mode.<br>We recommend users to use the site on laptop/desktop.</p>
  </div>
  <nav class="navbar bg-dark navbar-expand-lg navbar-dark sticky-top">
    <a class="navbar-brand title" href="index.php">GOLDEN <span class="s1">HORIZON</span> BANK</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="customers.php">Money Transfer</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="transaction.php">Transaction History</a>
        </li>

      </ul>
    </div>
  </nav>
  <div class="main2">
    <div class="lds-spinner">
      <div></div>
      <div></div>
      <div></div>
      <div></div>
      <div></div>
      <div></div>
      <div></div>
      <div></div>
      <div></div>
      <div></div>
      <div></div>
      <div></div>
    </div>
  </div>

  <section class="send">
    <div class="signup-form">
      <form action="transfer.php" method="post" class="form-horizontal">
        <div class="row">
          <div class="col-8 offset-4">
            <h2>ENTER DETAILS</h2>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-form-label col-4">FROM</label>
          <div class="col-8">
            <input type="text" class="formin form-control" name="accno1" id="" placeholder="Sender's Account Number" value="<?php if (isset($_GET['reads'])) {
                                                                                                                              echo $_GET['reads'];
                                                                                                                            } ?>">
          </div>
        </div>
        <div class="form-group row">
          <label class="col-form-label col-4">TO</label>
          <div class="col-8">
            <input type="text" class="form-control" name="accno2" required="required" placeholder="Reciever account number">
          </div>
        </div>
        <div class="form-group row">
          <label class="col-form-label col-4">AMOUNT</label>
          <div class="col-8">
            <input type="number" class="form-control" name="amount" required="required" placeholder="Transfer amount">
          </div>
        </div>

        <div class="form-group row">
          <div class="col-8 offset-4">

            <button type="submit" class="btn btn-primary btn-lg" value="Transfer">Proceed</button>
          </div>
        </div>
      </form>
      <div class="text-center c">Back to home <a href="index.php" class="here"> Click here</a></div>

    </div>
  </section>




  <?php

  $conn = mysqli_connect($servername, $username, $password, $database);
  if (!$conn) {
    die("Connection not established: " . mysqli_connect_error());
  } else {

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {


      $sender = $_POST['accno1'];
      $amount = $_POST['amount'];
      $reciever = $_POST['accno2'];


      $checkblcquery = "SELECT blc FROM users where accno='$sender'";
      $checkblc = mysqli_query($conn, $checkblcquery);
      $ava_blc = mysqli_fetch_assoc($checkblc)['blc'];

      if ($ava_blc >= $amount) {

        $sql1 = "UPDATE users SET blc= blc-$amount WHERE accno='$sender'";
        $sql2 = "UPDATE users SET blc= blc+$amount WHERE accno='$reciever'";
        $result1 = mysqli_query($conn, $sql1);
        $result2 = mysqli_query($conn, $sql2);
        if ($result1 && $result2) {
          echo  '<script>alert("Amount transfered successfully")</script>';
          $sqltran = "INSERT INTO `transactions` (`sender`, `receiver`, `amount`, `status`) VALUES ('$sender', '$reciever', '$amount', 'succeed')";
          $sqltransact = mysqli_query($conn, $sqltran);
        } else {
          echo  '<script>alert("Something went wrong")</script>';
          $sqltran = "INSERT INTO `transactions` (`sender`, `receiver`, `amount`, `status`) VALUES ('$sender', '$reciever', '$amount', 'failed')";
          $sqltransact = mysqli_query($conn, $sqltran);
        }
      } else {
        echo  '<script>alert("Not Suffcient  Balance in Account")</script>';;
        $sqltran = "INSERT INTO `transactions` (`sender`, `receiver`, `amount`, `status`) VALUES ('$sender', '$reciever', '$amount', 'failed')";
        $sqltransact = mysqli_query($conn, $sqltran);
      }
    }
  }
  ?>

  <div>
    <footer class="footer-08" id="contactUs" data-aos="fade-down">
      <div class="container-fluid px-lg-5">
        <div class="row">
          <div class="col-md-9 py-5">
            <div class="row">
              <div class="col-md-4 mb-md-0 mb-4">
                <p style="margin-top:20px">2022 &copy; Made with &hearts; By Muhammed Rebin</p>
                <ul class="about">
                  <li><a href="https://twitter.com/____bhargav___"><i class="bi bi-twitter"></i></a></li>&emsp;
                  <li><a href="https://www.linkedin.com/in/bhargav-garge-81b619234/?originalSubdomain=in"><i class="bi bi-linkedin"></i></a></li>
                </ul>
                <ul class="ftco-footer-social p-0">
                  <li class="ftco-animate"><a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="Twitter"><span class="ion-logo-twitter"></span></a></li>
                  <li class="ftco-animate"><a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="Facebook"><span class="ion-logo-facebook"></span></a></li>
                  <li class="ftco-animate"><a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="Instagram"><span class="ion-logo-instagram"></span></a></li>
                </ul>
              </div>
            </div>
            <div class="row mt-md-5">
              <div class="col-md-12">
              </div>
            </div>
          </div>
        </div>
      </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script>
      const loader = document.querySelector(".main2");
      const main = document.querySelector(".super");
      function hide() {
        loader.style.display = "none";
      }

      function show() {
        main.classList.toggle('done');
      }
      window.addEventListener("load", () => {
        setTimeout(hide, 1500);
        setTimeout(show, 1500);
      })
    </script>
</body>
</html>