<!DOCTYPE html>
<?php
    include('scrape.php');
?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="keywords" content="did byu win, did brigham young win, did brigham young university
              win, byu, brigham young, byu basketball, byu football, byu sports, byu win, byu lose,
              brigham young basketball, brigham young football, brigham young sports, brigham young win,
              brigham young lose, byu sports scores, brigham young sports scores, did byu win today,
              did byu lose today, did byu win their game today, did byu lose their game today, who did byu play,
              who did brigham young play, did byu win yesterday, did brigham young win yesterday" />
        <meta name="description" content="Latest BYU sports scores and results" />
        <title>Did BYU Win?</title>
        <link rel="stylesheet" type="text/css" href="style.css" />
        <!--Google Analytics-->
        <script type="text/javascript">
            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-28537914-1']);
            _gaq.push(['_trackPageview']);

            (function() {
                var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
            })();
        </script>
        <!--Google +1 Button-->
        <script type="text/javascript">
            (function() {
                var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                po.src = 'https://apis.google.com/js/plusone.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
            })();
        </script>
    </head>
    <body>
        <div id="fb-root"></div>
        <script>(function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
            fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        </script>
		<div id="byu">
			<div id="sports">
				<ul>
					<a href="?sport=football">
						<?php if($isFootball) { ?>
							<li class="selected">Football</li>
						<?php } else { ?>
							<li class="sport">Football</li>
						<?php } ?>
					</a>
					<a href="?sport=basketball">
						<?php if($isFootball) { ?>
							<li class="sport">Basketball</li>
						<?php } else { ?>
							<li class="selected">Basketball</li>
						<?php } ?>
					</a>
				</ul>
			</div>
			<div id="main">
				<div id="title">
					<h1>Did BYU Win?</h1>
				</div>
				<div id="message">
					<?php
						if(strcmp($result, "W") == 0) echo "YES!";
						else if(strcmp($result, "L") == 0) echo "No...";
						else if(strcmp($result, "P") == 0) echo "Postponed";
						else echo "Not yet...";
					?>
				</div>
			</div>
			<div id="stats">
				<h3 id="score" class="center"><a href="<?php echo "http://scores.espn.go.com" . $link ?>"><?php echo $score; ?></a></h3>
				<?php
					//If we're at the last game of the season, display TBA
					if(strcmp($nextGameOpponent, "") != 0) {
						echo "<p class=\"center\">Next game: <a href=\"" . $nextGameLink . " class=\"next\">" . $nextGameDate . " vs " . $nextGameOpponent . "</a></p>";
					}
					else {
						echo "<p class=\"center\">Next game: TBA</p>";
					}
				?>
			</div>
			<footer id="footer">
				<div class="social"><div class="g-plusone" data-size="medium" data-href="http://didbyuwin.com/"></div></div>
				<div class="social"><a href="https://twitter.com/share" class="twitter-share-button" data-url="http://www.didbyuwin.com">Tweet</a><script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script></div>
				<div class="social"><fb:like href="http://www.facebook.com/pages/Did-BYU-Win/219881498099140" send="false" layout="button_count" width="100" show_faces="true"></fb:like></div>
			</footer>
		</div>
    </body>
</html>
