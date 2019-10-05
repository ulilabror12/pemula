<?php
session_start();
require_once'backend.php';
if(isset($_SESSION['user']))
 {
   $headergettrans=[
                     'Authorization: '.$_SESSION['user']['auth'][0],
                     'Content-Type: application/json',
                     'Accept: application/json',
                     'CHANNELID: UX',
                     'MYTELKOMSEL-MOBILE-APP-VERSION: 4.4.0',
                     'X-REQUESTED-WITH: com.telkomsel.mytelkomsel',
                     'User-Agent: Mozilla/5.0 (Linux; Android 7.1.2; Redmi Note 5A Build/N2G47H; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/74.0.3729.157 Mobile Safari/537.36',
                    // 'TRANSACTIONID: A301190812225556891804700
                    //'Accept-Encoding: gzip, deflate',
                     'Accept-Language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7'
                   ];
    //var_dump($_SESSION['user']['auth'][0]);
   $transign= requestc('tdw.telkomsel.com/api/offers/filtered-offers/v3?filteredby=featured&html=true',null,$headergettrans,'GET',true)['signtrans'][0];
  if(isset($_POST['button']))
   {
    $select= $_POST['paket'];
    $idpaket=$_POST['idpaket'];
    if($idpaket==null)
      {
       switch($select)
           {
              case 1: $id= "00007228";
              break;
              case 2: $id= "00007229";
              break;
           };
      }
     else
      { 
         $id= $_POST['idpaket'];
      }    
                   
           
             
      
       $url= 'tdw.telkomsel.com/api/offers/v2/';
       $url=$url.$id;
       $data=[
          "toBeSubscribedTo"=>false,
          "paymentMethod"=>"AIRTIME"
       ];
       $data=json_encode($data);
       $header=[
                'Origin: file://',
               // 'HASH: 329fb7119530bee1d246e3c66618aa794fb898047e6bb9e327cb95aadefe2893',
                'Authorization: '.$_SESSION['user']['auth'][0], //eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.''.WM7SVc06i3SOFqx4ZAkgMMTi_yrZFFeMpfzuXOyQrzU
                'Content-Type: application/json',
                'Accept: application/json',
                'CHANNELID: UX',
                'MYTELKOMSEL-MOBILE-APP-VERSION: 4.4.0',
                'X-REQUESTED-WITH: com.telkomsel.mytelkomsel',
                'SIGNTRANS: '.$transign,
                'User-Agent: Mozilla/5.0 (Linux; Android 7.1.2; Redmi Note 5A Build/N2G47H; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/74.0.3729.157 Mobile Safari/537.36',
               // 'TRANSACTIONID: A301190810192558498804700',
       // 'Accept-Encoding: gzip, deflate',
                'Accept-Language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7'
               ];
      $req=requestc($url,$data,$header,'PUT',null);
        $req=json_decode($req,true);
       if($req['message']=='BIZ-UXP-0002'){
            $msg= $req['message'].'<br><small>atau <br>Pulsa tidak mencukupi</small>';
   }else{$msg= $req['message'];}      
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
                   <option value="1"<?php if(isset($_POST["button"])){if($select==1){echo"selected";};};?>>Maxstream 10GB ,10k,7hr</option>
                   <option value="2"<?php if(isset($_POST["button"])){if($select==2){echo"selected";};};?>>MAXstream 7GB ,7k,3hr</option>
                   
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