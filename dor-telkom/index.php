<?php
session_start();
require_once'backend.php';
date_default_timezone_set('Asia/Jakarta');
$tombol=$_POST['request'];
$no=$_POST['nomer'];
$link=$_POST['link'];
  if(isset($tombol))
    {
      if($tombol =='Get Link')
          {
             $getlink= [
                          'client_id'=>'TFKYtPumTXcLM8xEZATlvceX2Vtblaw3',
                          'phone_number'=>'+'.$no,
                          'connection'=>'sms'
                       ];
             $headergetlink=[
                             'Accept: application/json, text/javascript',
                             'Auth0-Client: eyJuYW1lIjoiYXV0aDAuanMiLCJ2ZXJzaW9uIjoiNi44LjQifQ',
                             'Origin: file://',
                             'User-Agent: Mozilla/5.0 (Linux; Android 7.1.2; Redmi Note 5A Build/N2G47H; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/74.0.3729.157 Mobile Safari/537.36',
                             'Content-Type: application/x-www-form-urlencoded',
                             'Accept-Encoding: gzip, deflate',
                             'Accept-Language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7',
                             'X-Requested-With: com.telkomsel.telkomselcm'
                           ];
             $cekgetlink=request('https://tdwidm.telkomsel.com/passwordless/start',http_build_query($getlink),$headergetlink,null);
             if($cekgetlink!='Too Many Requests')
                  { $msg='Link berhasil terkirim ke '.$no;}
             else {$msg='Gagal terkirim.';}
          }
      else if($tombol=='login')
          {
             //get link
             $link = explode('=',$link);
             $decrypt = [
                         'linkcode'=> $link[1]
                        ];
             $decrypt = json_encode($decrypt);
             $headerdecrypt=[
                              'Origin: file://',
                              'HASH: 382b23a6fe86b51a9a3d6d87ef74b7edbf927c8ec7318b69a7359171b95bb0b7',
                              'Authorization: Bearer null',
                              'Content-Type: application/json',
                              'Accept: application/json',
                              'CHANNELID: UX',
                              'MYTELKOMSEL-MOBILE-APP-VERSION: 4.4.0',
                              'X-REQUESTED-WITH: com.telkomsel.mytelkomsel',
                              'User-Agent: Mozilla/5.0 (Linux; Android 7.1.2; Redmi Note 5A Build/N2G47H; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/74.0.3729.157 Mobile Safari/537.36',
                              'TRANSACTIONID: A301190807172822450000000',
                              //'Accept-Encoding: gzip, deflate',
                              'Accept-Language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7'
                            ];
              //decrypt code link
              $urlgetotp='https://tdw.telkomsel.com/api/auth/passcode/'.$no;
              $otp=request($urlgetotp,$decrypt,$headerdecrypt,null);
              if(intval($otp) != '')
                  {
                     $reqlogin=[
                                 'scope'=>'openid offline_access',
                                 'response_type'=>'token',
                                 'sso'=>'false',
                                 'device'=>'d4e7f273abb04128:Mozilla/5.0 (Linux; Android 7.1.2; Redmi Note 5A Build/N2G47H; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/74.0.3729.157 Mobile Safari/537.36',
                                 'connection'=>'sms',
                                 'username'=>'+'.$no,
                                 'password'=>$otp,
                                 'client_id'=>'TFKYtPumTXcLM8xEZATlvceX2Vtblaw3',
                                 'grant_type'=>'password'
                               ];
                      $reqlogin=http_build_query($reqlogin);
                      $headerlogin=[
                                     'Accept: application/json, text/javascript',
                                     'Auth0-Client: eyJuYW1lIjoiYXV0aDAuanMiLCJ2ZXJzaW9uIjoiNi44LjQifQ',
                                     'Origin: file://',
                                     'User-Agent: Mozilla/5.0 (Linux; Android 7.1.2; Redmi Note 5A Build/N2G47H; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/74.0.3729.157 Mobile Safari/537.36',
                                     'Content-Type: application/x-www-form-urlencoded',
                                     //'Accept-Encoding: gzip, deflate',
                                     'Accept-Language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7',
                                     'X-Requested-With: com.telkomsel.telkomselcm'
                                   ];
                     $session=json_decode(request('https://tdwidm.telkomsel.com/oauth/ro',$reqlogin,$headerlogin,null),true);
                     //token user
                    $datagettoken=[
                        "msisdn"=>$no,
                        "fingerPrint"=>"d4e7f273abb04128",
                        "webInfo"=>[
                          "cpu_class"=> "unknown",
                          "has_lied_os"=> false,
                          "available_resolution"=> [
                              640,
                              360
                            ],
                          "local_storage"=> 1,
                          "color_depth"=> 24,
                          "has_lied_browser"=> false,
                          "adblock"=> false,
                          "has_lied_resolution"=> false,
                          "device_memory"=> 2,
                          "resolution"=> [
                             640,
                             360
                            ],
                          "indexed_db"=> 1,
                          "webgl_vendor"=> "Qualcomm~Adreno (TM) 308",
                          "js_fonts"=> [
                            "Arial",
                            "Courier",
                            "Courier New",
                            "Georgia",
                            "Helvetica",
                            "Monaco",
                            "Palatino",
                            "Tahoma",
                            "Times",
                            "Times New Roman",
                            "Verdana"
                           ],
                          
                          "touch_support"=> [
                            5,
                           true,
                           true
                            ],
                          "open_database"=> 1,
                          "user_agent"=> "Mozilla/5.0 (Linux; Android 7.1.2; Redmi Note 5A Build/N2G47H; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/74.0.3729.157 Mobile Safari/537.36",
                          "session_storage"=> 1,
                          "audio_fp"=> "124.08072748292034",
                          "language"=> "id-ID",
                          "timezone_offset"=> -420,
                          "navigator_platform"=> "Linux aarch64",
                          "hardware_concurrency"=> 4,
                          "regular_plugins"=> [],
                          "has_lied_languages"=> false
                        ],
                        "mobileInfo"=> [
                          "cordova"=> "6.3.0",
                          "model"=> "Redmi Note 5A",
                          "platform"=> "Android",
                          "uuid"=> "d4e7f273abb04128",
                          "version"=> "7.1.2",
                          "manufacturer"=> "Xiaomi"                        
                          ]
                         ]
                        ;
                     $headergettoken=[
                                      'Origin: file://',
                                      'HASH: 892eb3559e4db1cbaf8542f80e70ba431d0f9f8f66ea11797f26c91b0125fe59',
                                      'Authorization: Bearer '.$session['id_token'],
                                      'Content-Type: application/json',
                                      'Accept: application/json',
                                      'CHANNELID: UX',
                                      'MYTELKOMSEL-MOBILE-APP-VERSION: 4.4.0',
                                      'X-REQUESTED-WITH: com.telkomsel.mytelkomsel',
                                      'User-Agent: Mozilla/5.0 (Linux; Android 7.1.2; Redmi Note 5A Build/N2G47H; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/74.0.3729.157 Mobile Safari/537.36',
                                      'TRANSACTIONID: A301190812162523913000000',
                                    // 'Accept-Encoding: gzip, deflate',
                                      'Accept-Language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7'
                                     ];
                     $datagettoken=json_encode($datagettoken);
                     $gettokenuser=requestc('tdw.telkomsel.com/api/user/',$datagettoken,$headergettoken,'PATCH',true)['authorization'][0];
                     //PKG token
                     $urlpkgtoken='tdw.telkomsel.com/api/subscriber/v5/profile?msisdn='.$no;
                     $headerpkgtoken=[
                                      //HASH: e8b57c63ee50f8f71bbe9ee2406a346790c16f0b8628dd186b449d9e3291a5ea
                                      'Authorization: '.$gettokenuser ,//.$h=$gettokenuser['authorization'],
                                      'Accept: application/json',
                                      'CHANNELID: UX',
                                      'MYTELKOMSEL-MOBILE-APP-VERSION: 4.4.0',
                                      'X-REQUESTED-WITH: com.telkomsel.mytelkomsel',
                                      'User-Agent: Mozilla/5.0 (Linux; Android 7.1.2; Redmi Note 5A Build/N2G47H; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/74.0.3729.157 Mobile Safari/537.36',
                                     // TRANSACTIONID: A301190812162524752804700
                                      //Accept-Encoding: gzip, deflate
                                      'Accept-Language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7'
                                     ];
                      $responsetokenpkg=requestc($urlpkgtoken,null,$headerpkgtoken,'GET',true);
                      $rpkgt=$responsetokenpkg['authorization'];
                      $datalogin=[
                                  'auth'=> $rpkgt,
                                  'refresh_token'=> $session['refresh_token'],
                                  'access_token'=> $session['access_token'],
                                  'token_type'=>$session['token_type'],
                                  'nomer'=>$no
                                ];
                     
                    if($session['id_token'] != null)
                       {
                          $_SESSION['user']=$datalogin;
                          $msg="Please,wait 5 second.";
                          header("refresh:5;url=register-paket.php")
                      ;}
                    else
                       {
                          $msg='No atau link salah'
                       ;}
                  ;}
              else
                {
                  $msg='Link tidak benar...';
                }
             // decrypt code link
            // request ();
          }
      
    };
//proses
$filecounter=("counter.txt");
$kunjungan=file($filecounter);
$kunjungan[0]++;
$file=fopen($filecounter,"w");
fputs($file,"$kunjungan[0]");
fclose($file);
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="dor-telcom">
  <meta name="author" content="h">

  <title>Dor-Telcom</title>

  <!-- Custom fonts for this template-->
  <link rel="icon" href="icon.png">
  <link href="/assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="/assets/css/sb-admin-2.min.css" rel="stylesheet">
  <script type='text/javascript' src='http://code.jquery.com/jquery-1.10.2.min.js'></script>
  <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
  <script>
  (adsbygoogle = window.adsbygoogle || []).push({
  google_ad_client: "ca-pub-6830499991514025",
  enable_page_level_ads: true
  });
  </script>
</head>
<body class="bg-gradient-primary">
<div class="container">
  <!-- Outer Row -->
  <div class="row justify-content-center">

    <div class="col-lg-7">

      <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
          <!-- Nested Row within Card Body -->
          <div class="row">
            <div class="col-lg">
              <div class="p-5">
                <div class="text-center">
                  <h1 class="h4 text-gray-900 mb-4">Login</h1>
                </div>
                <form class="user"method="post"action="">
                  <div class="form-group">
                    <input type="text" class="form-control form-control-user"name="nomer" placeholder="Enter your number telkomsel..."value="<?php if(isset($_POST["request"])){echo $no;};?>"required>
                  </div>
                        <div class="form-group">
                          <input type="submit"name="request" class="btn btn-secondary btn-lg btn-block"value="Get Link">
                        </div>
                  
                  <div class="form-group">
                    <input type="text" class="form-control form-control-user"name="link" placeholder="Enter your link"autocomplete="off">
                  </div>
                  <div class="form-group">
                  <input type="submit"name="request" class="btn btn-secondary btn-lg btn-block"value="login">
                  </div>
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalLong">
                      Tutorial
                  </button>
                  
                      <!-- Modal -->
                   <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                         <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLongTitle">Cara menggunaan</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                   <span aria-hidden="true">&times;</span>
                                </button>
                             </div>
                                    <div class="modal-body">
                  
                  
                        1. Isi nomer Telkomsel terlebih dahulu,nomer awal 6282xxxx. Link dikosongkan.<br>
                        2. Klik tombol get link.<br>
                        3. Isi link dengan link yang telah terkirim di SMS anda.<br>
                        4. Klik login.<br>
                        <p> Jika sudah login pilih paket. Kosongkan id paket jika tidak punya. pulsa harus mencukupi.
                      
                       <p> Jika ada  masalah laporkan ke WA: 087732168347.
                       Fungsi adanya web ini adalah untuk mempermudah pembelian paket data. 
                      <b> Masih tahap uji coba</b></p>
                      
                  
                                     </div>
                           <div class="modal-footer">
                             <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                           </div>
                         </div>
                      </div>
                   </div>
                 </form>
                
                <hr>
                <div class="text-center">
                    <small>
                         Count: <?=
                        $kunjungan[0];
                         ?>
                    </small>
                </div>
                <hr>
                <div class="text-center">
                    <?php if(isset($_POST["request"])){
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