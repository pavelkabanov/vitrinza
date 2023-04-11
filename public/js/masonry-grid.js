$(document).ready(function() {
    var $grid = $('.grid').imagesLoaded( function() {
        $grid.masonry({
            itemSelector: '.item-show',
            columnWidth: 260,
        });
    });

});


// var $container = $('.grid');

// $container.imagesLoaded(function(){
//   $container.masonry({
//     itemSelector: '.item-show',
//     columnWidth: 260
//   });
// });
// //$('.pagination').css({'display':'none'});
// $('.pagination').css({'opacity':'0', 'margin-left':'-300px'});
// //$('.pagination').css({'opacity':'1', 'margin-top':'100%'});
// $container.infinitescroll({
//   navSelector  : '.pagination',    // selector for the paged navigation 
//   nextSelector : '.pagination li.active + li a',  // selector for the NEXT link (to page 2)
//   itemSelector : '.item-show',     // selector for all items you'll retrieve
//   loading: {
//       finishedMsg: '',
//       img: ''
//     }
//   },
//   // trigger Masonry as a callback
//   function( newElements ) {
//     $('[data-toggle="tooltip"]').tooltip();
//     // hide new items while they are loading
//     var $newElems = $( newElements ).css({ opacity: 0 });
//     // ensure that images load before adding to masonry layout
//     $newElems.imagesLoaded(function(){
//       // show elems now they're ready
//       $newElems.animate({ opacity: 1 });
//       $container.masonry( 'appended', $newElems, true ); 
//     });

//   }
// );
