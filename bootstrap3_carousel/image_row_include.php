<?php defined("C5_EXECUTE") or die("Access Denied."); ?> 

<div id="ccm-slideshowBlock-imgRow<?php echo $imgInfo['imgId']; ?>" class="ccm-slideshowBlock-imgRow" >
  <div class="backgroundRow" style="background: url(<?php echo $imgInfo['thumbPath']?>) no-repeat left top; padding-left: 80px">
  
    <div class="cm-slideshowBlock-imgRowIcons" >    
      <div style="float:right">
        <a onclick="SlideshowBlock.moveUp('<?php echo $imgInfo['imgId']?>')" class="moveUpLink"></a>
        <a onclick="SlideshowBlock.moveDown('<?php echo $imgInfo['imgId']?>')" class="moveDownLink"></a>
      </div>
      <div style="margin-top:0px">
        <a onclick="SlideshowBlock.removeImage('<?php echo $imgInfo['imgId']?>')"><img src="<?php echo ASSETS_URL_IMAGES?>/icons/delete_small.png" /></a>
      </div>
    </div>
    
    <h1><?php echo $imgInfo['fileName']?></h1>
    <table>
      <tr>
        <td>
          <label><?php echo t('Section Link')?></label>
          <input type="text" name="overlayButtonLink[]" value="<?php echo $imgInfo['overlayButtonLink']?>" />                  
        </td>
        <td>
          <label><?php echo t('Overlay Title')?></label>
          <input type="text" name="overlayTitle[]" value="<?php echo $imgInfo['overlayTitle']?>"/>        
        </td>
      </tr>
      <tr>
        <td colspan="2">
          <label><?php echo t('Overlay Content')?></label>
          <textarea name="overlayContent[]"><?php echo $imgInfo['overlayContent']?></textarea>        
        </td>
      </tr>
      <tr>
        <td>
          <label><?php echo t('Overlay Button Text')?></label>
          <input type="text" name="overlayButtonText[]" value="<?php echo $imgInfo['overlayButtonText']?>" />        
        </td>
        <td>
          <label><?php echo t('Overlay Button Class')?></label>
          <input type="text" name="overlayButtonClass[]" value="<?php echo $imgInfo['overlayButtonClass']?>" />
        </td>
      </tr>
    </table>

    <div>
      <input type="hidden" name="imgFIDs[]" value="<?php echo $imgInfo['fID']?>">
      <input type="hidden" name="imgHeight[]" value="<?php echo $imgInfo['imgHeight']?>">
    </div>
    
  </div>
  <div style="border-bottom: 1px solid #CCC; clear: left; height: 14px; width: 100%;"></div>
</div>

