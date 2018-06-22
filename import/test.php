<?php
set_time_limit(0);

// PREPARE MYSQL CONNECTION
$host = '192.168.12.210'; 
$user = 'mccsas';
$password = 'yHSUhsb89H';
$db = 'mccsas';




// CONNECT WITH MYSQL
$con = mysql_connect($host,$user,$password);
if (!$con)
{
    die('Could not connect: ' . mysql_error());
}
else
{
    $db = mysql_select_db($db, $con);
}


// START IMPORTING ACCOUNT IN THE TABLE
// OPEN CSV FILE FOR TABLE HEADER

$csvfile = "sas_entry.csv";
$file = fopen($csvfile,"r"); 
$csv_header = fgetcsv($file);

$table_header = "sl_no,p_name,n_road,assmt_no,p_ward,p_block,p_112C,door_no,village,survey_no,area_cents,area_sqft,area_build,area_floors,area_ratio,undiv_right,p_use,tax_rate,p_year,enhancement_tax,value_cents,value_sqft,value_corn,value_total,guide_50,floor,c_year,age_build,depreciation_rate,type_const,b_value_sqft,b_guide_50,b_area_sqft,build_type,land_tax_value,build_tax_value,app_tax,b_enhc_tax,b_cess,b_tot_tax,challan_no,property_tax,penalty_112C,cess,SWM_cess,adjustment,penalty,rebate,p_total,name_bank,name_branch,payment_date";
$table_header_array = explode(", ", $table_header);

$table_csv_order = "";

//ARRANGE TABLE COLUMN WITH CSV COLUMN
foreach($csv_header as $col)
{
    if( in_array($col, $table_header_array) )
    {
        $table_csv_order .= $col . ",";
    }
    else
    {
        $table_csv_order .= "@dummy,";
    }
}
$table_csv_order = rtrim($table_csv_order, ",");

// CREATE TEMP TABLEydetails
$table_script ="CREATE TABLE IF NOT EXISTS `TMP_sasentry` (
  `sl_no` int(10) NOT NULL AUTO_INCREMENT,
  `p_name` varchar(100) NOT NULL,
  `n_road` varchar(100) NOT NULL,
  `assmt_no` int(20) NOT NULL,
  `p_ward` varchar(50) NOT NULL,
  `p_block` varchar(50) NOT NULL,
  `p_112C` varchar(1) NOT NULL,
  `door_no` varchar(50) NOT NULL,
  `village` varchar(50) NOT NULL,
  `survey_no` varchar(50) NOT NULL,
  `area_cents` decimal(20,18) NOT NULL,
  `area_sqft` decimal(10,3) NOT NULL,
  `area_build` decimal(10,2) NOT NULL,
  `area_floors` decimal(10,2) NOT NULL,
  `area_ratio` decimal(5,3) NOT NULL,
  `undiv_right` decimal(21,19) NOT NULL,
  `p_use` varchar(20) NOT NULL,
  `tax_rate` varchar(10) NOT NULL,
  `p_year` varchar(10) NOT NULL,
  `enhancement_tax` varchar(10) NOT NULL,
  `value_cents` decimal(10,2) NOT NULL,
  `value_sqft` decimal(10,2) NOT NULL,
  `value_corn` decimal(10,2) NOT NULL,
  `value_total` decimal(10,2) NOT NULL,
  `guide_50` decimal(10,3) NOT NULL,
  `floor` int(3) NOT NULL,
  `c_year` int(4) NOT NULL,
  `age_build` int(3) NOT NULL,
  `depreciation_rate` decimal(10,5) NOT NULL,
  `type_const` varchar(50) NOT NULL,
  `b_value_sqft` int(10) NOT NULL,
  `b_guide_50` decimal(10,2) NOT NULL,
  `b_area_sqft` decimal(10,2) NOT NULL,
  `build_type` decimal(1,1) NOT NULL,
  `land_tax_value` decimal(20,10) NOT NULL,
  `build_tax_value` decimal(10,6) NOT NULL,
  `app_tax` int(10) NOT NULL,
  `b_enhc_tax` int(10) DEFAULT NULL,
  `b_cess` int(10) DEFAULT NULL,
  `b_tot_tax` int(10) NOT NULL,
  `challan_no` int(20) DEFAULT NULL,
  `property_tax` int(10) DEFAULT NULL,
  `penalty_112C` int(10) DEFAULT NULL,
  `cess` decimal(10,2) DEFAULT NULL,
  `SWM_cess` decimal(10,2) DEFAULT NULL,
  `adjustment` decimal(10,2) DEFAULT NULL,
  `penalty` decimal(10,2) DEFAULT NULL,
  `rebate` decimal(10,2) DEFAULT NULL,
  `p_total` decimal(10,2) DEFAULT NULL,
  `name_bank` varchar(50) NOT NULL,
  `name_branch` varchar(50) NOT NULL,
  `payment_date` date DEFAULT NULL,
  PRIMARY KEY (`sl_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 " ;



// CALL IMPORT FUNCTION
import_using_onload($table_script, "sasentry", $csvfile, $table_csv_order); 
fclose($file);

//---------------------------------------xxxxxxxxxxxxxxxx----------------------------------------//
//---------------------------------------xxxxxxxxxxxxxxxx----------------------------------------//

function import_using_onload($table_script, $tbl_name, $csv_file_name, $table_csv_order)
{
    // SET MYSQL DATABASE DETAILS
    $host = '192.168.12.210'; 
    $user = 'mccsas';
    $password = 'yHSUhsb89H';
    $db = 'mccsas';

    // CONNECT TO MYSQL SERVER
    $pdo = '';
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$db", 
            $user, $password,
            array(
                PDO::MYSQL_ATTR_LOCAL_INFILE => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            )
        );
    } catch (PDOException $e) {
        die("database connection failed: ".$e->getMessage());
    }
    
    //CREATE TEMP TABLE
    $affectedRows = $pdo->exec($table_script);
    
    
    // SET CSV PARAM
    $fieldseparator = ",";
    $lineseparator = "\n";
	$escpby = '\\';
    
    // BULK INSERT INTO TEMP TABLE
    $affectedRows = $pdo->exec("LOAD DATA LOCAL INFILE ".$pdo->quote($csv_file_name)." INTO TABLE `TMP_".$tbl_name."` 
        FIELDS TERMINATED BY ".$pdo->quote($fieldseparator)." ENCLOSED BY '\"' LINES TERMINATED BY '\r\n' 
		IGNORE 1 LINES
        (".$table_csv_order.")");   
 
    
   
    
        $affectedRows = $pdo->exec("INSERT INTO `tbl_".$tbl_name."` SELECT * FROM `TMP_".$tbl_name."`");

    
    
    // DROP TEMP TABLE FROM DATABASE
    $affectedRows = $pdo->exec("DROP TABLE `TMP_".$tbl_name."`");
    
    $pdo = NULL;
}


?>