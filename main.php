<?php
function _n($num){
	if(strpos($num, ',') !== false)
	 return str_replace(',', '.', $num);
	else 
		return $num;
	
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
			if($row == 2){
				$p_ar[$c] = $data_c;
				
				continue;
			}
			if($c == 0)
				continue;
			else {
				$ar[$p_ar[$c]][] = array($data[0], $data_c); 
			}
			
        }
       
      // if($row == 3)break;
    }
    fclose($handle);
     var_dump($ar[3]);
}

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
