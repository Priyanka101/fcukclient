function rotate(i,max){
  jQuery(".hp_slide").not("#hp_slide_" + i).fadeOut(800);
  jQuery("#hp_slide_" + i).fadeIn(1500,function(){
    if(i==max){
      setTimeout(function() {
        rotate(1,max);
      }, 3000);
    }else{
      i++;
      rotate(i,max);
    }
  });
}

function rotate_imagbox(i,max){
  jQuery(".image_box").not("#image_box_" + i).fadeOut(800);
  jQuery("#image_box_" + i).fadeIn(1500,function(){
    if(i==max){
      rotate_imagbox(1,max);
    }else{
      i++;
      rotate_imagbox(i,max);
    }
  });
}