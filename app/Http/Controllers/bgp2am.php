<?php
define('ROOT', dirname(__FILE__));
include ROOT . "/config.php";

$yesterday = date("Y-m-d",strtotime("-1 days"));
$today = date("Y-m-d");
$sql = "select a.*,b.VBM,b.VPF,b.WDY,b.MDY,b.VPD,b.VAM from vehicle a,driver b where a.driver_id=b.id";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
	$VNO = $row['VNO'];
	
	$CAN = $row['CAN'];
	$TID = $row['TID'];
	$ECY = $row['ECY'];
	$CML = 0;
	$CHR = 0;
	$start_km = 0;
	$end_km = 0;
	$sql2 = "select min(odometer) as start_km from current_location where capture_date='$yesterday' and  terminal_id='$TID'";
	$result2 = mysqli_query($conn, $sql2);
	$sql3 = "select max(odometer) as end_km from  current_location where capture_date='$yesterday' and terminal_id='$TID'";
	$result3 = mysqli_query($conn, $sql3);
	if(mysqli_num_rows($result2)){
		$row2 = mysqli_fetch_assoc($result2);
		$start_km = $row2['start_km'];
	}
	if(mysqli_num_rows($result3)){
		$row3 = mysqli_fetch_assoc($result3);
		$end_km = $row3['end_km'];
	}
	$CML = round($end_km - $start_km,3);
	mysqli_free_result($result2);
	mysqli_free_result($result3);
	
	$sql4 = "select capture_time,ground_speed from current_location where capture_date='$yesterday' and  terminal_id='$TID' order by capture_time";
	$i=0;
	$total_seconds = 0;
	$CHR = 0;
	$result4 = mysqli_query($conn, $sql4);
	while ($row4 = mysqli_fetch_assoc($result4)) {
		$ground_speed = $row4['ground_speed'];
		$capture_time = explode(".",$row4['capture_time']);
		$capture_time = $capture_time[0];
		$hour = substr($capture_time,0,2);
		$minute = substr($capture_time,2,2);
		$second = substr($capture_time,4,2);
		$time_seconds = $hour * 3600 + $minute * 60 + $second;
		if($i>0 && $ground_speed <> 0 && $previous_ground_speed <> 0){
			$total_seconds = $total_seconds + ($time_seconds - $previous_time);
		}
		$previous_time = $time_seconds;
		$previous_ground_speed = $row4['ground_speed'];
		$i++;
	}
	$CHR = round($total_seconds/3600,2);

	$min_speed = 0;
    $sql5 = "select avg(ground_speed) as min_speed from current_location where capture_date = '$yesterday' and  terminal_id='$TID' and ground_speed <> 0";
    $result5 = mysqli_query($conn, $sql5);
    if(mysqli_num_rows($result5)){
    	$row5 = mysqli_fetch_assoc($result5);
        $min_speed = (float)$row5['min_speed'];
    }
            
    $max_speed = 0;
    $sql6 = "select max(ground_speed) as max_speed from current_location where capture_date = '$yesterday' and  terminal_id='$TID'";
    $result6 = mysqli_query($conn, $sql6);
    if(mysqli_num_rows($result6)){
    	$row6 = mysqli_fetch_assoc($result6);
        $max_speed = (float)$row6['max_speed'];
    }

    $work_start = "";
    $sql7 = "select min(capture_datetime) as work_start from current_location where capture_date = '$yesterday' and  terminal_id = '$TID' and engine_on = 1";
	$result7 = mysqli_query($conn, $sql7);
    if(mysqli_num_rows($result7)){
    	$row7 = mysqli_fetch_assoc($result7);
        $work_start = substr($row7['work_start'],11);
    }        

    $work_end = "";
    $sql8 = "select max(capture_datetime) as work_end from current_location where capture_date = '$yesterday' and  terminal_id = '$TID' and engine_on = 1";
	$result8 = mysqli_query($conn, $sql8);
    if(mysqli_num_rows($result8)){
    	$row8 = mysqli_fetch_assoc($result8);
        $work_end = substr($row8['work_end'],11);
    } 

    $odometer = "";
    $sql5 = "select odometer from current_location where capture_date = '$yesterday' and  terminal_id='$TID' order by id desc limit 1";
    $result5 = mysqli_query($conn, $sql5);
    if(mysqli_num_rows($result5)){
    	$row5 = mysqli_fetch_assoc($result5);
        $odometer = $row5['odometer'];
    } 
    $odometer = round($odometer,2);

    $vehicle_idling = 0; 
    $sql5 = "select count(*) as vehicle_idling from current_location where capture_date = '$yesterday' and  terminal_id='$TID' and ground_speed = 0 and engine_on = 1";
    $result5 = mysqli_query($conn, $sql5);
    if(mysqli_num_rows($result5)){
    	$row5 = mysqli_fetch_assoc($result5);
        $vehicle_idling = $row5['vehicle_idling'];
    }  

    $vehicle_running = 0; 
    $sql5 = "select count(*) as vehicle_running from current_location where capture_date = '$yesterday' and  terminal_id='$TID' and engine_on = 1";
    $result5 = mysqli_query($conn, $sql5);
    if(mysqli_num_rows($result5)){
    	$row5 = mysqli_fetch_assoc($result5);
        $vehicle_running = $row5['vehicle_running'];
    } 

    $engine_idling = 0;
    if($vehicle_running != 0){
    	$engine_idling = ($vehicle_idling / $vehicle_running) * 100;
    } 
    $engine_idling = round($engine_idling,2);

    $lessthan_100 = 0; 
    $sql5 = "select count(*) as lessthan_100 from current_location where capture_date = '$yesterday' and  terminal_id='$TID' and ground_speed <= 100 and engine_on = 1";
    $result5 = mysqli_query($conn, $sql5);
    if(mysqli_num_rows($result5)){
    	$row5 = mysqli_fetch_assoc($result5);
        $lessthan_100 = $row5['lessthan_100'];
    }  

    $morethan_100 = 0; 
    $sql5 = "select count(*) as morethan_100 from current_location where capture_date = '$yesterday' and  terminal_id='$TID' and ground_speed > 100 and engine_on = 1";
    $result5 = mysqli_query($conn, $sql5);
    if(mysqli_num_rows($result5)){
    	$row5 = mysqli_fetch_assoc($result5);
        $morethan_100 = $row5['morethan_100'];
    } 

    $speeding = 0.0;
    if($morethan_100 != 0){
    	$speeding = ($morethan_100 / $lessthan_100) * 100;
    }
    $speeding = round($speeding,2);   

    $CON = (.195 + .141 * pow($ECY * 1000 , .52)) / 100; 
    $fuel_consumed = $CML * $CON; 
    $fuel_consumed = round($fuel_consumed,2);     

	$VBM = $row['VBM'];
	$driver_id = $row['driver_id'];
	$VPF = $row['VPF'];
	$WDY = $row['WDY'];
	$MDY = $row['MDY'];
	$VPD = $row['VPD'];
	$VAM = $row['VAM'];

	$insert = "insert into bgp1am (DDT,CAN,VNO,CHR,CML,DES,DECL,VBM,driver_id,min_speed,max_speed,work_start,work_end,odometer,engine_idling,speeding,fuel_consumed) VALUES ('$yesterday','$CAN','$VNO','$CHR','$CML','A0','0','$VBM','$driver_id','$min_speed','$max_speed','$work_start','$work_end','$odometer','$engine_idling','$speeding','$fuel_consumed')";
	mysqli_query($conn, $insert) or die(mysqli_error($conn));
}
mysqli_free_result($result);
mysqli_close($conn);


