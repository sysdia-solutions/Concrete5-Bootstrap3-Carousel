<?php 
defined("C5_EXECUTE") or die("Access Denied.");
$al = Loader::helper("concrete/asset_library");
$ah = Loader::helper("concrete/interface");
?>
<style type="text/css">
#ccm-slideshowBlock-imgRows a{cursor:pointer}
#ccm-slideshowBlock-imgRows .ccm-slideshowBlock-imgRow a.moveUpLink{ display:block; background:url(<?php  echo ASSETS_URL_IMAGES?>/icons/arrow_up.png) no-repeat center; height:10px; width:16px; }
#ccm-slideshowBlock-imgRows .ccm-slideshowBlock-imgRow a.moveDownLink{ display:block; background:url(<?php  echo ASSETS_URL_IMAGES?>/icons/arrow_down.png) no-repeat center; height:10px; width:16px; }
#ccm-slideshowBlock-imgRows .ccm-slideshowBlock-imgRow a.moveUpLink:hover{background:url(<?php  echo ASSETS_URL_IMAGES?>/icons/arrow_up_black.png) no-repeat center;}
#ccm-slideshowBlock-imgRows .ccm-slideshowBlock-imgRow a.moveDownLink:hover{background:url(<?php  echo ASSETS_URL_IMAGES?>/icons/arrow_down_black.png) no-repeat center;}
#ccm-slideshowBlock-imgRows .cm-slideshowBlock-imgRowIcons{ float:right; width:35px; text-align:left; }

.ccm-slideshowBlock-imgRow {height: 220px !important;}
.ccm-slideshowBlock-imgRow table{width: 450px;}
.ccm-slideshowBlock-imgRow h1{font-size: 15px; font-weight: bold; background-color: #EEE; padding: 6px; margin-right: 40px;}
.ccm-slideshowBlock-imgRow table label{display: block;}
.ccm-slideshowBlock-imgRow table input[type=text], .ccm-slideshowBlock-imgRow table textarea{width: 100%;}
</style>

<div id="newImg">
  <table cellspacing="0" cellpadding="0" border="0" width="100%" class="table table-bordered">
  
  <tr>
    <td>
      <strong><?php echo t('Name')?>:</strong>
      <input type="text" name="name" value="<?php echo ( strlen(trim($name)) > 0 ? $name : "myCarousel" )?>" />
    </td>
    <td>
      <strong><?php echo t('Slide Interval (in seconds)')?>:</strong>
      <input type="text" name="slideTimer" value="<?php echo ( strlen(trim($slideTimer)) > 0 ? $slideTimer : "5" )?>" />
    </td>
  </tr>
  
  <tr>
    <td>
      <strong><?php echo t('Show Indicators')?>:</strong>
      <label><input name="withIndicators" type="radio" value="0" <?php echo (!$withIndicators)?'checked':''?>> <span><?php echo t('No')?></span></label>
      <label><input name="withIndicators" type="radio" value="1" <?php echo ($withIndicators)?'checked':''?>> <span><?php echo t('Yes')?></span></label> 
    </td>
    <td>
      <strong><?php echo t('Show Chevrons')?>:</strong>
      <label><input name="withChevrons" type="radio" value="0" <?php echo (!$withChevrons)?'checked':''?>> <span><?php echo t('No')?></span></label>
      <label><input name="withChevrons" type="radio" value="1" <?php echo ($withChevrons)?'checked':''?>> <span><?php echo t('Yes')?></span></label> 
    </td>
  </tr>
  
  <tr>
    <td colspan="2">
      <span id="ccm-slideshowBlock-chooseImg"><?php echo $ah->button_js(t('Add Image'), 'SlideshowBlock.chooseImg()', 'left');?></span>
    </td>
  </tr>
  </table>
</div>
<br/>

<div id="ccm-slideshowBlock-imgRows">
<?php
  foreach($images as $imgInfo){ 
    $f = File::getByID($imgInfo['fID']);
    $fp = new Permissions($f);
    $imgInfo['thumbPath'] = $f->getThumbnailSRC(1);
    $imgInfo['fileName'] = $f->getTitle();
    if ($fp->canViewFile()) { 
      $this->inc('image_row_include.php', array('imgInfo' => $imgInfo));
    }
  }
?>
</div>

<div id="imgRowTemplateWrap" style="display:none">
<?php 
$imgInfo['slideshowImgId']='tempSlideshowImgId';
$imgInfo['fID']='tempFID';
$imgInfo['fileName']='tempFilename';
$imgInfo['origfileName']='tempOrigFilename';
$imgInfo['thumbPath']='tempThumbPath';
$imgInfo['duration']=$defaultDuration;
$imgInfo['fadeDuration']=$defaultFadeDuration;
$imgInfo['groupSet']=0;
$imgInfo['imgHeight']=tempHeight;
$imgInfo['url']='';
$imgInfo['class']='ccm-slideshowBlock-imgRow';
?>
<?php  $this->inc('image_row_include.php', array('imgInfo' => $imgInfo)); ?> 
</div>
