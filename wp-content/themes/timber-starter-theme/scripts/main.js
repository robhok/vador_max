jQuery(document).ready(function ($) {
    var theWindow        = $(window),
        aspectRatio = (16/9),
        $bg              = $(".cover-image-container");
        console.log('yo');
    $(function () {
        $(document).on("scroll", setColorHeader);
        theWindow.resize(resizeBg).trigger('resize');
    });

    var setColorHeader = function () {
      if (theWindow.scrollTop() > 10) {
          $(".header").addClass("header-bgc-black");
      }
      else {
          //remove the background property so it comes transparent again (defined in your css)
          $(".header").removeClass("header-bgc-black");
      }
    }

  	var resizeBg = function() {

  		if ( (theWindow.width() / theWindow.height()) < aspectRatio ) {
        $bg.css({width: theWindow.width(), height: 'auto'});
  		} else {
        $bg.css({width: theWindow.width(), height: theWindow.height()});
  		}

  	};

});
