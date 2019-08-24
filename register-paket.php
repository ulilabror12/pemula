<?php
session_start();
require_once'backend.php';
if(isset($_SESSION['user']))
 {
  $userdata=$_SESSION['user'];
  if(isset($_POST['button']))
   {
    $select= $_POST['paket'];
    $idpaket=$_POST['idpaket'];
    if($idpaket==null)
      {
       switch($select)
           {
              case 1: $id= "oAXnTn6%2Bzg2bDMCRA3nqG9MTiRDKkIATItRa2DqEAlUAwG0Yt5opkINqDniVzHz6uKunkGnGfj6sGoTyVo9qiQ%3D%3D";
              break;
              case 2: $id= "00007229";
              break;
      //      case 3: $id= "00010768";
      //      break;
           };
      }
     else
      { 
         $id= $_POST['idpaket'];
      }    
                   
         $ubuy='https://subscription-service.apps.dp.xl.co.id/v1/package/subscribev3';
         $dbuy=[
                  'msisdn'=>$userdata[0]['result']['user']['msisdn_enc'],
                  'serviceId'=>$id
               ];
         $dbuy=json_encode($dbuy);
         $hbuy=[
                 'origin: http://localhost:9634',
                 'x-apicache-bypass: true',
                 'authorization: Bearer '.$userdata[0]['result']['accessToken'],
                 'content-type: application/json',
                 'accept: application/json, text/plain, */*',
                 'cache-control: no-cache',
                 'user-agent: Mozilla/5.0 (Linux; Android 7.1.2; Redmi Note 5A Build/N2G47H; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/74.0.3729.157 Mobile Safari/537.36',
                 'referer: http://localhost:9634/thankyou',
               //'accept-encoding: gzip, deflate',
                 'accept-language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7',
                 'x-requested-with: id.co.xl.myXL'
                ];
         $rbuy=request($ubuy,$dbuy,$hbuy,null); 
         $rescode=json_decode($rbuy,true);
         $rescode=$rescode['statusCode'];
         if($rescode=='200')
              {
                 $msg='success';
              }
         else
             {
               $msg='response code '.$rescode;
             }
      }
 }
else
 {
   header("location: index.php")
 ;}
          
;?><!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="dor-kan">
  <meta name="author" content="dor-kan">

  <title>Register Paket</title>
  

  <!-- Custom fonts for this template-->
  <link rel="icon" href="icon.png">
  <link href="/assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="/assets/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

  <div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5 col-lg-7 mx-auto">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg">
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Beli Paket</h1>
              </div>
              <form class="user"method="post"action="">
               <div class="form-group row">.
               <div class="col-sm-6 mb-3 mb-sm-0">
                 <select name="paket" class="custom-select custom-select-lg mb-3">
                   <option disabled>Kuota Aplikasi</option>
                   <option value="1"<?php if(isset($_POST["button"])){if($select==1){echo"selected";};};?>>Chat 150MB ,7.5k,7hr</option>
                  <!-- <option value="2"<?php if(isset($_POST["button"])){if($select==2){echo"selected";};};?>>MAXstream 7GB ,7k,3hr</option>
                   <option disabled>Kuota flash + aplikasi</option>
                    <option value="3"<?php if(isset($_POST["button"])){if($select==3){echo"selected";};};?>>1GB(200MB+800MB kuota Instagram) perhari,50K,30hr</option>-->
                   </select>
                </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" class="form-control form-control-user" name="idpaket" placeholder="Id paket( jika punya)">
                  </div>
                 </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="submit" class="btn btn-primary btn-user btn-block" name="button"value="buy">
                  </div>
                </div>
                <div class="form-group row">
                 <div class="col-sm-6 mb-3 mb-sm-0">
                  <a href="logout.php" class="btn btn-primary btn-user btn-block">
                     Logout
                  </a>
                </div>
               </div>
              <hr>
             </form>
             <div class="text-center">
             <?php if(isset($_POST["button"])){
             echo "<div class='alert alert-primary' role='alert'>"
             .$msg.
             "</div>";};?>
             </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="/assets/vendor/jquery/jquery.min.js"></script>
  <script src="/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="/assets/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="/assets/js/sb-admin-2.min.js"></script>

</body>

</html>