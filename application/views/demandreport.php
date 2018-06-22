<?php
/**
 * User Manage script
 * @author = Glowtouch
 */
include ('common/header.php');
?>
<div class="page-content-wrapper">
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    <i class="fa fa-user"></i> Demand Collection Report
                    <div class="date-display">
                        <i class="icon-calendar"></i>
                        <span id="datetime"></span>
                        <span id="datetime2"></span>
                    </div>
                </h3>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <!-- END PAGE HEADER-->
        <!-- BEGIN CONTENT -->
        <div class="row">
            <div class="col-lg-12">
                <div class="portlet box green-seagreen">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-industry"></i>Property details
                        </div>
                        <div class="tools">
                            <a href="javascript:;" class="collapse">
                            </a>
                            <a href="javascript:;" class="remove">
                            </a>
                        </div>
                    </div>
                    <?php
                    $upi = '';
                    if (isset($_GET['upi'])) {
                        $upi = $_GET['upi'];
                    }
                    $asstno = '';
                    if (isset($_GET['asstno'])) {
                        $asstno = $_GET['asstno'];
                    }
                    ?>
                    <div class="portlet-body">
                        <div class="row">
                            <form class="form-horizontal form-striped class" action="" method="get" name="demandtax" id="demandtax">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="col-sm-6 control-label">UPI</label>
                                        <div class="col-sm-6">
                                            <input type="text" name="upi" id="upi" class="form-control CCInput" value="<?php echo $upi ?>">
                                        </div>
                                    </div>									
                                    <div class="form-group">
                                        <label class="col-sm-6 control-label">Ward</label>
                                        <div class="col-sm-6">      

                                            <select class="form-control select2me CCInput" name="ward" id="ward">	
                                                <option  value="" selected>Select</option>											 
                                                <?php
                                                for ($w = 0; $w < count($ward); $w++) {
                                                    ?>
                                                    <option  value="<?php echo $ward[$w]->ward_name; ?>" <?php
													if(isset($_GET['ward']))
													{
                                                             if (($ward[$w]->ward_name) == ($_GET['ward'])) {
                                                                 echo "selected";
                                                             }
															 }
                                                             ?>><?php echo $ward[$w]->ward_name; ?></option>
    <?php }
?>
                                            </select>
                                        </div>
                                    </div>										                                 
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="col-sm-6 control-label">Assessment No</label>
                                        <div class="col-sm-6">
                                            <input type="text" name="asstno" id="asstno" class="form-control" value="<?php echo $asstno ?>">
                                        </div>
                                    </div>	

                                    <div class="form-group">
                                        <label class="col-sm-6 control-label">From</label>
                                        <div class="col-sm-6">
                                            <select class="form-control select2me CCInput" name="fromdate" id="fromdate" >	
                                                <option  value="">Select</option>											
                                                <?php
                                                for ($s = 0; $s < count($selectyear); $s++) {
                                                    ?>
                                                    <option  value="<?php echo $selectyear[$s]->e_year; ?>" <?php
													if(isset($_GET['fromdate']))
													{
                                                        if (( $selectyear[$s]->e_year) == ($_GET['fromdate'])) {
                                                            echo "selected";
                                                        }
														}
                                                        ?>>
    <?php echo $selectyear[$s]->e_year; ?></option>                                                       
<?php } ?>
                                            </select>
                                        </div>
                                        <label class="col-sm-6 control-label">To</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control CCInput" value="<?php if (isset($_GET['todate'])) echo $_GET['todate'] ?>" id="todate" name="todate">
                                        </div>
                                    </div>

                                </div>                                     									 
                                <div class="col-lg-4">
                                    <button type="submit" class="btn btn-flat btn-green" id="id" name="id"><i class="fa fa-eye"></i> View Reports</button>
                                    <button type="submit" class="btn btn-flat btn-dark" id="reset" onclick="myFunction()" name="reset"><i class="fa fa-repeat"></i> Reset</button>
                                </div>
                            </form>
                        </div>
                        <hr class="arrow-line">					                    	
                        <div class="table-responsive">

                            <div class="table-responsive custom_datatable">
                                <?php
                                if (isset($page_links)) {
                                    echo $page_links;
                                }
                                ?>  
                                <span class="total_record" style="margin-top: 14px;"> Total Records : <span style="color:red"><?php
                                if (isset($total_record)) {
                                    echo $total_record;
                                }
                                ?></span></span>  &nbsp;&nbsp 
<?php if (isset($sidedata)) {
    ?><a href="<?php echo base_url(); ?>demandreport/printscreen?upi=<?php echo $_GET['upi'] ?>&ward=<?php echo $_GET['ward'] ?>&asstno=<?php echo $_GET['asstno'] ?>&fromdate=<?php echo $_GET['fromdate'] ?>&todate=<?php echo $_GET['todate'] ?>&per_page=<?php if (isset($_GET['per_page'])) {
        echo $_GET['per_page'];
    } ?>"  target="_blank" class="btn btn-danger tooltips pull-right" data-placement="left" title="" data-original-title="Print"><i class="fa fa-print"></i></a>
<?php } ?>

                                <table class="table table-bordered">
                                    <tbody><tr>
                                            <th rowspan="2" align="center">Property Details</th>
                                            <th rowspan="2" align="center">Assessment Year</th>
                                            <th colspan="4" align="center" rowspan="2">Opening Balance</th>
                                            <th colspan="8" align="center">Demand</th>
                                            <th colspan="4" align="center" rowspan="2">Receipts</th>
                                            <th colspan="3" align="center" rowspan="2">Adjustments</th>
                                            <th colspan="3" align="center" rowspan="2">Balance</th>
                                        </tr>
                                        <tr>
                                            <td colspan="4" align="center">Self Assessment (SAS)</td>
                                            <td colspan="4" align="center">ULB Assessment (CAL)*</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td align="center">Property Tax</td>
                                            <td align="center">Cess</td>
                                            <td align="center">Others</td>
                                            <td align="center">Total Amount
                                                <br>3+4+5</td>
                                            <td align="center">Property Tax</td>
                                            <td align="center">Cess</td>
                                            <td align="center">Others</td>
                                            <td align="center">Total Amount
                                                <br>6+7+8</td>
                                            <td align="center">Property Tax </td>
                                            <td align="center">Cess </td>
                                            <td align="center">Others </td>
                                            <td align="center">Total Amount (9+10+11) </td>
                                            <td align="center">Date</td>
                                            <td align="center">Amount</td>
                                            <td align="center">Property Tax</td>
                                            <td align="center">Cess</td>
                                            <td align="center">Type &amp; Reference</td>
                                            <td align="center">Property Tax Adjusted</td>
                                            <td align="center">Cess Adjusted</td>
                                            <td align="center">Property Tax</td>
                                            <td align="center">Cess</td>
                                            <td align="center">Total Amount</td>
                                        </tr>																								  
                                        <?php
                                        $i = 0;
                                        if (!empty($_GET['fromdate'])) {
                                            $fromdate = $_GET['fromdate'];
                                            $whereStr = explode("-", $fromdate);
                                            if (!isset($whereStr[0])) {
                                                $whereStr[0] = null;
                                            }
                                            if (!isset($whereStr[1])) {
                                                $whereStr[1] = null;
                                            }
                                            $bdate = $whereStr[0] - 1;
                                            $bdate1 = $whereStr[1] - 1;
                                            $beforedate = $bdate . '-' . $bdate1;
                                            $btw = $whereStr[0] + 1;
                                            $btw1 = $whereStr[1] + 1;
                                            $between = $btw . '-' . $btw1;
                                            $todate = $_GET['todate'];
                                        } else {
                                            $fromdate = '';
                                            $todate = '';
                                            $beforedate = '';
                                            $between = '';
                                        }
                                        if (isset($sidedata)) {
                                            $len = count($sidedata);


                                            for ($y = 0; $y < $len; $y++) {
                                                $door_no = $sidedata[$y]->door_no;
                                                $door_no = strip_tags($door_no);
                                                $ward = $sidedata[$y]->p_ward;
                                                $upi = $sidedata[$y]->upi;
                                                $block = $sidedata[$y]->p_block;
                                                $p_name = $sidedata[$y]->p_name;
                                                $assmt_no = $sidedata[$y]->assmt_no;
                                                $obcb = display_datas($ward, $upi, $assmt_no, $beforedate, $fromdate, $between, $todate);
                                                $countrecord = count($obcb);
                                                ?>      
                                                <tr>
                                                    <td rowspan="<?php echo $countrecord + 1 ?>" class="property_col">									
                                                        <p>Assessment No/UPI: <span class="text-uppercase"><?php
                                                echo $ass = $sidedata[$y]->assmt_no;
                                                echo "/";
                                                echo $ass = $sidedata[$y]->upi;
                                                ?>	</span>											
                                                        </p>
                                                        <p style="font-weight:bold">Name of the owner: <span class="text-uppercase"><?php echo $sidedata[$y]->p_name; ?></span>
                                                        </p>
                                                        <p>Address of the owner: <span class="text-uppercase"><?php echo $sidedata[$y]->n_road; ?></span>
                                                        </p>
                                                        <p>Location: <span class="text-uppercase"><?php echo $sidedata[$y]->village; ?></span>
                                                        </p>
                                                        <p>Measurement: <span class="text-uppercase"><?php echo $sidedata[$y]->area_build; ?></span>
                                                        </p>
                                                        <p>Door Number: <span class="text-uppercase"><?php echo $sidedata[$y]->door_no; ?></span>
                                                        </p>
                                                    </td>
        <?php ?>					
                                                    <td> &lt;Suspense&gt; </td>
                                                    <td>--</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td>--</td>
                                                    <td>--</td>
                                                    <td>--</td>
                                                    <td>--</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>

                                                </tr>
                                                <?php
                                                foreach ($obcb as $key => $object) {
                                                    $assyear = $obcb[$key]->p_year;
                                                    if ($key != 0) {
                                                        $ob_tax = $obcb[$key - 1]->col3;
                                                        $ob_cess = $obcb[$key - 1]->col4;

                                                        $prevpayment_date = $obcb[$key - 1]->payment_date;
                                                    } else {
                                                        $ob_tax = 0;
                                                        $ob_cess = 0;

                                                        $prevpayment_date = '';
                                                    }
                                                    $adjtax = $obcb[$key]->taxadj;
                                                    $adjcess = $obcb[$key]->cessadj;
                                                    $cb_tax = $obcb[$key]->col3;
                                                    $cb_cess = $obcb[$key]->col4;
                                                    $payment_date = $obcb[$key]->payment_date;
                                                    $b_enhc_tax = $obcb[$key]->b_enhc_tax;
                                                    $b_cess = $obcb[$key]->b_cess;
                                                    $cess = get_cess($assyear);
                                                    $cess_percent = $cess / 100;
                                                    $property_tax = $obcb[$key]->property_tax;
                                                    $cess = $obcb[$key]->cess;
                                                    $rebate = $obcb[$key]->rebate;
                                                    $rebate = round($rebate);
                                                    ?>

                                                    <tr> 
                                                        <td><?php echo $assyear ?></td>
                                                        <?php if (($ob_tax + $ob_cess) > 0) {
                                                            ?>
                                                            <td><?php echo $ob_tax ?></td>
                                                            <td><?php echo $ob_cess ?></td>
                                                            <td></td>
                                                            <td><?php echo $ob_tax + $ob_cess ?></td>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
            <?php } ?>
                                                        <td><?php echo $b_enhc_tax . ".00" ?></td>
                                                        <td><?php echo $b_cess . ".00" ?></td>
                                                        <td></td>
                                                        <td><?php echo $b_enhc_tax + $b_cess ?></td>
                                                        <td>--</td>
                                                        <td>--</td>
                                                        <td>--</td>
                                                        <td>--</td>													
                                                        <td style="white-space:pre;"><?php
                                                            $payment_date = $obcb[$key]->payment_date;
                                                            if (($payment_date == '0000-00-00') || ($payment_date == '')) {
                                                                echo "";
                                                            } else {
                                                                $timestamp = strtotime($payment_date);
                                                                echo $date = date('d-m-Y', $timestamp);
                                                            }
                                                            ?></td>
                                                        </td>
                                                        <td><?php echo $property_tax + $cess ?></td>
                                                        <td><?php echo $property_tax ?></td>
                                                        <td><?php echo $cess ?></td>
                                                            <?php if (($prevpayment_date == "") || ($prevpayment_date == "0000-00-00")) {
                                                                ?>	

                                                            <td><?php
                                                if ($rebate > 0) {
                                                    echo "Rebate/" . $rebate . "";
                                                } else {
                                                    echo "";
                                                }
                                                                ?></td>
                                                            <td></td>
                                                            <td></td>
                                                                <?php
                                                            } else {
                                                                ?>
                                                            <td>
                                                                <?php
                                                                if ((($rebate > 0) && ($adjtax + $adjcess) > 0)) {
                                                                    echo "Rebate/" . $rebate . "";
                                                                    echo "<br>";
                                                                    echo "Reduction in Demand";
                                                                } elseif ((($rebate > 0) && ($adjtax + $adjcess) < 0)) {
                                                                    echo "Rebate/" . $rebate . "";
                                                                    echo "<br>";
                                                                    echo "Increase in Demand";
                                                                } elseif ($rebate > 0) {

                                                                    echo "Rebate/" . $rebate . "";
                                                                } elseif (($adjtax + $adjcess > 0)) {
                                                                    echo "Reduction in Demand";
                                                                } elseif (($adjtax + $adjcess < 0)) {
                                                                    echo "Increase in Demand";
                                                                } else {
                                                                    echo "";
                                                                }
                                                                ?>																		
                                                            </td>
                                                            <td> <?php echo $adjtax ?> </td>
                                                            <td> <?php echo $adjcess ?> </td>

                                                            <?php
                                                        }
                                                        $year = date("Y");
                                                        $coyear = date("y");
                                                        $addcoyear = $coyear + 1;
                                                        $curyear = $year . '-' . $addcoyear;

                                                        if (($curyear) == ($assyear)) {
                                                            ?>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                    <?php
                                                    } else {
                                                        ?>
                                                            <td><?php echo $cb_tax ?></td>
                                                            <td><?php echo $cb_cess ?></td>
                                                            <td><?php echo $cb_tax + $cb_cess; ?></td>

                                                        </tr><?php
                                            }
                                        }
                                    }
                                }
                                ?>  
                                </table>
<?php
if (isset($page_links)) {
    echo $page_links;
}
?> 
                            </div>
                        </div> </div>
                </div>
            </div>
        </div>
        <!-- END CONTENT -->

    </div>
</div>
</div>
<?php
/**
 * User Manage script
 * @author = Glowtouch
 */
include ('common/footer.php');

function objectToArray($d) {
    if (is_object($d)) {
        // Gets the properties of the given object
        // with get_object_vars function
        $d = get_object_vars($d);
    }

    if (is_array($d)) {
        /*
         * Return array converted to object
         * Using __FUNCTION__ (Magic constant)
         * for recursive call
         */
        return array_map(__FUNCTION__, $d);
    } else {
        // Return array
        return $d;
    }
}
?>

<script type="text/javascript">
    $(document).ready(function ()
    {
        $('#fromdate').click(function ()
        {
            var value = $('select[name=fromdate]').val()
            if (value == '')
            {
                $("#todate").empty();
                return;
            }
            var myarr = value.split("-");
            var myvar = myarr[0] + ":" + myarr[1];
            var x = myarr[0];
            var y = myarr[1];
            var z = 2;
            var a = parseFloat(x) + parseFloat(z);
            var b = parseFloat(y) + parseFloat(z);
            var actval = a + "-" + b;
            $('#todate').val(actval);
        });


    });
    function myFunction() {
        $(".class").find('.form-control').val('');
    }

</script>