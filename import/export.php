<?php
ini_set('max_execution_time', 300); //300 seconds = 5 minutes
$dbName = "C:\Users\Prajna\Downloads\mc\SAS_DATA.mdb";

//phpinfo();exit;
if (!file_exists($dbName)) {
    die("Could not find database file.");
}
$db = new PDO("odbc:DRIVER={Microsoft Access Driver (*.mdb)}; DBQ=$dbName; Uid=; Pwd=;");
$sql="select * FROM Properties;";




$result = $db->query($sql);
$count = $result->columnCount();

$file_ending = "xls";
//header info for browser
$filename="testmcc_15032017";
header("Content-Type: application/xls");    
header("Content-Disposition: attachment; filename=$filename.xls");  
header("Pragma: no-cache"); 
header("Expires: 0");
/*******Start of Formatting for Excel*******/   
//define separator (defines columns in excel & tabs in word)
$sep = "\t"; //tabbed character
//start of printing column names as names of MySQL fields


print("\n");    
//end of printing column names  
//start while loop to get data
    while($row = $result->fetch())
    {
        $schema_insert = "";
        for($j=0; $j<$count;$j++)
        {
            if(!isset($row[$j]))
                $schema_insert .= "NULL".$sep;
            elseif ($row[$j] != "")
                $schema_insert .= "$row[$j]".$sep;
            else
                $schema_insert .= "".$sep;
        }
        $schema_insert = str_replace($sep."$", "", $schema_insert);
        $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
        $schema_insert .= "\t";
        print(trim($schema_insert));
        print "\n";
    }   
	
	
	



?>