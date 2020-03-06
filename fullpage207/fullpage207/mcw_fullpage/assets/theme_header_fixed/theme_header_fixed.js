function mcw_header_padding(){
  /* Header Size */
  var hs = $('<?php echo $header?>').outerHeight();

  /* Set selector padding */
  $('<?php echo $selector?>').css('padding-top', hs + 'px');

  $('.fp-controlArrow').each(function(){
    $(this).css('margin-top', ((hs - $(this).outerHeight()) / 2) + 'px');
  });

  $('#fp-nav').css('padding-top', (hs / 2) + 'px');
  fullpage_api.reBuild();
}
var mcwPaddingTop = $('<?php echo $header?>').height();