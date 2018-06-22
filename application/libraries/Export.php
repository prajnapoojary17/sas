<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');


class Export{
    
    function to_excel($heading, $arrayData, $filename) {
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename='.$filename.'.xls');
         
          echo "<table>";
          
          echo "<tr>";
          
          foreach($heading as $headingVal)
                {
                  echo "<th>".$headingVal."</th>";
                }
          
             echo "</tr>";      
                
          /*  echo "<pre>";
             print_r($arrayData);
             echo "</pre>";*/
             
                foreach($arrayData as $arrayDataObj){
                    
                    echo "<tr>";
                
                    foreach($arrayDataObj as $arrayDataObjVal)
                    {
                           echo "<td>".$arrayDataObjVal."</td>";
                    }
                    
                echo "</tr>";
                }
                
                echo "</table>";
                
            
        }
  
}
?>