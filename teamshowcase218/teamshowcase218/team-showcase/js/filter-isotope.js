jQuery( window ).ready( function() {
  ts_isotope_process();
});

jQuery(document).ajaxSuccess(function() {
  ts_isotope_process();
});

function ts_isotope_process(elmts) {

  var container = [];

  jQuery( "div[id*='tshowcase_id_']" ).each(function( index ) {

	layoutMode = 'fitRows';

	if( jQuery(this).find('.tshowcase-box-table').length > 0 ){
		layoutMode = 'vertical';
	}

    // init Isotope
    container[index] = jQuery(this).find('.tshowcase-isotope-wrap').isotope({
      itemSelector: '.tshowcase-isotope',
      layoutMode: layoutMode,
      });

    // init Isotope

    // layout Isotope after each image loads
    container[index].imagesLoaded().progress( function() {
      container[index].isotope('layout');
    });

    //finds all menus and adds the current class to 'all' option
    var menuscontainer = jQuery(this).find('.ts-isotope-filter-nav');
    var menus = menuscontainer.children('ul');

    //searchs for all li entries and set the onclick
    menus.each(function(){

      var thismenu = jQuery(this);

      if(thismenu.find('.ts-current-li').length==0){
          thismenu.find('li.ts-all').addClass('ts-current-li');
      }

      //main options
      thismenu.children('li').on('click',function(ev){

          ev.stopPropagation();

          thismenu.find('li').removeClass('ts-current-li');
          jQuery(this).addClass('ts-current-li');

          var filterValue = '';
          menuscontainer.find('.ts-current-li').each(function(){
              var val = jQuery(this).attr('data-filter');
              if(val!='*') {
                filterValue += val;
              }
           });

           if(filterValue == ''){
              filterValue = '*';
           }

           //stop propagation
           jQuery(this).children('ul').click(function(e) {
                e.stopPropagation();
           });

           console.log(filterValue);
           container[index].isotope({ filter: filterValue });

      });

      //submenus
      thismenu.find('li > ul > li').on('click',function(ev){

          thismenu.find('li').removeClass('ts-current-li');

          jQuery(this).addClass('ts-current-li');

          var filterValue = '';
          menuscontainer.find('.ts-current-li').each(function(){
              var val = jQuery(this).attr('data-filter');
              if(val!='*') {
                filterValue += val;
              }
           });

           if(filterValue == ''){
              filterValue = '*';
           }

           //stop propagation
           jQuery(this).parent().parent().click(function(e) {
                e.stopPropagation();
           });

           //add to parent the current li style only after filter ran
           jQuery(this).parent().parent().addClass('ts-current-li');

           console.log(filterValue);
           container[index].isotope({ filter: filterValue });

           ev.stopPropagation();
      });

	});


	// live search

	if( jQuery('#tshowcasesearch').length > 0 ){

		// quick search regex
		var qsRegex;

		jQuery('#tshowcasesearch input[type="submit"]').on('click',function(e){
			e.preventDefault();

			for (let index = 0; index < container.length; index++) {
				container[index].isotope({
					filter: function() {
						var search = qsRegex ? jQuery(this).text().match( qsRegex ) : true;
						return search;
					}
				});
			}

		})



		// use value of search field to filter
		var quicksearch = jQuery('#tshowcasesearch .ts_text_search').keyup( ts_debounce( function() {
		qsRegex = new RegExp( quicksearch.val(), 'gi' );

		for (let index = 0; index < container.length; index++) {
			container[index].isotope({
				filter: function() {
					var search = qsRegex ? jQuery(this).text().match( qsRegex ) : true;
					return search;
				}
			});
		}

		}, 200 ) );

	}

    if(elmts){
          container[index].isotope( 'appended', elmts )
    }
  });
}


// debounce so filtering doesn't happen every millisecond
function ts_debounce( fn, threshold ) {
  var timeout;
  threshold = threshold || 100;
  return function debounced() {
    clearTimeout( timeout );
    var args = arguments;
    var _this = this;
    function delayed() {
      fn.apply( _this, args );
    }
    timeout = setTimeout( delayed, threshold );
  };
}

