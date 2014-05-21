<?
class Mail_Mail extends DBObj {
  protected static $__table="mail_mails";
  public static $mod="mail";
  public static $sub="mails";
  
  public static $elements=array(
  "subject"=>array("title"=>"","mode"=>"string","dbkey"=>"subject"),
"content_html"=>array("title"=>"","mode"=>"string","dbkey"=>"content_html"),
"content_text"=>array("title"=>"","mode"=>"string","dbkey"=>"content_text"),
"rcpt_to"=>array("title"=>"","mode"=>"string","dbkey"=>"rcpt_to"),
"rcpt_cc"=>array("title"=>"","mode"=>"string","dbkey"=>"rcpt_cc"),
"rcpt_bcc"=>array("title"=>"","mode"=>"string","dbkey"=>"rcpt_bcc"),
"mail_sendaccounts_id"=>array("title"=>"","mode"=>"string","dbkey"=>"mail_sendaccounts_id"),

  );
  public static $link_elements=array(
  );
  public static $list_elements=array(
  "subject",
"content_html",
"content_text",
"rcpt_to",
"rcpt_cc",
"rcpt_bcc",
"mail_sendaccounts_id",

  );
  public static $detail_elements=array(
  "subject",
"content_html",
"content_text",
"rcpt_to",
"rcpt_cc",
"rcpt_bcc",
"mail_sendaccounts_id",

  );
  public static $edit_elements=array(
  "subject",
"content_html",
"content_text",
"rcpt_to",
"rcpt_cc",
"rcpt_bcc",
"mail_sendaccounts_id",

  );
  public static $links=array(
  );
  public function processProperty($key) {
    $ret=NULL;
    switch($key) {
    }
    return $ret;
  }
}

plugins_register_backend_handler($plugin,"mails","list",array("Mail_Mail","listView"));
plugins_register_backend_handler($plugin,"mails","edit",array("Mail_Mail","editView"));
plugins_register_backend_handler($plugin,"mails","view",array("Mail_Mail","detailView"));
plugins_register_backend_handler($plugin,"mails","submit",array("Mail_Mail","processSubmit"));
