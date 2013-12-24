var SlideshowBlock = {

  init:function(){},

  chooseImg:function(){ 
    ccm_launchFileManager('&fType=' + ccmi18n_filemanager.FTYPE_IMAGE);
  },

  showImages:function(){
    $("#ccm-slideshowBlock-imgRows").show();
    $("#ccm-slideshowBlock-chooseImg").show();
  },

  showFileSet:function(){
    $("#ccm-slideshowBlock-imgRows").hide();
    $("#ccm-slideshowBlock-chooseImg").hide();
  },

  selectObj:function(obj){
    this.addNewImage(obj.fID, obj.thumbnailLevel1, obj.height, obj.title);
  },

  addImages:0, 
  addNewImage: function(fID, thumbPath, imgHeight, title) { 
    this.addImages--; //negative counter - so it doesn't compete with real slideshowImgIds
    var slideshowImgId=this.addImages;
    var templateHTML=$('#imgRowTemplateWrap .ccm-slideshowBlock-imgRow').html().replace(/tempFID/g,fID);
    templateHTML=templateHTML.replace(/tempThumbPath/g,thumbPath);
    templateHTML=templateHTML.replace(/tempFilename/g,title);
    templateHTML=templateHTML.replace(/tempSlideshowImgId/g,slideshowImgId).replace(/tempHeight/g,imgHeight);
    var imgRow = document.createElement("div");
    imgRow.innerHTML=templateHTML;
    imgRow.id='ccm-slideshowBlock-imgRow'+parseInt(slideshowImgId);
    imgRow.className='ccm-slideshowBlock-imgRow';
    document.getElementById('ccm-slideshowBlock-imgRows').appendChild(imgRow);
    var bgRow=$('#ccm-slideshowBlock-imgRow'+parseInt(fID)+' .backgroundRow');
    bgRow.css('background','url('+escape(thumbPath)+') no-repeat left top');
  },

  removeImage: function(fID){
    $('#ccm-slideshowBlock-imgRow'+fID).remove();
  },

  moveUp:function(fID){
    var thisImg=$('#ccm-slideshowBlock-imgRow'+fID);
    var qIDs=this.serialize();
    var previousQID=0;
    for(var i=0;i<qIDs.length;i++){
      if(qIDs[i]==fID){
        if(previousQID==0) break; 
        thisImg.after($('#ccm-slideshowBlock-imgRow'+previousQID));
        break;
      }
      previousQID=qIDs[i];
    }
  },
  moveDown:function(fID){
    console.log(fID);
    var thisImg=$('#ccm-slideshowBlock-imgRow'+fID);
    var qIDs=this.serialize();
    var thisQIDfound=0;
    for(var i=0;i<qIDs.length;i++){
    
      console.log( qIDs[i] + "==" + fID);
      
      if(qIDs[i]==fID){
        thisQIDfound=1;
        continue;
      }
      if(thisQIDfound){
        $('#ccm-slideshowBlock-imgRow'+qIDs[i]).after(thisImg);
        break;
      }
    } 
  },
  serialize:function(){
    var t = document.getElementById("ccm-slideshowBlock-imgRows");
    var qIDs=[];
    for(var i=0;i<t.childNodes.length;i++){ 
      if( t.childNodes[i].className && t.childNodes[i].className.indexOf('ccm-slideshowBlock-imgRow')>=0 ){ 
        var qID=t.childNodes[i].id.replace('ccm-slideshowBlock-imgRow','');
        qIDs.push(qID);
      }
    }
    return qIDs;
  },

  validate:function(){
    var failed=0; 
    
    qIDs=this.serialize();
    if( qIDs.length<1 ){
      alert(ccm_t('choose-min-2'));
      $('#ccm-slideshowBlock-AddImg').focus();
      failed=1;
    }
    
    if(failed){
      ccm_isBlockError=1;
      return false;
    }
    return true;
  } 
  }

  ccmValidateBlockForm = function() { return SlideshowBlock.validate(); }
  ccm_chooseAsset = function(obj) { SlideshowBlock.selectObj(obj); }

  $(function() {
    SlideshowBlock.showImages();
  });

