<?php  
defined("C5_EXECUTE") or die("Access Denied."); 
$carouselId = "carousel_{$name}_".intval($bID);
?>
<div id="<?php echo $carouselId;?>" class="<?php echo "carousel_{$name}";?> carousel slide">
  <?php 
  $indicatorCounter = 0;
  if($withIndicators == 1) {   
  ?>
  <ol class="carousel-indicators">
  <?php foreach($images as $imgInfo) {
  $class = ($indicatorCounter == 0 ? ' class="active" ' : '');
  ?>
    <li data-target="#<?php echo $carouselId;?>" data-slide-to="<?php echo $indicatorCounter;?>" <?php echo $class;?>></li>
  <?php 
      $indicatorCounter++;
    } 
  ?>
  </ol>
  <?php     
  } ?>
  <div class="carousel-inner">
  <?php 
  $counter = 0;
  foreach($images as $imgInfo) {
    $f = File::getByID($imgInfo['fID']);    
    $fp = new Permissions($f);
    if ($fp->canViewFile()) {

    $counter++;
    $active = ($counter == 1 ? ' active' : '');
    $fileName = $f->getFileName();
    $fullFilePath = $f->getRelativePath();
    
    
    $imgUrl = $fullFilePath;
    if (strlen(trim($fullFilePath)) === 0) {
      $imgUrl = REL_DIR_FILES_UPLOADED."/".$fileName;
    }
    $overlayTitle = trim($imgInfo['overlayTitle']);
    $overlayContent = trim($imgInfo['overlayContent']);
    $overlayButtonText = trim($imgInfo['overlayButtonText']);
    $overlayButtonLink = (strlen(trim($imgInfo['overlayButtonLink'])) ? trim($imgInfo['overlayButtonLink']) : '#');
    $overlayButtonClass = (strlen(trim($imgInfo['overlayButtonClass'])) ? trim($imgInfo['overlayButtonClass']) : 'btn btn-large btn-primary');
    
    $linkTarget = "";
    $overlayLink = (strlen($overlayButtonLink) > 0 && strlen($overlayButtonText) === 0 ? $overlayButtonLink : "");
    
    if( strpos($overlayLink, "[new]") !== false) {
      $linkTarget = 'target="_blank"';
      $overlayLink = str_replace("[new]", "", $overlayLink);
    }
  ?>
    <div class="item <?php echo $active;?>">
      <?php if($overlayLink !== "") echo '<a href="'.$overlayLink.'" ' . $linkTarget . '>'; ?>
        <img src="<?php echo $imgUrl;?>" alt="">
      <?php if($overlayLink !== "") echo '</a>'; ?>
      <div class="container">
        <div class="carousel-caption">
          <?php if(strlen(trim($overlayTitle)) > 0) echo "<h1>{$overlayTitle}</h1>";?>
          <?php if(strlen(trim($overlayContent)) > 0) echo "<p>{$overlayContent}</p>";?>
          <?php if(strlen(trim($overlayButtonText)) > 0) echo "<p><a class=\"{$overlayButtonClass}\" href=\"{$overlayButtonLink}\" {$linkTarget}>{$overlayButtonText}</a></p>";?>
        </div>
      </div>
    </div>
  <?php 
    }
  } 
  ?>

  </div>
  <?php if($withChevrons == 1) {  ?>
  <a class="left carousel-control" href="#<?php echo $carouselId;?>" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
  <a class="right carousel-control" href="#<?php echo $carouselId;?>" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
  <?php } ?>
</div>

<script>
$(document).ready(function () {
  <?php if ( $slideTimer > 0) { ?>
  $("#<?php echo $carouselId;?>").carousel({ interval: <?php echo $slideTimer * 1000; ?>});
  $("#<?php echo $carouselId;?>").carousel('cycle');
  <?php } else { ?>
  $("#<?php echo $carouselId;?>").carousel({ interval: false, pause: 'hover'});
  $("#<?php echo $carouselId;?>").carousel('pause');
  <?php } ?>
});
</script>