<?php
$data = date("d.m");
$ip = $_SERVER["REMOTE_ADDR"];
$file1 = "ip".$str.".txt";
$file2 = "count".$str.".txt";
if(!file_exists($file2)){
    $vsego = 1;
    $segodny = 1;
    $ipkol = 1;
    $count = $vsego."\n".$data."\n".$segodny;
    $check = fopen($file2, "w+");
    fwrite($check, $count);
    fclose($check);
    $ip2 = fopen($file1, "w+");
    fwrite($ip2, $ip."\n");
    fclose($ip2);
}else{
    $file = file(($file2));
    foreach($file as $stroka){
        $mass[] = $stroka;
    }
    $vsego = (int)$mass[0];
    $data2 = (float)$mass[1];
    $segodny = (int)$mass[2];
    $vsego++;
    if($data2!= $data){
        $segodny=1;
    }
    else{
        $segodny ++;
    }
    $count2 = $vsego."\n".$data."\n".$segodny;
    $check=fopen($file2, "w+");
    flock($check, LOCK_EX);
    fwrite($check, $count2);
    flock($check, LOCK_UN);
    fclose($check);
    $ip2= file($file1);
    $ipkol = count($ip2);
    if(in_array($ip."\n", $ip2)==false){
        $ipopen = fopen($file1, "a");
        flock($ipopen, LOCK_EX);
        fwrite($ipopen, $ip."\n");
        flock($ipopen, LOCK_UN);
        $ipkol++;
        fclose($ipopen);
    }
}
?>
