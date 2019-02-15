<?php
header("HTTP/1.1 200 OK",true,200);
echo "OK";


//mail("danny.jc1205@gmail.com","testme","please see me");
include "includes/inc_db.php";
$db=new DB;
$finalArray= array();
//text, keyword, msisdn
//$arr = get_defined_vars();
//echo "<pre>";
//print_r($arr);
//echo "</pre>";
//mail("danny.jc1205@gmail.com","HELLLO",print_r($_POST));

$text=$_POST['text'];
$from=$_POST['msisdn'];
$keyword=$_POST['keyword'];


//
//$text = $message->text;
//$from = $message->msisdn;
//$keyword = $message->keyword;

//
//
$item = explode("||", $text);
//
$textIn=$item[0];
$location = explode(",",$item[1]);
//
$testText = explode(" ",$textIn);
$mode = $testText[0];
unset($testText[0]);
$text=implode(" ",$testText);
//
$text=filter_var($text,FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
$text=filter_var($text,FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

$text=addslashes($text);
$lat = $location[0];
$long = $location[1];


//$db->query("INSERT INTO messgeLog SET msInText='$textIn', msMode='$keyword', msFrom='$msisdn', msLong='$long', msLat='$lat'");
$db->query("INSERT INTO messgeLog SET msInText='$text', msMode='$mode', msFrom='$from', msLong='$long', msLat='$lat'");

/*
here is where we need to go off to google to get the api location
*/

/*
send the message back out
*/


$msLat = $lat;
$msLong = $long;
//$text = "52.5,-1.9";
//$msLat = "52.4830644";
//$msLong="-1.8857208";

//https://maps.googleapis.com/maps/api/directions/json?origin=Disneyland&destination=Universal+Studios+Hollywood&mode=walking&key=AIzaSyDDB4wNh_eKWYescpP5V7sHo0VHsAu5Ml0
$googleApi = "AIzaSyDDB4wNh_eKWYescpP5V7sHo0VHsAu5Ml0";
$origin="$msLat,$msLong";
$destination = $text;
$mode = $keyword;

//Get the nearest place they're searching for


//echo "THIS IS THE TEXT".$text;
$loc = $text;
//$loc = "Tesco";
$loc = urlencode($loc);

//AIzaSyD2D3NcIUgAIfSlAt0hX0BaayKrhur0O7I
$placesUrl = "https://maps.googleapis.com/maps/api/place/findplacefromtext/json?input=".$loc."&inputtype=textquery&fields=photos,formatted_address,name,opening_hours,rating&locationbias=circle:2000@".$origin."&key=AIzaSyD2D3NcIUgAIfSlAt0hX0BaayKrhur0O7I";
echo $placesUrl;
//echo $placesUrl;
$ch = curl_init($placesUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$return = curl_exec($ch);
$location = $return;

$locationArr = json_decode($location,true);

//Store the address ready for routing
$destination = $locationArr['candidates'][0]['formatted_address'];

$destination = urlencode($destination);
$sendUrl = "https://maps.googleapis.com/maps/api/directions/json?origin=$origin&destination=$destination&mode=$mode&key=$googleApi";
echo $sendUrl;
$ch = curl_init($sendUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$return = curl_exec($ch);

$directions = json_decode($return,true);

//print_r($directions["routes"]);

//foreach($directions["routes"] as $key=>$legs){
////    echo "<pre>";print_r($value); echo "</pre>";
//    foreach($value["legs"] as $keys=>$step){
//        foreach($values["step"] as $keys1=>$values1){
//            print_r($values["step"]);
////        }
//    
//    }
//   
//}

$goHereArray = array();
foreach($directions["routes"] as $legs){
    foreach($legs["legs"] as $steps){
        foreach($steps["steps"] as $steps2){
            echo $steps2["distance"]["text"];
            echo $steps2["html_instructions"];
            $goHereArray[] = $steps2["distance"]["text"]."-".$steps2["html_instructions"]."\n";
        }
    }
}
$goHere = implode("",$goHereArray);

$returnString = "Destination:$text\n$goHere";
//$returnString = "Your Location:Birmingham,\nDestination:7 mHead east\n39 mTurn left toward Cardigan St\n25 mTurn right toward Cardigan St\n0.2 kmTurn left toward Cardigan St\n36 mTurn left toward Cardigan St\n0.1 kmTurn left onto Cardigan St\n0.2 kmTurn right onto Jennens Rd/A47\n0.7 kmTurn left at Ashted Circus onto Dartmouth Middleway/A4540\n0.5 kmAt the roundabout, take the 2nd exit onto Newtown Middleway/A4540\n1.0 kmTurn right onto New Town Row/A34\nContinue to follow A34\n25 mSlight left onto the ramp to Aston/Lozells/Handsworth/Witton\n0.1 kmTurn left onto Rodway Cl\n17mContinue onto Alma St N";

$db->query("INSERT INTO test SET location='$returnString', number='$from'");
$finalArray=str_split($returnString,160);



//$length = strlen($returnString);
//if($length>160){
//    $array = str_split($returnString, 160);
//    $finalArray[]=$array[0];
//    
//    $loopMe= $array[1];
//    echo "<br>LoopME : $loopMe<br>";
//    echo "Length : ".strlen($loopMe);
//    while(strlen($loopMe)>=160){
//        $array = str_split($loopMe, 160);
//        
//        echo"Array1 : $array[0]<br>Array2 : $array[1]<br>";
//        $finalArray[]=$array[0];
//        $loopMe=$array[1];
//    }
//
//    $finalArray[] = $loopMe;
//    
//}else{
//    $finalArray[] = $returnString;
//}


echo "<pre>";
print_r($finalArray);
echo "</pre>";
//
$sendMessage="";
foreach($finalArray as $key=>$sendMessage){
    $sendMessage=strip_tags($sendMessage);
    $apiKey = "d9982ba0";
    $apiSecret = "0fZtF4hqogcNNa50";
    $text = $sendMessage;
    $to = $from;
//    $to='447581326358';
    $from = "NOINTERNET";

    $url = 'https://rest.nexmo.com/sms/json?' . http_build_query([
            'api_key' => $apiKey,
            'api_secret' => $apiSecret,
            'to' => $to,
            'from' => $from,
            'text' => $text
        ]);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
}

/*
have to seperate into multiple texts if string length is > 160
*/
echo "EOF";
?>