
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="//cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script>
<script type="text/javascript" src="https://tamco.fast-option.com/templates/js/jszip.js"></script>
<script type="text/javascript" src="https://tamco.fast-option.com/templates/js/jszip-utils.js"></script>
<script type="text/javascript" src="https://tamco.fast-option.com/templates/js/FileSaver.js"></script>
<div class="centercontent tables">
  <div id="contentwrapper" class="contentwrapper">
    <div class="contenttitle2">
      <h3>
     
     Invoice detail( <?=$invoiceData[0]['r_invoice'];?>)
  
      </h3>
      
      <br />
    </div>
 
   
		<a onclick="javascript:printDiv('printme')" style="cursor:pointer;" >
		<button style="float:right;" class="btn btn-danger">Print</button>
		</a>
        <input class="btn-primary" type="button" onclick="create_zip();"  value="Export to Excel" style="float:;">
 <br />
	

    
   
    <div id="printme" style="100%;" > 
    
    
    <!-- This code is for print button -->
     <script language="javascript">
            function printDiv(divName)
			 {
                  var printContents = document.getElementById(divName).innerHTML;
                  var originalContents = document.body.innerHTML;
 
                  document.body.innerHTML = printContents;
                  window.print();
                  document.body.innerHTML = originalContents;
            }
     </script>
     
    <!-- Export To Excel -->
   
      <!-- Export To Excel -->
    
    <style type="text\css" media="print">
	@media #print
	{
	  display: none;
	}
	</style>

      
	<style>
    table, th, td
	{
    border: 1px solid black;
    padding:2px;
    }
    th 
	{
    background-color: #CCC;
    color: #000;
    width:10%;
    }
    </style>
   
     <br />
     
        <table id="print" cellpadding="0"  cellspacing="0" border="0" style="margin:0 auto;"  >
<!--<div>
<span style="float:left;"><b style="font-size:22px;">Invoice Number:- {$data1[0].invoice_id}</b><br />
            <b>Customer Name:-&nbsp;{$functions->getCustomerNameInPaymentInfo($data1[0].cust_id,'name')}</b> <br />
            <b>Date:- {$today}</b></span>
            <span style="float:right; "><img src="{$site_url}/logofolder/{$LOGO}"  /><br />{$company_name}</span>
</div>
<br /><br /><br /><br /><br />-->
<tr><td colspan="5"></td><td colspan="3" style="text-align:center;"><strong>Tax Invoice - فاتورة ضريبية</strong></td><td colspan="9"></td></tr>
        <tr  >
      <td colspan="5" style="padding:2%;">
			<b>UID Account Number:-&nbsp;<?=GetcustomerTable($invoiceData[0]['cust_id'],'uniqueid');?> - رقم الحساب</b><br/> 
			
			<b>Customers Name:-&nbsp;<?=GetcustomerTable($invoiceData[0]['cust_id'],'company');?> - اسم العميل</b> <br/>
			
			<b>Address:-&nbsp;<?=GetcustomerTable($invoiceData[0]['cust_id'],'address');?>,<?=Get_name_country_by_id('city',GetcustomerTable($invoiceData[0]['cust_id'],'city'));?> , <?=Get_name_country_by_id('country',GetcustomerTable($invoiceData[0]['cust_id'],'city'));?>  - عنوان</b><br/>
			
			 <b>Bank Account Number:-<?=GetcustomerTable($invoiceData[0]['cust_id'],'account_number');?> - الحساب البنكي</b><br/>
		  
		  	<b>Account Manager:-<?=GetcustomerTable($invoiceData[0]['cust_id'],'account_manager');?></b>
		  <br/>
		  <b>Vat Id No.:-&nbsp;<?=GetcustomerTable($invoiceData[0]['cust_id'],'vat_no');?>- الرقم الضريبي </b>
		  <br/>
		   <b>Currency:-SAR</b>
			</td>
           <td colspan="3" align="center">
    <img src="<?=base_url().site_configTable('logo');?>" height="100px;"/></td>
    <td colspan="9">
      <b align="left"><?=site_configTable('company_name');?>  – <?=site_configTable('company_address');?>
 </b><br/>
    <b>Vat Id No.:-&nbsp;<?=site_configTable('vat');?> - الرقم الضريبي </b><br/>
    <b>Invoice No:-&nbsp;<?=$invoiceData[0]['r_invoice'];?> - رقم الفاتورة</b><br/>
    <b>Invoice Date:-&nbsp;<?=$invoiceData[0]['invoice_date'];?> - تاريخ الفاتورة</b>
    </td>
        </tr>
        <tr>
          <td colspan="18" align="justify">&nbsp;</td>
        </tr>
        <tr>
          <th >Sr.No.</th>
         
           <th>Ref No. / الرقم المرجعي</th>
			 <th>Awb No / رقم البوليصة</th>
         
        
          <th>Close Date / تاريخ التوصيل</th>
		<th>Delivery Attempts</th>	
         
          <th>Origin / المصدر</th>
          <th>Destination / الوجهة</th>
          <th>Weight (Kg) / الوزن</th>
			   <th>No. of Pieces / عدد القطع</th>
          <th>Service Type / نوع الخدمة</th>        
           <th>COD Amount / قيمة التحصيل</th>
          <th>COD fees / رسوم التحصيل</th>
           <th>Return Charge / قيمة الإرجاع</th>     
          <th>Shipping Service / المجموع الصافي</th>
			 <th>Total</th>
			 <th>VAT</th> 
			<th>Grand Total</th>
       
        </tr>

     
	
		<?php
		$total_cod_amount=0;
		$total_collect_add=0;
		$total_service_add=0;
		$returnCharges=0;
		$totalchargeShow=0;
		$totalvatShow=0;
		$totalgrandShow=0;
		foreach($invoiceData as $key=>$rowData)
		{	
		$cod_charge=$rowData['cod_charge'];
		 $return_charge=$rowData['return_charge'];
		$service_charge=$rowData['service_charge'];
		
		$totalamount=$cod_charge+$return_charge+$service_charge;
		
		$totalvat=5/100*$totalamount;
		 $grandTotal=$totalamount+$totalvat;
		
		$total_cod_amount+=$rowData['cod_amount'];
		$total_collect_add+=$rowData['cod_charge'];
		$total_service_add+=$rowData['service_charge'];
		$returnCharges+=$rowData['return_charge'];
		
		$totalchargeShow+=$totalamount;
		$totalvatShow+=$totalvat;
		$totalgrandShow+=$totalchargeShow+$totalvatShow;
		$counter=$key+1;
     echo' <tr>
        <td align="center">'.$counter.'</td>
		   <td align="center">'.$rowData['refrence_no'].'</td>
        <td align="center">'.$rowData['awb_no'].'</td>
        
        
       
        <th>'.$rowData['close_date'].'</th>
        <td align="center">'.$rowData['d_attempt'].'</td>
        <td align="center">'.$rowData['origin'].'</td>
        <td align="center">'.$rowData['destination'].'</td>
		
       <td style="background-color:#AEFFAE;">
		'.$rowData['weight'].' Kg
       </td>
		   <td align="center">'.$rowData['qty'].'</td>
		<td align="center">'.$rowData['mode'].'/'.$rowData['status'].'</td>
		<td align="center">'.$rowData['cod_amount'].'</td>
		<td align="center">'.$rowData['cod_charge'].'</td>
        <td align="center">'.$rowData['return_charge'].'</td>
		<td align="center">'.$rowData['service_charge'].'</td>
		<td align="center">'.$totalamount.'</td>
		  <td align="center">'.$totalvat.'</td>
		  <td align="center"> '.$grandTotal.'</td>
		  
		  
    <form action="" name="">
    <input type="hidden" name="invoic_no_b" id="invoic_no_b" value="'.$rowData['invoice_no'].'" />
    </form>
      </tr>'; 
		}
		?>
       <tr> 
        <td colspan="9" style="text-align:center; ">&nbsp;</td>
   		 <td style="text-align:right; font-size:18px;"><b> Total (SAR)</b>  </td>	
		
        </td>
        
          <td style="text-align:right; font-size:18px;"><b><?=$total_cod_amount;?> </b></td>
        <td style="text-align:right; font-size:18px;"><b><?=$total_collect_add;?> </b></td>
        <td style="text-align:right; font-size:18px;"><b><?=$returnCharges?> </b></td> 
        
       
        </td>
         <td style="text-align:right; font-size:18px;"><b> <?=$total_service_add;?>
      </b>
        </td>
		 <td align="center"><strong> <?=$totalchargeShow;?></strong></td>
		 <td align="center"><strong><?=$totalvatShow;?></strong></td>
		 <td align="center"><strong> <?=$totalgrandShow;?></strong></td>
        </tr> 
      </tbody>
   <tr> 
<td colspan="17">
   <table align="left" width="30%">
    
    <tr> <th colspan="2" >Summary - ملخص</th> </tr>
   <tr>
    <th>Total Customer Collection – اجمالي تحصيلات العميل</th><th>SAR <?=$total_cod_amount;?></th>
    </tr>
    <tr><td align="justify">Less: COD Fees - رسوم التحصيل</td><td align="center">SAR -<?=$total_collect_add;?></td></tr>

    <tr><td align="justify">Less: Shipment Charges - تكلفة توصيل الشحنات</td><td align="center">SAR -<?=$total_service_add;?></td></tr>
     <tr><td align="justify">Less: Return Charge – رسوم الإرجاع</td><td align="center">SAR -<?=$returnCharges;?></td></tr>

    <tr><td align="justify">Less: Bank fees – رسوم التحويل البنكي</td><td align="center">SAR 0</td></tr>
    <tr><td align="justify">Less: Discount - الخصم</td><td align="center">SAR 0</td></tr>

    <tr>
    <th align="justify">Total Invoice before VAT – اجمالي الفاتورة قبل الضريبة</th><th >SAR -<?=$totalchargeShow;?></th></tr>
   <!-- <td>{$vat}</td>-->
    </tr>
    <tr>
    <td>VAT Percentage  - نسبة الضريبة</td> <td align="center">5%</td> 
    </tr>
    <tr>
    <td>VAT Amount - قيمة الضريبة</td> <td align="center">SAR -<?=$totalvatShow;?></td>
    </tr>
    <tr>
    <th align="justify">Total Invoice after VAT - اجمالي الفاتورة بعد الضريبة</th><th >- <?=$totalgrandShow;?></th></tr>
    
   <th align="justify">Amount To be Transfered - اجمالي المبلغ الواجب تحويله</th><th >SAR <?php echo $total_cod_amount-$totalgrandShow; ?></th></tr> 
    </table>
    </td>
    </tr>  
    </table>

      <!-- Export To Excel -->
   <SCRIPT>

function create_zip() {
var tab_text = '<html xmlns:x="urn:schemas-microsoft-com:office:excel"><meta http-equiv="content-type" content="text/plain; charset=UTF-8"/>';
 tab_text = tab_text + '<head><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>';
 tab_text = tab_text + '<x:Name>Test Sheet</x:Name>';
 tab_text = tab_text + '<x:WorksheetOptions><x:Panes></x:Panes></x:WorksheetOptions></x:ExcelWorksheet>';
 tab_text = tab_text + '</x:ExcelWorksheets></x:ExcelWorkbook></xml><meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8"></head><body>';
 tab_text = tab_text + "<table border='1px'>";
//get table HTML code
 tab_text = tab_text + $('#print').html();
 tab_text = tab_text + '</table></body></html>';
  
  var zip = new JSZip();
zip.file(Date()+" Invoice.xls", tab_text);
zip.generateAsync({type:"blob"})
.then(function(content) {
    saveAs(content, Date()+"invoice.zip");
});
  

}

</SCRIPT>


 <form action='' id='new_form' method='POST'>
<input type='hidden' id='new_id' name='exceldata'>
 </form>

    
    

