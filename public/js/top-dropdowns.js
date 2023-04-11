$(document).ready(function() {
        $(".dropbtn").click(function() {
            if ($(this).parent().find(".top-dropdown").is(":hidden")) {
                $(".top-dropdown").hide();
                $(this).parent().find(".top-dropdown").show();
            }
            else {
                $(this).parent().find(".top-dropdown").hide();
            }
        });
    });

    //Close the dropdown menu if the user clicks outside of it
    window.onclick = function(event) {
      if (!event.target.matches('.dropbtn')) {
        $(".top-dropdown").hide();
      }
    }