<?
class Mail_Template_Attachment extends DBObj {
  protected static $__table="mail_template_attachments";
  public static $mod="mail";
  public static $sub="template_attachments";
  
  public static $elements=array(
  "mail_templates_id"=>array("title"=>"Mailvorlage","mode"=>"string","dbkey"=>"mail_templates_id"),
"type"=>array("title"=>"Typ","mode"=>"select","dbkey"=>"type","data"=>array("Standard","Inline")),
"filerepo_files_id"=>array("title"=>"FileRepo ID","mode"=>"string","dbkey"=>"filerepo_files_id"),
"_filename"=>array("title"=>"Dateiname","mode"=>"process"),
"_fileurl"=>array("title"=>"URL","mode"=>"process"),
"_filepath"=>array("title"=>"Dateipfad","mode"=>"process"),
"_filesize"=>array("title"=>"Dateigröße","mode"=>"process"),
  );
  public static $link_elements=array(
  );
  public static $list_elements=array(
  "mail_templates_id",
"type",
"filerepo_files_id",
"_filename",
"_filesize",
  );
  public static $detail_elements=array(
  "mail_templates_id",
"type",
"filerepo_files_id",
"_filename",
"_fileurl",
"_filepath",
"_filesize",
  );
  public static $edit_elements=array(
  "mail_templates_id",
"type",
"filerepo_files_id",

  );
  public static $links=array(
  );
  public function processProperty($key) {
  	global $config;
    $ret=NULL;
    switch($key) {
    	case "_filename":
    	$fr=FileRepo_File::getById($this->filerepo_files_id);
    	$ret=$fr->filename;
    	break;
    	case "_fileurl":
    	$fr=FileRepo_File::getById($this->filerepo_files_id);
    	$ret=$config["paths"]["filestore_web"].$fr->filestore_relpath;
    	break;
    	case "_filepath":
    	$fr=FileRepo_File::getById($this->filerepo_files_id);
    	$ret=$config["paths"]["filestore"].$fr->filestore_relpath;
    	break;
    	case "_filesize":
    	$path=$this->processProperty("_filepath");
    	$ret=filesize($path);
    	break;
    }
    return $ret;
  }
}

plugins_register_backend_handler($plugin,"template_attachments","list",array("Mail_Template_Attachment","listView"));
plugins_register_backend_handler($plugin,"template_attachments","edit",array("Mail_Template_Attachment","editView"));
plugins_register_backend_handler($plugin,"template_attachments","view",array("Mail_Template_Attachment","detailView"));
plugins_register_backend_handler($plugin,"template_attachments","submit",array("Mail_Template_Attachment","processSubmit"));
