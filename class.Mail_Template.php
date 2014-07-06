<?
class Mail_Template extends DBObj {
  protected static $__table="mail_templates";
  public static $mod="mail";
  public static $sub="templates";
  
  public static $elements=array(
  "subject"=>array("title"=>"Betreff","mode"=>"string","dbkey"=>"subject"),
"content_html"=>array("title"=>"Inhalt (HTML)","mode"=>"string","dbkey"=>"content_html"),
"content_text"=>array("title"=>"Inhalt (Text)","mode"=>"string","dbkey"=>"content_text"),
"name"=>array("title"=>"Name","mode"=>"string","dbkey"=>"name"),

  );
  public static $link_elements=array(
  );
  public static $list_elements=array(
  "subject",
"content_html",
"content_text",
"name",
  );
  public static $detail_elements=array(
  "subject",
"content_html",
"content_text",
"name",
  );
  public static $edit_elements=array(
  "subject",
"content_html",
"content_text",
"name",
  );
  public static $links=array(
  );
  
  public static $one2many=array(
  	"Mail_Template_Attachment"=>array("title"=>"Anhänge"),
  );
  public function processProperty($key) {
    $ret=NULL;
    switch($key) {
    }
    return $ret;
  }
  public function toString() {
  	return $this->name." [".$this->subject."]";
  }
  public function replacePlaceholders($customer,$mailaddr,$str) {
  	global $config;
  	$str=str_replace("%%SALUTATION%%",$customer->salutation,$str);
  	$str=str_replace("%%OPTOUTURL%%",$config["paths"]["webroot"]."/optout.php?addr=".urlencode($mailaddr->addr),$str);
  	$str=str_replace("%%TRACKURL%%",$config["paths"]["webroot"]."/track.png?addr=".urlencode($mailaddr->addr),$str);
  	$str=str_replace("%%MAILENC%%",urlencode($mailaddr->addr),$str);
  	$str=str_replace("%%MAILRAW%%",$mailaddr->addr,$str);
  	
  	return $str;
  }
  public function applyAndCreate($customer,$mailaddr) {
  	$mail=Mail_Mail::fromScratch();
  	$mail->subject=$this->replacePlaceholders($customer,$mailaddr,$this->subject);
  	$mail->content_html=$this->replacePlaceholders($customer,$mailaddr,$this->content_html);
  	$mail->content_text=$this->replacePlaceholders($customer,$mailaddr,$this->content_text);
  	$mail->commit();
  	$attachments=Mail_Template_Attachment::getByOwner($this);
  	foreach($attachments as $att) {
  		$at=Mail_Attachment::fromScratch();
  		$at->mail_mails_id=$mail->id;
  		$at->type=$att->type;
  		$at->filerepo_files_id=$att->filerepo_files_id;
  		$at->commit();
  	}
  	return $mail;
  }
}

plugins_register_backend_handler($plugin,"templates","list",array("Mail_Template","listView"));
plugins_register_backend_handler($plugin,"templates","edit",array("Mail_Template","editView"));
plugins_register_backend_handler($plugin,"templates","view",array("Mail_Template","detailView"));
plugins_register_backend_handler($plugin,"templates","submit",array("Mail_Template","processSubmit"));
