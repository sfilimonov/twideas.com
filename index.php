<?require_once './inc/config.php';?><!DOCTYPE HTML><html class="no-js"><head><!--/* @license	* MyFonts Webfont Build ID 1993981, 2012-01-25T09:41:46-0500	* 	* The fonts listed in this notice are subject to the End User License	* Agreement(s) entered into by the website owner. All other parties are 	* explicitly restricted from using the Licensed Webfonts(s).	* 	* You may obtain a valid license at the URLs below.* 	* Webfont: Museo Slab 500 by exljbris	* URL: http://www.myfonts.com/fonts/exljbris/museo-slab/500/	* 	* Webfont: Museo Slab 500 Italic by exljbris	* URL: http://www.myfonts.com/fonts/exljbris/museo-slab/500-italic/	* 	* 	* License: http://www.myfonts.com/viewlicense?type=web&buildid=1993981	* Licensed pageviews: unlimited	* Webfonts copyright: Copyright (c) 2009 by Jos Buivenga. All rights reserved.	* 	* © 2012 Bitstream Inc*/--><!-- Title & Meta --><title>Twideas - Ideas from Twitter</title><meta charset="UTF-8"><meta name="Description" content="Why is there no such a service gathering great ideas from #Twitter to show them to the world #idea? (99 characters used). Now there is — Twideas.com."><meta name="Keywords" content="twitter, idea"><!--<meta name="Viewport" content="width=device-width, user-scalable=false">--><!-- CSS --><link href="http://cdn-images.mailchimp.com/embedcode/slim-081711.css?v=1" rel="stylesheet" type="text/css"><link rel="stylesheet" type="text/css" href="/css/normalize.css"><link rel="stylesheet" type="text/css" href="/css/bootstrap.css"><link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css"><link rel="stylesheet" type="text/css" href="/css/bootstrap-responsive.css"><link rel="stylesheet" type="text/css" href="/css/bootstrap-responsive.min.css"><link rel="stylesheet" type="text/css" href="/css/style.css"><link rel="stylesheet" type="text/css" href="MyFontsWebfontsKit/MyFontsWebfontsKit.css?v=1"><link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'><!-- JS --><script type="text/javascript" src="/js/jquery.js"></script><script type="text/javascript" src="/js/jquery.min.js"></script><script type="text/javascript" src="/js/bootstrap.js"></script><script type="text/javascript" src="/js/bootstrap.min.js"></script><script type="text/javascript" src="/js/modernizr.js"></script><script charset="utf-8" src="http://widgets.twimg.com/j/2/widget.js"></script><!-- iOS --><link rel="apple-touch-icon" href="img/apple-touch-icon-iphone.png" /> <link rel="apple-touch-icon" sizes="72x72" href="img/apple-touch-icon-ipad.png" /> <link rel="apple-touch-icon" sizes="114x114" href="img/apple-touch-icon-iphone4.png" /><link rel="apple-touch-icon" sizes="144x144" href="img/apple-touch-icon-ipad3.png" /><!-- Google Plus --><script type="text/javascript">(function() {var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;po.src = 'https://apis.google.com/js/plusone.js';var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);})();</script><!-- Google Analytics --><script type="text/javascript">	var _gaq = _gaq || [];	_gaq.push(['_setAccount', 'UA-31677868-1']);	_gaq.push(['_trackPageview']);	(function() {	var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;	ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);	})();</script><!-- User Voice --><script type="text/javascript">  var uvOptions = {};  (function() {    var uv = document.createElement('script'); uv.type = 'text/javascript'; uv.async = true;    uv.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'widget.uservoice.com/P97USbuL88HsoanP6Sdmrg.js';    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(uv, s);  })();</script><!-- PHP Engine --><script type="text/javascript">$(document).ready(function(){	var start  = 0;	var main_tag_id = 0;	var featured = 1;	var tweet_filter = 0;    $('#plus').click(function() {        $('#box').html('"People who are crazy enough to think they can change the world are the ones who do."');    });		$('#twideasButton').click(function() {		main_tag_id = 2;		featured = 1;        $(this).addClass('b2');        $(this).removeClass('b1');        $('#ideasButton').removeClass('b2');        $('#ideasButton').addClass('b1');		$('div#tweets').html('<div id="0" class="twideas"></div>');		$('.tagpost').removeClass('a');		$('#tag_id').val(0);		start = 0;		tags();		tweets();		return false;    });		$('#ideasButton').click(function() {		main_tag_id = 1;		featured = 1;        $(this).addClass('b2');        $(this).removeClass('b1');        $('#twideasButton').removeClass('b2');        $('#twideasButton').addClass('b1');		$('div#tweets').html('<div id="0" class="twideas"></div>');		$('.tagpost').removeClass('a');		$('#tag_id').val(0);		start = 0;		tags();		tweets();		return false;    });			$('#featured').click(function() {		featured = 1;        $(this).addClass('tf1');        $(this).removeClass('tf2');        $('#popular').removeClass('tf1');         $('#popular').addClass('tf2');		$('.tagpost').removeClass('a');		tags();		return false;    });		$('#popular').click(function() {		featured = 0;        $(this).addClass('tf1');        $(this).removeClass('tf2');        $('#featured').removeClass('tf1');         $('#featured').addClass('tf2');		$('.tagpost').removeClass('a');		tags();		return false;    });		$('#allIdeas').click(function() {		tweet_filter = 0;				$(this).addClass('ttf1');        $(this).removeClass('ttf2');		$('#week').removeClass('ttf1');         $('#week').addClass('ttf2');        $('#mostRtw').removeClass('ttf1');         $('#mostRtw').addClass('ttf2');				//$('#tag_id').val(0);		$('div#tweets').html('<div id="0" class="twideas"></div>');		start = 0;		tweets();		return false;    });		$('#week').click(function() {		tweet_filter = 1;				$(this).addClass('ttf1');        $(this).removeClass('ttf2');		$('#allIdeas').removeClass('ttf1');         $('#allIdeas').addClass('ttf2');        $('#mostRtw').removeClass('ttf1');         $('#mostRtw').addClass('ttf2');				//$('#tag_id').val(0);		$('div#tweets').html('<div id="0" class="twideas"></div>');		start = 0;		tweets();		return false;    });		$('#mostRtw').click(function() {		tweet_filter = 2;				$(this).addClass('ttf1');        $(this).removeClass('ttf2');		$('#allIdeas').removeClass('ttf1');         $('#allIdeas').addClass('ttf2');        $('#week').removeClass('ttf1');         $('#week').addClass('ttf2');				//$('#tag_id').val(0);		$('div#tweets').html('<div id="0" class="twideas"></div>');		start = 0;		tweets();		return false;    });			function tweets() { 		start = start + 30;		$('div#loader').html('<img src="/img/bigLoader.gif">');			$.post("_get.php",{tag_id:$('#tag_id').val(), start:start, main_tag_id:main_tag_id, featured:featured, tweet_filter:tweet_filter}, function(response, status, xhr) {		  if (status == "success") {			$(".twideas:last").after(response);			$('div#loader').empty();		  }		});		}			function tags() { 		$('#loader2').html('<img src="/img/bigLoader.gif">');		$.post("_tags.php",{main_tag_id:main_tag_id, featured:featured}, function(response, status, xhr) {		  if (status == "success") {			$("#cloud2").html(response);			$('div#loader2').empty();			//$('.tagpost').click(function() {alert('aaa');tagpost(); return false;});		  }		});		}		$('.tagpost').live('click', function() {		start = 0;		d = $(this).attr('rel');		$('#tag_id').val(d);		$('.tagpost').removeClass('a');		$(this).addClass('a');		$('div#tweets').html('<div id="0" class="twideas"></div>');		tweets();		return false;    });	$(window).scroll(function() {		if ($(window).scrollTop() == $(document).height() - $(window).height()){			tweets();		}	}); 		$('#ideasButton').click();	});</script><script>function loadPopup(){  //loads popup only if it is disabled  if($("#bgPopup").data("state")==0){      $("#bgPopup").css({          "opacity": "0.7"      });      $("#bgPopup").fadeIn("medium");      $("#Popup").fadeIn("medium");      $("#bgPopup").data("state",1);  }  }    function disablePopup(){      if ($("#bgPopup").data("state")==1){          $("#bgPopup").fadeOut("medium");          $("#Popup").fadeOut("medium");          $("#bgPopup").data("state",0);      }  }    function centerPopup(){      var winw = $(window).width();      var winh = $(window).height();      var popw = $('#Popup').width();      var poph = $('#Popup').height();      $("#Popup").css({          "position" : "fixed",          "top" : winh/2-poph/2,          "left" : winw/2-popw/2      });      //IE6      $("#bgPopup").css({          "height": winh      });  }  	</script><script>$(document).ready(function() {  $("#bgPopup").data("state",0);  $("#aboutButton").click(function(){      centerPopup();      loadPopup();  });  $("#popupClose, #bgPopup").click(function(){      disablePopup();  });  $(document).keypress(function(e){      if(e.keyCode==27) {          disablePopup();      }  });  });    //Recenter the popup on resize - Thanks @Dan Harvey [http://www.danharvey.com.au/]  $(window).resize(function() {  centerPopup();  }); 	</script></head><body><div id="header">	<div id="headerNavbar" class="navbar navbar-fixed-top">		<div class="navbar-inner">			<div class="container">				<ul class="nav pull-left">					<li id="title">						<img id="logoImg" src="img/logoNew.png" width="50" height="50">						<a href="/">Twideas</a>					</li>					<li class="divider-vertical"></li>				</ul>										<ul class="nav pull-right">					<li class="divider-vertical"></li>					<li><a id="fb" href="http://www.facebook.com/pages/Twideascom/453179844697509"><img src="/img/fb.png" width="25"></a></li>					<li class="divider-vertical"></li>					<li><a href="mailto:feedback@twideas.com"><img src="/img/email.png" width="30"></a></li>					<li class="divider-vertical"></li>					<li id="">					<input type="submit" id="aboutButton">						<div id="Popup">  						<a id="popupClose"></a> 								<blockquote class="twitter-tweet" lang="ru"><p>"Why is there no such a service gathering great ideas from <a href="https://twitter.com/search/%2523Twitter">#Twitter</a> to show them to the world <a href="https://twitter.com/search/%2523idea">#idea</a>?" Now there is — <a href="http://t.co/n8xdScIS" title="http://Twideas.com">Twideas.com</a></p>&mdash; twideas (@twideascom) <a href="https://twitter.com/twideascom/status/225269566551494657" data-datetime="2012-07-17T16:43:44+00:00">июля 17, 2012</a></blockquote> <script src="//platform.twitter.com/widgets.js" charset="utf-8"></script>						<h1>How it works?</h1>						<p>On Twideas.com, you will never find ideas with f-words, lols, and so forth. Users with less than 50 followers will likely not pass the filter as well. There are a lot of other settings and some of them may be rough, but we are working to make the engine better! In the future, we hope to imlement a more sophisticated self-educating system.</p>						<h1>Behind the machine</h1>						<p>Sergey Filimonov, founder, UX & design (<a href="https://twitter.com/#!/sfilimonov" target="_blank">@sfilimonov</a>)</br>Dmitry Shepel, PHP programming.</p> 						</div>  						<div id="bgPopup"></div>  					</li>					<li class="divider-vertical"></li>					</ul>					<div id="donate">						<form action="https://www.paypal.com/cgi-bin/webscr" method="post">						<input type="hidden" name="cmd" value="_s-xclick">						<input type="hidden" name="hosted_button_id" value="N9YUUM88H6NLA">						<input id="donateButton" type="submit" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">						</form>					</div>					<div id="share">						<div id="follow">							<a href="https://twitter.com/twideascom" class="twitter-follow-button" data-show-count="false" data-show-screen-name="false" data-dnt="true">@twideascom</a><script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>							</div>							<div id="gplus">							<g:plusone size="medium" annotation="none" href="http://twideas.com"></g:plusone>							</div>							<div id="fb-like"><iframe src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.facebook.com%2Fpages%2Ftwideascom%2F453179844697509&amp;send=false&amp;&amp;locale=en_US&amp;layout=button_count&amp;width=450&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font=lucida+grande&amp;height=21&amp;appId=164722626955925" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:49px; height:21px;" allowTransparency="true"></iframe></iframe>						</div>					</div> <!-- end #share -->			</div> <!-- end .container -->		</div> <!-- end .navbar-inner -->	</div> <!-- end .navbar --></div> <!-- end #header --><div id="page"><!--<div id="mainButtons">	<a href="#idea" id="ideasButton" class="b2"><span style="color: #474747;">#</span>idea</a><a href="#russia" id="twideasButton" class="b1"><span style="color: #474747;">#</span>twidea</a>	<div class="clear"></div>	<div class="bar1"></div></div>--><div id="mainButtons">	<a href="#idea" id="ideasButton" class="b2"><span style="color: #474747;"></a><a href="#russia" id="twideasButton" class="b1"><span style="color: #474747;"></a>	<div class="clear"></div>	<div id="cloud">		<div class="cloudSelector">			<a href="#" id="featured" class="tf1">			<img id="areas-img" src="/img/intersection.png" width="22" height="22"><div id="areas-name">Areas</div></a>			<a href="#" id="popular" class="tf2">			<img id="tag-img" src="/img/tag.png" width="22" height="22"><div id="tag-name">Tags</div></a>		</div>	<div id="tags2nd">		<form id="form_tag" method="POST" action="">		<input type="hidden" name="tag_id" id="tag_id" value="0" />		<div id="loader2"><img src="/img/bigLoader.gif"></div>		<div id="cloud2"></div>		</form>	</div>	<div class="clear"></div></div>	<!--<div class="options">		<a href="#" id="allIdeas" class="ttf1">For all time</a>		<a href="#" id="week" class="ttf2">For last 30 days</a>	<a href="#" id="mostRtw" class="ttf2">Most retweeted</a>	</div>	-->	<div id="tweets"><div id="0" class="twideas"></div><div id="loader"><img src="/img/bigLoader.gif"></div></div>	<div class="clear"><!-- --></div></div><footer>	<div id="statusbar"></div> </footer></body></html>