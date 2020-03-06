// onSlideLeave event function
function mcw_vcacnim_reset_osl(that){
  $(that).find('.wpb_animate_when_almost_visible.wpb_start_animation').removeClass('wpb_start_animation');
}
// onLeave event function
function mcw_vcanim_reset_ol(that){
  if ($(that).find('.fp-slides').length){
    mcw_vcacnim_reset_osl($(that).find('.fp-slide.active'));
  }
  else{
    mcw_vcacnim_reset_osl(that);
  }
}