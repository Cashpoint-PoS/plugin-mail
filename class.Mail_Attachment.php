<?
class Mail_Attachment extends DBObj {
  protected static $__table="mail_attachments";
  public static $mod="mail";
  public static $sub="mail_attachments";
  
  public static $elements=array(
  "mail_mails_id"=>array("title"=>"Mail","mode"=>"string","dbkey"=>"mail_mails_id"),
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
  "mail_mails_id",
"type",
"filerepo_files_id",
"_filename",
"_filesize",
  );
  public static $detail_elements=array(
  "mail_mails_id",
"type",
"filerepo_files_id",
"_filename",
"_fileurl",
"_filepath",
"_filesize",
  );
  public static $edit_elements=array(
  "mail_mails_id",
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

plugins_register_backend_handler($plugin,"mail_attachments","list",array("Mail_Attachment","listView"));
plugins_register_backend_handler($plugin,"mail_attachments","edit",array("Mail_Attachment","editView"));
plugins_register_backend_handler($plugin,"mail_attachments","view",array("Mail_Attachment","detailView"));
plugins_register_backend_handler($plugin,"mail_attachments","submit",array("Mail_Attachment","processSubmit"));
