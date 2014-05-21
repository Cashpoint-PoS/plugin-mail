<?
class Mail_Template_Attachment extends DBObj {
  protected static $__table="mail_template_attachments";
  public static $mod="mail";
  public static $sub="template_attachments";
  
  public static $elements=array(
  "mail_templates_id"=>array("title"=>"","mode"=>"string","dbkey"=>"mail_templates_id"),
"type"=>array("title"=>"","mode"=>"string","dbkey"=>"type"),
"filerepo_files_id"=>array("title"=>"","mode"=>"string","dbkey"=>"filerepo_files_id"),
"filename"=>array("title"=>"","mode"=>"string","dbkey"=>"filename"),

  );
  public static $link_elements=array(
  );
  public static $list_elements=array(
  "mail_templates_id",
"type",
"filerepo_files_id",
"filename",

  );
  public static $detail_elements=array(
  "mail_templates_id",
"type",
"filerepo_files_id",
"filename",

  );
  public static $edit_elements=array(
  "mail_templates_id",
"type",
"filerepo_files_id",
"filename",

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

plugins_register_backend_handler($plugin,"template_attachments","list",array("Mail_Template_Attachment","listView"));
plugins_register_backend_handler($plugin,"template_attachments","edit",array("Mail_Template_Attachment","editView"));
plugins_register_backend_handler($plugin,"template_attachments","view",array("Mail_Template_Attachment","detailView"));
plugins_register_backend_handler($plugin,"template_attachments","submit",array("Mail_Template_Attachment","processSubmit"));
