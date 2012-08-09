(function($) {

	$.Preloader = function(options) {

    	var settings = {
			itemsLoaded     : 0,
			loaded 		    : false,
			items           : new Array(),
    		onBefore        : function() {},
			onAfter         : function() {},
			onError         : function() {},
			barColor        : "#424312",
			overlayColor    : "#fff",
			barHeight       : "1px",
			overlay         : "#overlay",
			preloader       : "#preloader",
			siteHolder      : "#container"
    	};

    	if (options) {
        	$.extend(settings, options);
   	 	};

		$("html").css({"overflow" : "hidden"});

		$("body").append('<div id="preloader"></div>');
		$("body").append('<div id="overlay"></div>');

		$(settings.overlay).css({
			"background" : settings.overlayColor,
			"top"        : 0,
			"left"       : 0,
			"position"   : "absolute",
			"width"		 : "100%",
			"height"     : "100%",
			"overflow"   : "hidden",
			"z-index"    : 1000
		});

		$(settings.preloader).css({
			"position"   : "absolute",
			"height"     : settings.barHeight,
			"top"        : "50%",
			"background" : settings.barColor,
			"width"      : 0,
			"z-index"    : 1001
		});

		settings.onBefore.apply(this);

		var winWidth = $(window).width();
		var newLeft = (winWidth / 2) - 200;
		var finishLeft = (winWidth + 400) + "px";
		$(settings.preloader).css("left", newLeft + "px");

		function preloadImages() {
			$("body").find("img").each(function() {
				url = $(this).attr("src");
				settings.items.push(url);
				onProgress();
			});
			
			$("table").find("tr").each(function() {				
				onProgress();
			});
		};

		function onProgress() {
			settings.itemsLoaded++;
			animatePreloader();
		};

		function animatePreloader() {
			percentage = (settings.items.length / settings.itemsLoaded) * 100;
			newWidth = percentage * 4;
			if (percentage > 99) {
				$(settings.preloader).stop().animate({width : newWidth + "px"}, 1000, "easeOutQuad", function() {
					$(settings.overlay).fadeOut(1000, function() {
						$("html").css({ "overflow" : "auto" });
						$(settings.overlay).remove();
						$(settings.siteHolder).fadeIn(800);
					});
					settings.onAfter.apply(this);
					$(settings.preloader).animate({"left" : finishLeft}, 1800, "easeOutElastic", function() {
						$(settings.preloader).remove();
					});
				});
			} else {
				$(settings.preloader).stop().animate({width: newWidth + "px"}, 1250, "easeOutQuad");
			}
		};

		preloadImages();

	};

})(jQuery);
