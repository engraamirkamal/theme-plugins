// afterSlideLoad event function
function mcw_vcanim_asl(that){
  $(that).find('.wpb_animate_when_almost_visible:not(.wpb_start_animation)').addClass('wpb_start_animation animated');
}
// afterLoad event function
function mcw_vcanim_al(that){
  if ($(that).find('.fp-slides').length){
    mcw_vcanim_asl($(that).find('.fp-slide.active'));
  }
  else{
    mcw_vcanim_asl(that);
  }
}
