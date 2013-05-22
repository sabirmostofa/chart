<?php
//error_reporting(0);
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

// x axes values suppressing standard warning which are on the first column of the xls/csv files
$x = @_first($f_ar);
$x = @_first($x);

 /* Create and populate the pData object */ 
 $MyData = new pData(); 

// set x axis
 $MyData->addPoints($x,"X"); 


 //X axis
  $MyData->setAxisName(0,"Index"); 
 $MyData->setAxisXY(0,AXIS_X); 
 //$MyData->setSerieOnAxis("X",0);
 $MyData->setAxisPosition(0,AXIS_POSITION_BOTTOM); 

//Y axis 

 $MyData->setAxisName(1,"Degree"); 
 $MyData->setAxisPosition(1,AXIS_POSITION_RIGHT); 
 $MyData->setAxisXY(1,AXIS_Y); 
 //$MyData->setSerieOnAxis("X",1);

$co =0;
 foreach($f_ar as $k => $v){
	 $MyData ->addPoints($v['y'], $k);
	  $MyData->setScatterSerie("X", $k, $co++); 
	   $MyData->setSerieOnAxis("X", 0);
	   $MyData->setSerieOnAxis($k, 1);
	// break;
	 
 }
 
 //test points
 
 $MyData->addPoints(array(50, 60, 70), 'l');	
 $MyData->addPoints(array(10, 19, 15), 'w');	
 
 $MyData->setScatterSerie('l', 'w', 114); 
 $MyData->setSerieOnAxis("w", 1);

 
 


 
 

 

//$myPicture = new pImage(900,1000,$MyData); 
 /* Create the pChart object */ 
 $myPicture = new pImage(400,400,$MyData); 

 /* Draw the background */ 
 $Settings = array("R"=>170, "G"=>183, "B"=>87, "Dash"=>1, "DashR"=>190, "DashG"=>203, "DashB"=>107); 
 $myPicture->drawFilledRectangle(0,0,400,400,$Settings); 

 /* Overlay with a gradient */ 
 $Settings = array("StartR"=>219, "StartG"=>231, "StartB"=>139, "EndR"=>1, "EndG"=>138, "EndB"=>68, "Alpha"=>50); 
 $myPicture->drawGradientArea(0,0,400,400,DIRECTION_VERTICAL,$Settings); 
 $myPicture->drawGradientArea(0,0,400,20,DIRECTION_VERTICAL,array("StartR"=>0,"StartG"=>0,"StartB"=>0,"EndR"=>50,"EndG"=>50,"EndB"=>50,"Alpha"=>80));

 /* Write the picture title */  
 $myPicture->setFontProperties(array("FontName"=>"pchart/fonts/Silkscreen.ttf","FontSize"=>6)); 
 $myPicture->drawText(10,13,"drawScatterLineChart() - Draw a scatter line chart",array("R"=>255,"G"=>255,"B"=>255)); 

 /* Add a border to the picture */ 
 $myPicture->drawRectangle(0,0,399,399,array("R"=>0,"G"=>0,"B"=>0)); 

 /* Set the default font */ 
 $myPicture->setFontProperties(array("FontName"=>"pchart/fonts/pf_arma_five.ttf","FontSize"=>6)); 
  
 /* Set the graph area */ 
 $myPicture->setGraphArea(50,50,350,350); 

 /* Create the Scatter chart object */ 
 $myScatter = new pScatter($myPicture,$MyData); 

 /* Draw the scale */ 
 $myScatter->drawScatterScale(); 

 /* Turn on shadow computing */ 
 $myPicture->setShadow(TRUE,array("X"=>1,"Y"=>1,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>10)); 

 /* Draw a scatter plot chart */ 
$myScatter->drawScatterLineChart();

 /* Draw the legend */ 
 $myScatter->drawScatterLegend(280,380,array("Mode"=>LEGEND_HORIZONTAL,"Style"=>LEGEND_NOBORDER)); 

 /* Render the picture (choose the best way) */ 
 $myPicture->autoOutput("pictures/example.drawScatterLineChart.png");  

?>

