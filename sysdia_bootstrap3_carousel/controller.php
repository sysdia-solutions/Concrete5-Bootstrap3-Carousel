<?php 
defined("C5_EXECUTE") or die("Access Denied.");
class SysdiaBootstrap3CarouselBlockController extends BlockController {

  protected $btName = "SysdiaBootstrap3Carousel";
  protected $btDescription = "Bootstrap 3 Carousel";
  
  protected $btTable = "btSysdiaBootstrap3Carousel";
  protected $btTableImg = "btSysdiaBootstrap3CarouselImg";
  protected $btInterfaceWidth = "550";
  protected $btInterfaceHeight = "400";
  protected $btCacheBlockRecord = true;
  protected $btCacheBlockOutput = true;
  protected $btCacheBlockOutputOnPost = true;
  protected $btCacheBlockOutputForRegisteredUsers = true;

  protected $btExportFileColumns = array('fID');
  protected $btExportTables = array("btSysdiaBootstrap3Carousel", "btSysdiaBootstrap3CarouselImg");

  public $defaultWithIndicators = 1;
  public $defaultWithChevrons = 1;
  
  public $name;
  public $slideTimer;
  public $withIndicators;
  public $withChevrons;

  /** 
   * Used for localization. If we want to localize the name/description we have to include this
   */
  public function getBlockTypeDescription() {
    return t("Display a Bootstrap 3 Carousel.");
  }

  public function getBlockTypeName() {
    return t("Sysdia Bootstrap 3 Carousel");
  }

  public function getJavaScriptStrings() {
    return array(
      'choose-file' => t('Choose Image/File'),
      'choose-min-2' => t('Please choose at least one image.')
    );
  }

  function loadImages(){
    if(intval($this->bID)==0) $this->images=array();
    if(intval($this->bID)==0) return array();
    $sql = "SELECT * FROM {$this->btTableImg} WHERE bID=".intval($this->bID).' ORDER BY position';
    $db = Loader::db();
    $this->images=$db->getAll($sql); 
    $this->maxHeight = $db->GetOne("SELECT max(imgHeight) FROM {$this->btTableImg} WHERE bID=?", array($this->bID));
  }

  function delete(){
    $db = Loader::db();
    $db->query("DELETE FROM {$this->btTableImg} WHERE bID=".intval($this->bID));
    parent::delete();
  }

  function loadBlockInformation() {
    $this->loadImages();
    $this->set('defaultWithIndicators', $this->defaultWithIndicators);
    $this->set('defaultWithChevrons', $this->defaultWithChevrons);
    $this->set('name', $this->name);
    $this->set('slideTimer', $this->slideTimer);
    $this->set('withIndicators', $this->withIndicators);
    $this->set('withChevrons', $this->withChevrons);
    $this->set('maxHeight', $this->maxHeight);
    $this->set('images', $this->images);
    $this->set('bID', $this->bID);
  }

  function view() {
    $this->loadBlockInformation();
  }

  function add() {
    $this->loadBlockInformation();
  }

  function edit() {
    $this->loadBlockInformation();
  }

  function duplicate($nbID) {
    parent::duplicate($nbID);
    $this->loadBlockInformation();
    $db = Loader::db();
    foreach($this->images as $im) {
      $db->Execute("INSERT INTO {$this->btTableImg} (bID, fID, overlayTitle, overlayContent, overlayButtonText, overlayButtonLink, overlayButtonClass, position, imgHeight) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)", 
        array($nbID, $im['fID'], $im['overlayTitle'], $im['overlayContent'], $im['overlayButtonText'], $im['overlayButtonLink'], $im['overlayButtonClass'], $im['position'], $im['imgHeight'])
      );
    }
  }

  function save($data) { 
    $db = Loader::db();
    $args['name'] = $data['name'];
    $args['slideTimer'] = $data['slideTimer'];
    $args['withIndicators'] = $data['withIndicators'];
    $args['withChevrons'] = $data['withChevrons'];
    
    if( count($data['imgFIDs']) ){
      //delete existing images
      $db->query("DELETE FROM {$this->btTableImg} WHERE bID=".intval($this->bID));
      
      //loop through and add the images
      $pos=0;
      foreach($data['imgFIDs'] as $imgFID){ 
        if(intval($imgFID)==0 || $data['fileNames'][$pos]=='tempFilename') continue;
        $vals = array(intval($this->bID),intval($imgFID),$data['overlayTitle'][$pos], $data['overlayContent'][$pos],$data['overlayButtonText'][$pos],$data['overlayButtonLink'][$pos],$data['overlayButtonClass'][$pos],$data['imgHeight'][$pos],$pos);
        $db->query("INSERT INTO {$this->btTableImg} (bID, fID, overlayTitle, overlayContent, overlayButtonText, overlayButtonLink, overlayButtonClass, imgHeight, position) values (?, ?, ?, ?, ?, ?, ?, ?, ?)",$vals);
        $pos++;
      }    
    }
    parent::save($args);
  }
}

?>
