<?php
function _n($num){
	if(strpos($num, ',') !== false)
	 return (float) str_replace(',', '.', $num);
	else 
		return (int) $num;
	
	}
//return first elemnt of an array	
function _first($ar){
	return array_shift(array_values($ar));	
}
$row = 0;

//holds all the values
$ar = array();

//holds all the percentiles
$p_ar = array();
if (($handle = fopen("cdc1.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $num = count($data);
		 $row ++;
        for ($c=0; $c < $num; $c++) {
			
			// excluding first rows
			if($row < 2)
				continue;
			if($row == 2 && $c == 0 )
				continue;
				
			//converting values to float	
			$data_c = (float) _n($data[$c]);
			
			// taking the percentiles
			if($row == 2){
				$p_ar[$c] = $data_c;
				
				continue;
			}
			if($c == 0)
				continue;
			else {
				$ar[$p_ar[$c]][] = array( _n($data[0]), $data_c); 
			}
			
        }
       
      // if($row == 3)break;
    }
    fclose($handle);
     //var_dump($ar[3]);
}

// convert the array to x y values keys are the percentile
$f_ar = array();
$i = 0;
foreach($ar as $key=>$val){
	foreach($val as $k => $v){
		if($i++ % 3 != 0 ) continue;
		$f_ar[$key]['x'][] = $v[0]; 
		$f_ar[$key]['y'][] = $v[1]; 
		
		}

}


//charting
/* pChart library inclusions */ 
 include("pchart/class/pData.class.php"); 
 include("pchart/class/pDraw.class.php"); 
 include("pchart/class/pImage.class.php"); 
 include("pchart/class/pScatter.class.php");  

 /* Create and populate the pData object */ 
 $MyData = new pData(); 
 foreach($f_ar as $k => $v){
	 $MyData ->addPoints($v['y'], $k);
	// break;
	 
 }  
// x axes values suppressing standard warning
$x = @_first($f_ar);
$x = @_first($x);

 
	
 //~ $MyData->addPoints(array(-4,VOID,VOID,12,8,3),"Probe 1"); 
 //~ $MyData->addPoints(array(3,12,15,8,5,-5),"Probe 2"); 
 //~ $MyData->addPoints(array(2,7,5,18,19,22),"Probe 3"); 
 //~ $MyData->setSerieTicks("Probe 2",4); 
 //~ $MyData->setSerieWeight("Probe 3",2); 
 $MyData->setAxisName(0,"Temperatures"); 
 $MyData->addPoints( $x ,"Labels"); 
 $MyData->setSerieDescription("Labels","Months"); 
 $MyData->setAbscissa("Labels"); 

$myPicture = new pImage(900,1000,$MyData); 
$myPicture->Antialias = FALSE; 

 /* Draw the background */ 
 $Settings = array("R"=>170, "G"=>183, "B"=>87, "Dash"=>1, "DashR"=>190, "DashG"=>203, "DashB"=>107); 
 $myPicture->drawFilledRectangle(0,0,900,1000,$Settings); 

 /* Overlay with a gradient */ 
 $Settings = array("StartR"=>219, "StartG"=>231, "StartB"=>139, "EndR"=>1, "EndG"=>138, "EndB"=>68, "Alpha"=>50); 
 $myPicture->drawGradientArea(0,0,900,950,DIRECTION_VERTICAL,$Settings); 
 $myPicture->drawGradientArea(0,0,700,20,DIRECTION_VERTICAL,array("StartR"=>0,"StartG"=>0,"StartB"=>0,"EndR"=>50,"EndG"=>50,"EndB"=>50,"Alpha"=>80));

 /* Add a border to the picture */ 
 $myPicture->drawRectangle(0,0,899,999,array("R"=>0,"G"=>0,"B"=>0)); 
  
 /* Write the picture title */  
 $myPicture->setFontProperties(array("FontName"=>"pchart/fonts/Silkscreen.ttf","FontSize"=>6)); 
 $myPicture->drawText(10,13,"drawPlotChart() - draw a plot chart",array("R"=>255,"G"=>255,"B"=>255)); 

 /* Write the chart title */  
 $myPicture->setFontProperties(array("FontName"=>"pchart/fonts/Forgotte.ttf","FontSize"=>11)); 
 $myPicture->drawText(250,55,"Average temperature",array("FontSize"=>20,"Align"=>TEXT_ALIGN_BOTTOMMIDDLE)); 

 /* Draw the scale and the 1st chart */ 
 $myPicture->setGraphArea(60,60,860,960); 
 $myPicture->drawFilledRectangle(60,60,840,940,array("R"=>255,"G"=>255,"B"=>255,"Surrounding"=>-200,"Alpha"=>10)); 
 $myPicture->drawScale(array("DrawSubTicks"=>TRUE)); 
 $myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10)); 
 $myPicture->setFontProperties(array("FontName"=>"pchart/fonts/pf_arma_five.ttf","FontSize"=>10)); 
 $myPicture->drawLineChart(array("DisplayValues"=>False,"DisplayColor"=>'black')); 
 $myPicture->setShadow(FALSE); 
//~ 
 //~ /* Draw the scale and the 2nd chart */ 
 //~ $myPicture->setGraphArea(500,60,670,190); 
 //~ $myPicture->drawFilledRectangle(500,60,670,190,array("R"=>255,"G"=>255,"B"=>255,"Surrounding"=>-200,"Alpha"=>10)); 
 //~ $myPicture->drawScale(array("Pos"=>SCALE_POS_TOPBOTTOM,"DrawSubTicks"=>TRUE)); 
 //~ $myPicture->setShadow(TRUE,array("X"=>-1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10)); 
 //~ $myPicture->drawLineChart(); 
 //~ $myPicture->setShadow(FALSE); 

 /* Write the chart legend */ 
 $myPicture->drawLegend(60,985,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL)); 

//set scatter data


 
  for ($i=0;$i<=360;$i=$i+10) { $MyData->addPoints(cos(deg2rad($i))*20,"S1"); } 
 for ($i=0;$i<=360;$i=$i+10) { $MyData->addPoints(sin(deg2rad($i))*20,"S2"); } 
 
  $MyData->setScatterSerie("S1","S3"); 

 /* Create the Scatter chart object */ 
 $myScatter = new pScatter($myPicture,$MyData); 
  $MyData->drawAll(); 

 /* Draw the scale */ 
 //$myScatter->drawScatterScale(); 

 /* Turn on shadow computing */ 
 //$myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10)); 

 /* Draw a scatter plot chart */ 
 // $myScatter->drawScatterLineChart(); 


 /* Render the picture (choose the best way) */ 

 $myPicture->autoOutput("example.drawLineChart.png"); 


//~ $fp = fopen('cdc1.csv', 'r');
//~ 
//~ // get the first (header) line
//~ $header = fgetcsv($fp);
//~ 
//~ // get the rest of the rows
//~ $data = array();
//~ while ($row = fgetcsv($fp)) {
  //~ $arr = array();
  //~ foreach ($header as $i => $col)
    //~ $arr[$col] = $row[$i];
  //~ $data[] = $arr;
//~ }
//~ 
//~ print_r($data);
?>

