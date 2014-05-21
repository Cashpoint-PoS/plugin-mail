<?
require("PHPMailer/PHPMailerAutoload.php");
plugins_register_backend($plugin,array("icon"=>"icon-user","sub"=>array("directories"=>"Ordner","files"=>"Dateien")));
require("class.Mail_Mail.php");
require("class.Mail_Template.php");
require("class.Mail_Template_Attachment.php");
require("class.Mail_SendAccount.php");
require("class.Mail_Job.php");

