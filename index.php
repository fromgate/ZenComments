<?php

require_once ('zen-comments.php');

const PAGE_URL = 'https://comments.prozen.ru'; # site url
const DEFAULT_ID = '0';

$id = $_GET['id'];

if (empty($id)) {
	$ref = getenv("HTTP_REFERER");
	$excert = new ZenExcert($ref);
} else {
    
}



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru"><head>
		<title>comments.prozen.ru &mdash; Coming Soon</title>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<meta name="description" content="This is a default index page for a new domain."/>
		<style type="text/css">
			body {font-size:15px; color:#777777; font-family:arial; text-align:center;}
			h1 {font-size:48px; color:#555555; margin: 70px 0 50px 0;}
			p {width:640px; text-align:center; margin-left:auto;margin-right:auto; margin-top: 30px }
			div {width:640px; text-align:center; margin-left:auto;margin-right:auto;}
			a:link {color: #34536A;}
			a:visited {color: #34536A;}
			a:active {color: #34536A;}
			a:hover {color: #34536A;}                               
		</style>
	</head>

	<body>

<?php
    echo ($excert->get_excerpt());
?>

	<div id="disqus_thread"></div>


	<script>

        /**
         *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
         *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables*/

        var disqus_config = function () {
            this.page.url = '<?php echo ($excert->zenPostUrl) ?>';  // Replace PAGE_URL with your page's canonical URL variable
            this.page.identifier = '<?php echo ($excert->id) ?>'; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
        };

        (function() { // DON'T EDIT BELOW THIS LINE
            var d = document, s = d.createElement('script');
            s.src = 'https://comments-prozen-ru.disqus.com/embed.js';
            s.setAttribute('data-timestamp', +new Date());
            (d.head || d.body).appendChild(s);
        })();
	</script>
	<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
	</body>


</html>