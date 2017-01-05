<?php
include('connection.php');
$insert="insert into tbl_user set vchFirst_Name='".$_POST['firstname']."',vchLast_Name='".$_POST['lastname']."',vchEmail='".$_POST['Email']."',vchCountry='".$_POST['country']."',vchZip_Code='".$_POST['Zip']."',vchAddress='".$_POST['Address']."',vchPhone_Number='".$_POST['PhoneNo']."',vchUser_Name='".$_POST['username']."',vchpassword='".$_POST['Password']."',vchToken='".$_POST['Token']."',vchRoleType='".$_POST['role-type']."'";
$result = mysql_query($insert);
$last_id = mysql_insert_id();
if($result)
{ 
if(isset($_POST['role-type']) && $_POST['role-type']=='Hire')
{

 ?>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript">
function submitform()
{
    document.frmProdPaypal.submit();
}
window.onload = submitform;

$(window).load(function() {
 $(".loader").fadeOut("slow");
})
</script>

<div class="loader"></div>
<form name="frmProdPaypal" id="frmPaypal" action="https://sandbox.paypal.com/cgi-bin/webscr" method="post">
<table align="center">
<tr>
<td align="center">Reddirecting to paypal please wait....</td>
</tr>
<tr>
<td><img src="images/page-loader.gif"></td>
</tr>
</table>
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="business" value="taranjit_wadhwa@yahoo.co.in"> <!--billingdesk@rrtechnosolutions.com -->

<input type="hidden" name="amount" value="<?php echo $_POST['Token']; ?>">
<input type="hidden" name="custom" value="<?php echo $last_id;?>">
<input type="hidden" name="cancel_return" value="http://localhost/freelancer/freelance/cancel.php">
<input type="hidden" name="return" value="http://localhost/freelancer/freelance/success.php">
<input type="hidden" name="cbt" value="RETURN TO Freelancer WEBSITE" />
<input type="hidden" name="rm" value="2">
<input type="hidden" name="currency_code" value="USD">
</form>

<?php 
}

}

?>