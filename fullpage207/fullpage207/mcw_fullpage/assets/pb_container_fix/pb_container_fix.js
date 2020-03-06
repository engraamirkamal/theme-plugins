$('<?php echo $parent?> <?php echo $section;?>').each(function(){
  $(this).insertBefore($(this).closest('<?php echo $container;?>'));
});
$('<?php echo $parent?>').find('<?php echo $container;?>').remove();