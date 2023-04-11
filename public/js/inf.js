// var like = function() {
//     $(".likes-bar a").click(function (e) {
//         e.preventDefault();
//         //console.log($(this).data("slug"));
        
//         if ($(this).attr('data-action') === "like") {
//             axios.post('/item/' + $(this).data("slug") + '/like')
//                 .then((response) => {
//                     var likesCount = parseInt($(this).parent().find("span").text());
//                     likesCount++;
//                     $(this).parent().find("span").text(likesCount);
//                     $(".tooltip").remove();
//                     $(this).find(".glyphicon-heart-empty").replaceWith("<i class='glyphicon glyphicon-heart' data-toggle='tooltip' data-placement='bottom' title='Отменить лайк'></i>");
//                     $('[data-toggle="tooltip"]').tooltip();
//                     // var a = $(this);
//                     // console.log($.data(a, "action"));
//                     // $.data(a, "action", "unlike");
//                     // console.log($.data(a, "action"));
//                     $(this).attr('data-action', 'unlike');

//                 })
//                 .catch(response => console.log(response.data));
//         }

//         if ($(this).attr('data-action') === "unlike") {
//             axios.post('/item/' + $(this).data("slug") + '/unlike')
//                 .then((response) => {
//                     var likesCount = parseInt($(this).parent().find("span").text());
//                     likesCount--;
//                     $(this).parent().find("span").text(likesCount);
//                     $(".tooltip").remove();
//                     $(this).find(".glyphicon-heart").replaceWith("<i class='glyphicon glyphicon-heart-empty' data-toggle='tooltip' data-placement='bottom' title='Нравится'></i>");
//                     $('[data-toggle="tooltip"]').tooltip();
//                     // var a = $(this);
//                     // console.log($.data(a, "action"));
//                     // $.data(a, "action", "like");
//                     // console.log($.data(a, "action"));
//                     $(this).attr('data-action', 'like');

//                 })
//                 .catch(response => console.log(response.data));
//         }
//     });
// }

var $container = $('.grid');

// $container.imagesLoaded(function(){
//   $container.masonry({
//     itemSelector: '.item-show',
//     columnWidth: 260
//   });
// });

//$('.pagination').css({'display':'none'});
$('.pagination').css({'opacity':'0', 'margin-left':'-300px'});
//$('.pagination').css({'opacity':'1', 'margin-top':'100%'});
$container.infinitescroll({
  navSelector  : '.pagination',    // selector for the paged navigation 
  nextSelector : '.pagination li.active + li a',  // selector for the NEXT link (to page 2)
  itemSelector : '.item-show',     // selector for all items you'll retrieve
  loading: {
      finishedMsg: '',
      img: ''
    }
  },
  // trigger Masonry as a callback
  function( newElements ) {
    // лайки
    $(newElements).find("a").click(function (e) {
        e.preventDefault();
        //console.log($(this).data("slug"));
        
        if ($(this).attr('data-action') === "like") {
            axios.post('/item/' + $(this).data("slug") + '/like')
                .then((response) => {
                    var likesCount = parseInt($(this).parent().find("span").text());
                    if(!likesCount) likesCount = 0;
                    likesCount++;
                    $(this).parent().find("span").text(likesCount);
                    $(".tooltip").remove();
                    $(this).find(".glyphicon-heart-empty").replaceWith("<i class='glyphicon glyphicon-heart' data-toggle='tooltip' data-placement='bottom' title='Отменить лайк'></i>");
                    $('[data-toggle="tooltip"]').tooltip();
                    // var a = $(this);
                    // console.log($.data(a, "action"));
                    // $.data(a, "action", "unlike");
                    // console.log($.data(a, "action"));
                    $(this).attr('data-action', 'unlike');

                })
                .catch(response => console.log(response.data));
        }

        if ($(this).attr('data-action') === "unlike") {
            axios.post('/item/' + $(this).data("slug") + '/unlike')
                .then((response) => {
                    var likesCount = parseInt($(this).parent().find("span").text());
                    likesCount--;
                    $(this).parent().find("span").text(likesCount);
                    if(likesCount < 1) $(this).parent().find("span").empty();
                    $(".tooltip").remove();
                    $(this).find(".glyphicon-heart").replaceWith("<i class='glyphicon glyphicon-heart-empty' data-toggle='tooltip' data-placement='bottom' title='Нравится'></i>");
                    $('[data-toggle="tooltip"]').tooltip();
                    // var a = $(this);
                    // console.log($.data(a, "action"));
                    // $.data(a, "action", "like");
                    // console.log($.data(a, "action"));
                    $(this).attr('data-action', 'like');

                })
                .catch(response => console.log(response.data));
        }
    });
    // конец лайков
    
    // избранное
    $(newElements).find("a").click(function (e) {
        e.preventDefault();
        //console.log($(this).data("slug"));
        
        if ($(this).attr('data-action') === "favorite") {
            axios.post('/item/' + $(this).data("slug") + '/favorite')
                .then((response) => {
                    var favoritesCount = parseInt($(this).parent().find("span").text());
                    if(!favoritesCount) favoritesCount = 0;
                    favoritesCount++;
                    $(this).parent().find("span").text(favoritesCount);
                    $(".tooltip").remove();
                    $(this).find(".glyphicon-star-empty").replaceWith("<i class='glyphicon glyphicon-star' data-toggle='tooltip' data-placement='bottom' title='Убрать из избранного'></i>");
                    $('[data-toggle="tooltip"]').tooltip();
                    // var a = $(this);
                    // console.log($.data(a, "action"));
                    // $.data(a, "action", "unlike");
                    // console.log($.data(a, "action"));
                    $(this).attr('data-action', 'unfavorite');

                })
                .catch(response => console.log(response.data));
        }

        if ($(this).attr('data-action') === "unfavorite") {
            axios.post('/item/' + $(this).data("slug") + '/unfavorite')
                .then((response) => {
                    var favoritesCount = parseInt($(this).parent().find("span").text());
                    favoritesCount--;
                    $(this).parent().find("span").text(favoritesCount);
                    if(favoritesCount < 1) $(this).parent().find("span").empty();
                    $(".tooltip").remove();
                    $(this).find(".glyphicon-star").replaceWith("<i class='glyphicon glyphicon-star-empty' data-toggle='tooltip' data-placement='bottom' title='Добавить в избранное'></i>");
                    $('[data-toggle="tooltip"]').tooltip();
                    // var a = $(this);
                    // console.log($.data(a, "action"));
                    // $.data(a, "action", "like");
                    // console.log($.data(a, "action"));
                    $(this).attr('data-action', 'favorite');

                })
                .catch(response => console.log(response.data));
        }
    });
    // конец избранного

    $('[data-toggle="tooltip"]').tooltip();
    // hide new items while they are loading
    var $newElems = $( newElements ).css({ opacity: 0 });
    // ensure that images load before adding to masonry layout
    $newElems.imagesLoaded(function(){
      // show elems now they're ready
      $newElems.animate({ opacity: 1 });
      $container.masonry( 'appended', $newElems, true ); 
    });

  }
);