<?php
/**
*cортировка массива классов в лексикографическом порядке
*$param параметр, по которому надо сортировать
*order порядок, в котором надо сортировать min - в порядке убывания, max- возрастания
*mass массив, который надо сортировать
*length длина массива
*class имя класса, из которого состоит массив
*/
function mysort_string ($class,$param,$order,$mass,$length) {
	$attribs=get_class_vars($class);
	$count=0;
	$var=array();
	foreach($attribs as $key=> $value) {
		$count++;
		$var[$count]=$key;
		}
	do {
		$F=1;
		for ($i=1; $i <= $length-1; $i++) {
		if (($order=='max' && strnatcasecmp($mass[$i]-> $param,$mass[$i+1]-> $param)>0) ||
			    ($order=='min' && strnatcasecmp($mass[$i]-> $param,$mass[$i+1]-> $param)<0)) {
					for ($j=1; $j<= $count; $j++) {
					
					$S=$mass[$i]-> $var[$j];
					$mass[$i]-> $var[$j]=$mass[$i+1]-> $var[$j];
					$mass[$i+1]-> $var[$j]=$S;
					}	
				$F=0;
				}
			}
		}
		while ($F==0); 

	}
function mysort_number  ($class,$param,$order,$mass,$length) {
        $attribs=get_class_vars($class);
        $count=0;
        $var=array();
        foreach($attribs as $key=> $value) {
                $count++;
                $var[$count]=$key;
                }
        do {
                $F=1;
                for ($i=1; $i <= $length-1; $i++) {
                if (($order=='max' && $mass[$i]-> $param >$mass[$i+1]-> $param) ||
                            ($order=='min' && $mass[$i]-> $param < $mass[$i+1]-> $param)) {
                                        for ($j=1; $j<= $count; $j++) {
                                        echo $mass[$i]-> $var[$j]." ".$mass[$i+1]-> $var[$j]."<BR>";
                                        $S=$mass[$i]-> $var[$j];
                                        $mass[$i]-> $var[$j]=$mass[$i+1]-> $var[$j];
                                        $mass[$i+1]-> $var[$j]=$S;
                                        }       
                                $F=0;
                                }
                        }
                }
                while ($F==0); 
        }
function mysort_time  ($class,$param,$order,$mass,$length) {
        $attribs=get_class_vars($class);
        $count=0;
        $var=array();
        foreach($attribs as $key=> $value) {
                $count++;
                $var[$count]=$key;
                }
	
        do {
                $F=1;
                for ($i=1; $i <= $length-1; $i++) {	
	$time1= $mass[$i]-> $param;
	$time2=$mass[$i+1]-> $param;
//	$time1=mktime(substr($mass[$i]-> $param,3,2),substr($mass[$i]-> $param,0,2),substr($mass[$i]-> $param,6,4));
//	$time2=mktime(substr($mass[$i+1]-> $param,3,2),substr($mass[$i+1]-> $param,0,2),substr($mass[$i+1]-> $param,6,4));
	//	echo $mass[$i]-> $param." ".$time1." ".$mass[$i+1]-> $param." ".$time2."<BR>";
		if (($order=='max' && $time1>$time2) ||
                            ($order=='min' && $time1<$time2)) {
                                        for ($j=1; $j<= $count; $j++) {
                                       
                                        $S=$mass[$i]-> $var[$j];
                                        $mass[$i]-> $var[$j]=$mass[$i+1]-> $var[$j];
                                        $mass[$i+1]-> $var[$j]=$S;
                                        }
                                $F=0;
                                }
                        }
                }
                while ($F==0);
        }
?>
