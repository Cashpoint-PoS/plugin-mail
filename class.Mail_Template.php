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
  public function processProperty($key) {
    $ret=NULL;
    switch($key) {
    }
    return $ret;
  }
  public function toString() {
  	return $this->name." [".$this->subject."]";
  }
  public function replacePlaceholders($customer,$str) {
  	$str=str_replace("%%SALUTATION%%",$customer->salutation,$str);
  	return $str;
  }
  public function applyAndCreate($customer) {
  	$mail=Mail_Mail::fromScratch();
  	$mail->subject=$this->replacePlaceholders($customer,$this->subject);
  	$mail->content_html=$this->replacePlaceholders($customer,$this->content_html);
  	$mail->content_text=$this->replacePlaceholders($customer,$this->content_text);
  	return $mail;
  }
}

plugins_register_backend_handler($plugin,"templates","list",array("Mail_Template","listView"));
plugins_register_backend_handler($plugin,"templates","edit",array("Mail_Template","editView"));
plugins_register_backend_handler($plugin,"templates","view",array("Mail_Template","detailView"));
plugins_register_backend_handler($plugin,"templates","submit",array("Mail_Template","processSubmit"));
