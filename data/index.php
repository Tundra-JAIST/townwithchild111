<?php
/* CSV更新日時取得 */
$url = "http://www.i-oyacomi.net/prepass/csv/openData_baby.csv";
$headers = get_headers($url, 1);
/*echo date("Y/m/d H:i:s", strtotime($headers['Last-Modified']));
echo "<br><br>";
echo date("Y/m/d H:i:s");
echo "<br><br>";*/

/* csvをローカルに保存する部分 */
/* $csvname = "openbaby.csv"; */
/* $csvfile = mb_convert_encoding(file_get_contents($url),"UTF-8","Shift_JIS"); */
/* file_put_contents($csvname,$csvfile); */
//echo $csvfile;

/* サイトからcsvを取得して処理*/
if(!$FP = fopen($url,"r")){
    echo "fopen error";
}else{
    //  fgetcsv():1行ずつファイル取得
    // データが無くなるまでファイル(CSV)を１行ずつ読み込む
    $j = 0;
    while( $ret_csv = fgetcsv($FP) ) {
        mb_convert_variables("UTF-8","Shift-JIS",$ret_csv);
        if($j > 1){
            // 読み込んだ行(CSV)の処理
            $arr_csv = trim_csv($ret_csv,$j);
            //mb_convert_variables("UTF-8","Shift-JIS",$arr_csv);
            $result[] = $arr_csv;
            
            // テスト用code
            /* if($j<5){ */
            /*     print_r($ret_csv); */
            /*     echo "<br><br>"; */
            /*     if($j === 4){ */
            /*         print_r($result); */
            /*         echo "<br><br>"; */
            /*     } */
            /* } */
        }
        $j++;    
    }
    //mb_convert_variables("UTF-8","SJIS",$result);
    //print_r($result);
    //var_dump(json_encode($result));
    $json = json_encode($result);
    //echo print_r(json_decode($json));
}   echo $json;     


// id, name(施設名), code(郵便番号), address(住所), lat(緯度), lng(経度), tel(電話番号), url, open(利用可能時間), holiday(定休日), service(特典)
function trim_csv($csv,$i) {
    $arr = array('id'=>$i);
    if($csv[2] == ""){$csv[2] = "no data";}
    $arr['name'] = $csv[2];
    if($csv[3] == ""){$csv[3] = "no data";}
    $arr['code'] = $csv[3];
    if($csv[4] == ""){$csv[4] = "no data";}
    $arr['address'] = $csv[4];
    if($csv[6] == ""){$csv[6] = "no data";}
    $arr['lat'] = $csv[6];
    if($csv[7] == ""){$csv[7] = "no data";}
    $arr['lng'] = $csv[7];
    if($csv[8] == ""){$csv[8] = "no data";}
    $arr['tel'] = $csv[8];
    if($csv[10] == ""){$csv[10] = "no data";}
    $arr['url'] = $csv[10];
    if($csv[11] == ""){$csv[11] = "no data";}
    $arr['open'] = $csv[11];
    if($csv[12] == ""){$csv[12] = "no data";}
    $arr['holiday'] = $csv[12];
    
    for ($k=13; $k<26; $k++){
        if($csv[$k] == ""){
            continue;
        }else{
            $serv .= $csv[$k] . ",";
        }
    }
    $serv = substr($serv, 0, -1);
    $arr['service'] = $serv;

    return $arr;
}

?>
