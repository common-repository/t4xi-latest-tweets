jQuery(document).ready(function( $ ) {
	
	var $twIframe = false;
	
	var set = setInterval(function(){

		$twIframe = $("#twitter-widget-0");
	    
	    if($twIframe.length){
	        clearInterval(set);
	        setUpdateCss();
	        setTweetHeight();
	    }
		    
	},1000);

	var setUpdateCss = function() {

		<?
		/* Para recuperar la url del plugin */
		$plugin_dir = dirname(dirname($_SERVER['PHP_SELF']));	
		?>

		$twIframe
		.contents()
		.find('head')
		.append('<link rel="stylesheet" href="<? echo $plugin_dir; ?>/css/style.css" type="text/css" />');

	};

	var setTweetHeight = function() {

		var $tweetHeight = $twIframe.contents().find('.stream').height();

		$twIframe.css({
			"height" : $tweetHeight
		});

	};

});