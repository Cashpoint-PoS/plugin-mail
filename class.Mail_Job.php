<?
class Mail_Job extends DBObj {
  protected static $__table="mail_jobs";
  public static $mod="mail";
  public static $sub="jobs";
  
  public static $elements=array(
  "mail_mails_id"=>array("title"=>"Mail ID","mode"=>"one2many","dbkey"=>"mail_mails_id","data"=>"Mail_Mail"),
	"status"=>array("title"=>"Status","mode"=>"select","dbkey"=>"status","data"=>array("Offen","In Bearbeitung","Gesendet OK","Gesendet Fehler","Abgebrochen")),
	"log"=>array("title"=>"Protokoll","mode"=>"string","dbkey"=>"log"),
  );
  public static $link_elements=array(
  );
  public static $list_elements=array(
  "mail_mails_id",
"status",

  );
  public static $detail_elements=array(
  "mail_mails_id",
"status",
"log",
  );
  public static $edit_elements=array(
  "mail_mails_id",
"status",

  );
  public static $links=array(
  );
  public function processProperty($key) {
    $ret=NULL;
    switch($key) {
    }
    return $ret;
  }
  public static function getOpenJobs() {
  	return static::getByFilter("where status=0;");
  }
  public function lockJob() {
  	$tmp=static::getById($this->id);
  	if($this->status==0) {
	  	$this->status=1;
  		$this->commit();
  		return true;
  	} else
  		return false;
  }
  public function executeJob() {
  	$log="";
  	$mail=Mail_Mail::getById($this->mail_mails_id);
  	$sendAccount=Mail_SendAccount::getById($mail->mail_sendaccounts_id);
  	$log.=sprintf("executing sendmail job %d, mail %d (target %s), sendAccount %d (%s)\n",$this->id,$mail->id,$mail->rcpt_to,$sendAccount->id,$sendAccount->from_addr);
  	$creds=json_decode($sendAccount->credentials);
  	if($creds===null) {
  		$log.=sprintf("invalid smtp credentials\n");
  		$this->log=$log;
  		$this->status=3;
  		$this->commit();
  		return $log;
  	}
  	$conn=json_decode($sendAccount->conn_details);
  	if($conn===null) {
  		$log.=sprintf("invalid smtp conn info\n");
  		$this->log=$log;
  		$this->status=3;
  		$this->commit();
  		return $log;
  	}
  	$mailer=new PHPMailer();
  	$mailer->isSMTP();
  	$mailer->SMTPDebug=2;
  	$mailer->Host=$conn->host;
  	$mailer->Port=$conn->port;
  	$mailer->SMTPSecure=$conn->sectsp;
  	$mailer->SMTPAuth=true;
  	$mailer->Username=$creds->user;
  	$mailer->Password=$creds->pass;
  	$mailer->setFrom($sendAccount->from_addr,$sendAccount->from_name);
  	$mailer->addAddress($mail->rcpt_to);
  	$mailer->Subject=$mail->subject;
  	$mailer->isHTML(true);
  	$mailer->Body=$mail->content_html;
  	$mailer->AltBody=$mail->content_text;
  	ob_start();
  	$res=$mailer->send();
  	$maillog=ob_get_clean();
  	$log.=sprintf("PHPMailer log:\n%s\n",$maillog);
  	if(!$res) {
  		$log.=sprintf("PHPMailer reported an error: %s\n",$mailer->ErrorInfo);
  		$this->log=$log;
  		$this->status=3;
  		$this->commit();
  	} else {
  		$log.=sprintf("Send OK\n");
  		$this->status=2;
  		$this->log=$log;
  		$this->commit();
  	}
  	return $log;
  }
}

plugins_register_backend_handler($plugin,"jobs","list",array("Mail_Job","listView"));
plugins_register_backend_handler($plugin,"jobs","edit",array("Mail_Job","editView"));
plugins_register_backend_handler($plugin,"jobs","view",array("Mail_Job","detailView"));
plugins_register_backend_handler($plugin,"jobs","submit",array("Mail_Job","processSubmit"));
plugins_register_jobrunner("Mail_Job");
