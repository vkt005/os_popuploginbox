<?php
include_once('../../config/config.inc.php');
include_once('../../init.php');
include_once './os_popuploginbox.php';
if (Tools::isSubmit('SubmitCreate'))
		{
    $email=Tools::getValue('email');
    $ol=new Os_popuploginbox();
		$x=$ol->checkUser($email);
             
             echo json_encode($x);
             exit();
		}
?>