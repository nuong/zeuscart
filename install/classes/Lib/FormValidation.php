<?php
class Lib_FormValidation extends Lib_Validation_Handler 
{
	function Lib_FormValidation($form)
	{
		if($form=='category')
			$this->validateCategory();
		else if($form=='register')
			$this->validateRegister();
		else if($form=='validatelogin')
			$this->validatelogin();
		else if($form=='subadminmail')
			$this->validateSubAdminEmail();
		else if($form=='subadminpass')
			$this->validateSubAdminPass();
		else if($form=='productreg')
			$this->validateEntry();
		else if($form=='attributes')
			$this->validateAttributes();	
		else if($form=='adminemail')
			$this->validateAdminEmail();			
		else if($form=='productupdate')
			$this->validateUpdateEntry();
		else if($form=='useraccregister')
			$this->validateUserRegister();
		else if($form=='frmship')
			$this->validateCheckout();
	}
	
	function validateCheckout()
	{
//echo 'welcome';
//print_r($_POST);exit;
		$message = "Required Field Cannot be blank";
		$this->Assign("txtname",trim($_POST['txtname']),"noempty",$message);
	//	$this->Assign("txtcompany",trim($_POST['txtcompany']),"noempty",$message);		
		$this->Assign("txtstreet",trim($_POST['txtstreet']),"noempty",$message);
		$this->Assign("txtcity",trim($_POST['txtcity']),"noempty",$message);
		$this->Assign("txtzipcode",trim($_POST['txtzipcode']),"noempty",$message);
		//$this->Assign("selbillcountry",trim($_POST['selbillcountry']),"noempty",$message);
		$this->Assign("txtstate",trim($_POST['txtstate']),"noempty",$message);
		
		$this->Assign("txtsname",trim($_POST['txtsname']),"noempty",$message);
	//	$this->Assign("txtscompany",trim($_POST['txtscompany']),"noempty",$message);
		$this->Assign("txtsstreet",trim($_POST['txtsstreet']),"noempty",$message);
		$this->Assign("txtscity",trim($_POST['txtscity']),"noempty",$message);
		$this->Assign("txtszipcode",trim($_POST['txtszipcode']),"noempty",$message);
		//$this->Assign("selshipcountry",trim($_POST['selshipcountry']),"noempty",$message);
		$this->Assign("txtsstate",trim($_POST['txtsstate']),"noempty",$message);
		$this->PerformValidation('?do=addUserProduct');
	}
	function validateUserRegister()
	{
		
		$message = "Required Field Cannot be blank/Alphanumeric not allowed/No special characters allowed";
		$this->Assign("txtfname",trim($_POST['txtfname']),"noempty/nonumber/nospecial''",$message);
		$message = "Required Field Cannot be blank/ Alphanumeric not allowed/No special characters allowed";
		$this->Assign("txtlname",trim($_POST['txtlname']),"noempty/nonumber/nospecial''",$message);
		$message = "Required Field Cannot be blank/No special characters allowed";
		$this->Assign("txtdisname",trim($_POST['txtdisname']),"noempty/nospecial''",$message);
		/*if(empty($_POST['txtemail']))
		{
		    $message = "Required Field Cannot be blank";
			$this->Assign("txtemail",'',"noempty",$message);
		}
		else if($this->validateEmailAddress($_POST['txtemail']))
		{
				exit;
				
		}
		else
		{
			
			$message = "Invalid Emails";
 			$this->Assign("txtemail",'',"noempty",$message);
		}*/
		$message = "Required Field Cannot be blank/Invalid Email";		
		$this->Assign("txtemail",trim($_POST['txtemail']),"noempty/emailcheck",$message);
		
		$message = "Required Field Cannot be blank";
		
		$this->Assign("txtpwd",trim($_POST['txtpwd']),"noempty",$message);
		$this->Assign("txtrepwd",trim($_POST['txtrepwd']),"noempty",$message);
		if(trim($_POST['txtpwd']) != '' and trim($_POST['txtrepwd']) != '')
		{
			$pwdlength =strlen($_POST['txtpwd']);
			if($pwdlength<6 or $pwdlength>20)
			{
				$message = "Password minimum length is 6 & maximum length is 20";
				$this->Assign("txtpwd","","noempty",$message);
			}
			elseif(trim($_POST['txtpwd']) != trim($_POST['txtrepwd']))
			{
				$message = "Enter the Confirm Password correctly";
				$this->Assign("txtrepwd","","noempty",$message);
				
			}
		}
		
		if(trim($_POST['txtfname']) != '' and trim($_POST['txtlname']) != '' and trim($_POST['txtdisname'])!='')
		{
			$fnamelength =strlen($_POST['txtfname']);
			$lnamelength =strlen($_POST['txtlname']);
			$dislength =strlen($_POST['txtdisname']);
			if($fnamelength<3 or $fnamelength>20)
			{
				$message = "Minimum length is 3";
				$this->Assign("txtfname","","noempty",$message);
			}
			if($lnamelength<3 or $lnamelength>20)
			{
				$message = "Minimum length is 3";
				$this->Assign("txtfname","","noempty",$message);
			}
			if($dislength<3 or $dislength>20)
			{
				$message = "Minimum length is 3";
				$this->Assign("txtdisname","","noempty",$message);
			}
		}
		
		
		/*if(trim($_POST['txtemail']) != '' and trim($_POST['txtremail']) != '')
		{
			if(trim($_POST['txtemail']) != trim($_POST['txtremail']))
			{
				$message = "Enter the Confirm Email id correctly";
				$this->Assign("txtremail","","noempty",$message);
				
			}
		}*/
		
		//$message = "Please select terms";
		//$this->Assign("chkterms",trim($_POST['chkterms']),"noempty",$message);
		
		if(trim($_POST['txtdisname']) != '')
		{
			$sqlselect = "select * from users_table where user_display_name='".$_POST['txtdisname']."'";
			$obj = new Bin_Query();
			if($obj->executeQuery($sqlselect))
			{
				if($obj->totrows>0)
				{
					$message = "Name already Exist in datatbase";		
					$this->Assign("txtdisname",'',"noempty",$message);
				}
			}
		}
		
		$this->PerformValidation('?do=addUserAccount');
	}
	function validateCategory()
	{
		$message = "Required Field Cannot be blank";
		$this->Assign("category",trim($_POST['category']),"noempty",$message);
		//$this->Assign("category",trim($_POST['group1']),"noempty/nonumber",$message);
		$this->PerformValidation('?do=managecategory');
	}
	
	function validateAttributes()
	{
		$attrib[] = explode(" ",$_POST['attributes']);
		
		$attributes=array_merge($attrib);
		
		$message = "Required Field Cannot be blank/Alphanumeric not allowed/No special characters allowed";
		
		$this->Assign("attributes",$attributes,"noempty/nonumber/nospecial''",$message);
			
		$this->PerformValidation('?do=addattributes');
	}
		
	function validatelogin()
	{
		$message = "Required Field Cannot be blank";
		$this->Assign("username",trim($_POST['username']),"noempty",$message);
		$this->Assign("username",trim($_POST['userpwd']),"noempty",$message);
		
		$username = $_POST['username'];
		$pswd = $_POST['userpwd'];
		$pswd  = base64_encode($pswd);
		//echo $ps= base64_decode('YWRtaW4=');
		
		if(trim($username) != '' and trim($pswd) != '')
		{
			//echo $sqlselect = "select * from admin_table where admin_name='".$username."'";
			$obj1 = new Bin_Query();
			$obj2 = new Bin_Query();
			$obj3 = new Bin_Query();
				//echo $_POST['txtpass'];exit;
				$sql = "select count(*) as temp from admin_table where admin_name='".$username."' and admin_password='".$pswd."'";
				$obj2->executeQuery($sql);
				
				if($obj2->records[0]['temp']==0)
				{
					$sqlsub = "select count(*) as temp from subadmin_table where subadmin_name='".$username."' and subadmin_password='".$pswd."'";
					$obj3->executeQuery($sqlsub);
					if($obj3->records[0]['temp']==0)
					{
						///$div="<div class='exc_msgbox'>"
						$message = "Invalid Username or Password";
						//return "Invalid Username or Password";
						$this->Assign("username",'',"noempty",$message);
					}
					else
					{
						$sqlsub = "select * from subadmin_table where subadmin_name='".$username."' and subadmin_password='".$pswd."' and subadmin_status=1";
						$obj3->executeQuery($sqlsub);
						$_SESSION['subadminId'] = $obj3->records[0]['subadmin_id'];
						$_SESSION['subadminName'] = $obj3->records[0]['subadmin_name'];
					}
				}
				else
				{
					$sql = "select * from admin_table where admin_name='".$username."' and admin_password='".$pswd."'";
					$obj2->executeQuery($sql);
					$_SESSION['adminId'] = $obj2->records[0]['admin_id'];
					$_SESSION['adminName'] = $obj2->records[0]['admin_name'];
				
				}
					
		}
		
		$this->PerformValidation("?do=adminlogin");
	}
	function validateSubAdminEmail()
	{
	 	
		if(empty($_POST['subadminemail']))
		{
		    $message = "Required Field Cannot be blank";
			$this->Assign("subadminemail",'',"noempty",$message);
		}
		else if($this->validateEmailAddress($_POST['subadminemail']))
		{
				
		}
		else
		{
			$message = "Invalid Emails";
 			$this->Assign("subadminemail",'',"noempty",$message);
		}
	//		$this->Assign("subadminemail",trim($_POST['subadminemail']),"noempty/emailcheck",$message);
		$message = "Required Field Cannot be blank";
		$this->Assign("subadminpassword",trim($_POST['subadminpassword']),"noempty",$message);
		$message = "Required Field Cannot be blank/Numeric Value is Not Accepted";
		$this->Assign("subadminname",trim($_POST['subadminname']),"noempty/nonumber",$message);
		$this->PerformValidation('?do=subadminmgt');
		
	}
	
	function validateAdminEmail()
	{
	 	
		if(empty($_POST['adminemail']))
		{
		    $message = "Required Field Cannot be blank";
			$this->Assign("adminemail",'',"noempty",$message);
		}
		else if($this->validateEmailAddress($_POST['adminemail']))
		{
				
		}
		else
		{
			$message = "Please Enter Valid Email ID";
 			$this->Assign("adminemail",'',"noempty",$message);
		}

		$message = "Required Field Cannot be blank";
		$this->Assign("subadminpassword",trim($_POST['adminemail']),"noempty",$message);
		$this->PerformValidation('?do=adminlogin&action=showpage');
		
	}
	
	
	function validateEntry()
	{
		$message = "Select the Main Category";
		$this->Assign("selcatgory",trim($_POST['selcatgory']),"noempty",$message);
		
		$message = "Select the Sub Category";
		$this->Assign("subcat",trim($_POST['subcat']),"noempty",$message);
		
		$message = "Required Field Cannot be blank";
  	 	$this->Assign("product_title",trim($_POST['product_title']),"noempty",$message);
		
		$message = "Required Field Cannot be blank";
		$this->Assign("sku",trim($_POST['sku']),"noempty",$message);
		
		$message = "Required Field Cannot be blank";
		$this->Assign("ufile",trim($_FILES['ufile']['name'][0]),"noempty",$message);
		
		if($_FILES['ufile']['name'][0]!='')
		{
			$count=count($_FILES['ufile']['type']);
			for($i=0;$i<$count;$i++)
			{
				if(!$this->validateimages($_FILES['ufile']['type'][$i]))
				{
					$message = "Upload images only in the format JPEG,JPG,PNG,BMP";
					$this->Assign("ufile_value",'',"noempty",$message);
				}
			}
		}
		
		$price=$_POST['price'];
		$msrp=$_POST['msrp'];
		
		$shipcost=(float)$_POST['shipcost'];
		$rol=$_POST['rol'];
		$soh=$_POST['soh'];
		
		if(strlen($price)>9)
		{
	 		$message = "Maximum Price exceed ";
	   	 	$this->Assign("price",'',"noempty",$message);
		}
		else if(empty($price))
		{
			$message = "Required Field Cannot be blank";
		   	 $this->Assign("price",trim($_POST['price']),"noempty",$message);
		}
		
		if(strlen($msrp)>9)
		{
	 		$message = "Maximum MSRP exceed";
	   	 	$this->Assign("msrp",'',"noempty",$message);
		}
		/*else if(empty($msrp))
		{
			$message = "Required Field Cannot be blank";
		   	$this->Assign("msrp",trim($_POST['msrp']),"noempty",$message);
		}*/
		 
		/*if($price>$msrp)
		{
			$message = "The Price should not exceed MSRP";
	   	 	$this->Assign("msrp",'',"noempty",$message);
		}*/

		if(!$this->validateFloat($shipcost))
		{
           		$message = "Shipping Cost is in Invalid format ";
	   	 	$this->Assign("shipcost",'',"noempty",$message);		 
		}
		if($rol!='')
		{
		 
			 if(!$this->validateFloat($rol))
			 {
					 $message = "ReOrder Level is in Invalid format ";
					 $this->Assign("rol",'',"noempty",$message);		 
			 }
		 }
 		 if($soh!='')
		 {   
		   	 if(!$this->validateFloat($soh))
			 {
					 $message = "Stock on hand is in Invalid format ";
					 $this->Assign("soh",'',"noempty",$message);		 
			 }
		 }

		$this->PerformValidation('?do=productentry');
	}
	
	function validateUpdateEntry()
	{
		$id=(int)$_GET['prodid'];
		$message = "Select the Main Category";
		$this->Assign("selcatgory",trim($_POST['selcatgory']),"noempty",$message);
		
		$message = "Select the Sub Category";
		$this->Assign("subcat",trim($_POST['subcat']),"noempty",$message);
		
		$message = "Required Field Cannot be blank";
  	 	$this->Assign("product_title",trim($_POST['product_title']),"noempty",$message);
		
		$message = "Required Field Cannot be blank";
		$this->Assign("sku",trim($_POST['sku']),"noempty",$message);
		
		$message = "Required Field Cannot be blank";
		$this->Assign("ufile",trim($_FILES['ufile']['name'][0]),"noempty",$message);
		
		if($_FILES['ufile']['name'][0]!='')
		{
			$count=count($_FILES['ufile']['type']);
			for($i=0;$i<$count;$i++)
			{
				if(!$this->validateimages($_FILES['ufile']['type'][$i]))
				{
					$message = "Upload images only in the format JPEG,JPG,PNG,BMP";
					$this->Assign("ufile_value",'',"noempty",$message);
				}
			}
		}
		
		$price=$_POST['price'];
		$msrp=$_POST['msrp'];
		
		$shipcost=$_POST['shipcost'];
		$rol=$_POST['rol'];
		$soh=$_POST['soh'];
		
		if(strlen($price)>9)
		{
	 		$message = "Maximum Price exceed ";
	   	 	$this->Assign("price",'',"noempty",$message);
		}
		else if(empty($price))
		{
			$message = "Required Field Cannot be blank";
		   	 $this->Assign("price",trim($_POST['price']),"noempty",$message);
		}
		
		if(strlen($msrp)>9)
		{
	 		$message = "Maximum MSRP exceed";
	   	 	$this->Assign("msrp",'',"noempty",$message);
		}
		/*else if(empty($msrp))
		{
			$message = "Required Field Cannot be blank";
		   	$this->Assign("msrp",trim($_POST['msrp']),"noempty",$message);
		}*/
		 
		/*if($price>$msrp)
		{
			$message = "The Price should not exceed MSRP";
	   	 	$this->Assign("msrp",'',"noempty",$message);
		}*/

		if(!$this->validateFloat($shipcost))
		{
           		$message = "Shipping Cost is in Invalid format ";
	   	 	$this->Assign("shipcost",'',"noempty",$message);		 
		}
		if($rol!='')
		{
		 
			 if(!$this->validateFloat($rol))
			 {
					 $message = "ReOrder Level is in Invalid format ";
					 $this->Assign("rol",'',"noempty",$message);		 
			 }
		 }
 		 if($soh!='')
		 {   
		   	 if(!$this->validateFloat($soh))
			 {
					 $message = "Stock on hand is in Invalid format ";
					 $this->Assign("soh",'',"noempty",$message);		 
			 }
		 }

		$this->PerformValidation('?do=manageproducts&action=editprod&prodid='.$id);
	}
	
	function validateEmailAddress($email) 
	{
		// First, we check that there's one @ symbol, and that the lengths are right
	    if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) 
		{
    		// Email invalid because wrong number of characters in one section, or wrong number of @ symbols.
			///echo 'it has more @values ';
			    return false;
        }
    	// Split it into sections to make life easier
	    $email_array = explode("@", $email);
    	$local_array = explode(".", $email_array[0]);
	    for ($i = 0; $i < sizeof($local_array); $i++) 
		{
   			if (!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $local_array[$i])) 
			{
			   return false;
   			}
			
			
   		}
		if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) { // Check if domain is IP. If not, it should be valid domain name
		   $domain_array = explode(".", $email_array[1]);
  		if (sizeof($domain_array) < 2) 
		{
		   return false; // Not enough parts to domain
   		}
		for ($i = 0; $i < sizeof($domain_array); $i++) 
		{
			   if (!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$", $domain_array[$i])) 
			   {
				   return false;
				}
	    }
	 }
   	return true;
   }
   
   function validateFloat($string)
   {
   	 $regex = "/^[0-9]+(?:\.[0-9]{2})?$/";
	    if (preg_match($regex, $string)) {
	        return true;
	    }else{
	        return false;
	    }
	}  

function validateimages($val)
    {
    	if($val=='image/jpeg' || $val=='image/gif' || $val=='image/png' || $val=='image/bmp')
		return true;
	else
		return false;
    }
	
}
?>