jQuery(document).ready(function(){
	ts_trigger_loadmore();
});

function ts_trigger_loadmore() {

	jQuery('.tshowcase').parent().each( function(){

		var layout = jQuery(this);

		layout.find('.ts_load_more').on('click',function(){

			var value  = JSON.parse( layout.attr('data-atts') );

			console.log('load more clicked');

			page = parseInt(jQuery(this).attr('data-page-number'));

		  	value['page']   = page + 1;
		  	value['action'] = 'tshowcase_shortcode_build';

		  var data = {
				  action: 'tshowcase_shortcode_build',
				  post: value,
				  loadmore: '1',
			  };


		  jQuery.post(ajax_object.ajax_url, data, function(response) {

			  console.log(value);
			  var divel = layout.find('.ts-responsive-wrap' ).first(); //find('.ts-responsive-wrap') ?
			  var newcontent = jQuery(response).find('.ts-responsive-wrap').first().contents(); //find('.ts-responsive-wrap') ?

			  if(response.indexOf('ts-isotope-filter-nav') >= 0) {

				  newcontent.hide()
				  .appendTo(divel);

				  console.log('isotope');
					 ts_isotope_process(newcontent);

				 } else {

					 newcontent.hide()
				  	.appendTo(divel)
				  	.fadeIn('slow');


				 }

					 var butn =  layout.find('.ts_load_more');

				    page = parseInt(butn.attr('data-page-number'));
					maxpage = parseInt(butn.attr('data-maximum-page-number'));

				  if(page+1 < maxpage){
					  butn.attr('data-page-number',page+1);
				  } else {
					  butn.fadeOut('slow');
				  }

				  // finally set the new page args to the atts
				  layout.attr('data-atts', JSON.stringify( value ) );

			  });


		});

  });

}
