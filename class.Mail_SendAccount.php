<?
class Mail_SendAccount extends DBObj {
  protected static $__table="mail_sendaccounts";
  public static $mod="mail";
  public static $sub="sendaccounts";
  
  public static $elements=array(
  "from_addr"=>array("title"=>"Absender-Name","mode"=>"string","dbkey"=>"from_addr"),
"from_name"=>array("title"=>"Absender-Mailadresse","mode"=>"string","dbkey"=>"from_name"),
"type"=>array("title"=>"Typ","mode"=>"select","dbkey"=>"type","data"=>array("smtp")),
"credentials"=>array("title"=>"Zugangsdaten","mode"=>"string","dbkey"=>"credentials"),
"name"=>array("title"=>"Eintragstitel","mode"=>"string","dbkey"=>"name"),
"conn_details"=>array("title"=>"Serverdaten","mode"=>"string","dbkey"=>"conn_details"),

  );
  public static $link_elements=array(
  );
  public static $list_elements=array(
  "from_addr",
"from_name",
"type",
"credentials",
"name",
"conn_details",

  );
  public static $detail_elements=array(
  "from_addr",
"from_name",
"type",
"credentials",
"name",
"conn_details",

  );
  public static $edit_elements=array(
  "from_addr",
"from_name",
"type",
"credentials",
"name",
"conn_details",

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
  	return $this->name." <".$this->from_addr.">";
  }
}

plugins_register_backend_handler($plugin,"sendaccounts","list",array("Mail_SendAccount","listView"));
plugins_register_backend_handler($plugin,"sendaccounts","edit",array("Mail_SendAccount","editView"));
plugins_register_backend_handler($plugin,"sendaccounts","view",array("Mail_SendAccount","detailView"));
plugins_register_backend_handler($plugin,"sendaccounts","submit",array("Mail_SendAccount","processSubmit"));
