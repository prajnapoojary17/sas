<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');


class Csvexport{
    
    function to_excel($heading, $arrayData, $filename) {
        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename='.$filename.'.xls');
         
          echo "<table>";
          
          echo "<tr>
        
                                             <th colspan='6' rowspan='2'>Property Details</th>
                                            <th rowspan='2'>Assessment Year</th>
                                            <th colspan='4' rowspan='2'>Opening Balance</th>
                                            <th colspan='8'>Demand</th>
                                            <th colspan='4' rowspan='2'>Receipts</th>
                                            <th colspan='3' rowspan='2'>Adjustments</th>
                                            <th colspan='3' rowspan='2'>Balance</th>
                                           
                                        </tr>
                                        <tr>
                                            <td colspan='4'>Self Assessment (SAS)</td>
                                            <td colspan='4'>ULB Assessment (CAL)*</td>
                                        </tr>
										 <tr>";
										
          foreach($heading as $headingVal)
                {
                  echo "<th>".$headingVal."</th>";
                }
          
             echo "</tr>";      
                
        
			  echo "<tr>";
         
											   
                                          
                foreach($arrayData as $arrayDataObj){
                    
                   
                 
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