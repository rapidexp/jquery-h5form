<!DOCTYPE html>
<html>
  <head>
	<meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>Test of jQuery.h5form</title>

	<link rel="stylesheet" type="text/css" href="/lib/css/smoothness/jquery-ui-custom.css" />
	<link rel="stylesheet" type="text/css" href="css/jquery.h5form--laster.css" />

	<style style="text/css">
	  body, td, input, select, textarea { font-family: Meiryo, sans-serif; font-size: 10pt;  }

	  table.sample { width: 90%; margin: auto; }
	  table.sample th { width: 50%; text-align: left; }
	  input[type="number"] { width: 4em; }
	  input[type="date"], input[type="time"] { width: 6em; }
	  .h5form-number { width: 4em; }
	  .h5form-date, .h5form-time { width: 6em; }
	  .source { position:absolute; display: none; border: 2px solid orange; padding: 5px 10px; color: dimgray; background-color: white; border-radius: 8px; box-shadow: 3px 3px 6px gainsboro; z-index: 3; /*width:400px;*/ }
	  .source strong { color: firebrick; font-weight: normal; }
	  h3 sup { font-size: 10px; color: red; }

	  header { display: block; color: white; background-color: black; padding: 1em 2em;  }
	  footer { display: block; margin-top: 6em; padding: 1em; color: white; background-color: black; }
	  header a, footer a { color: yellow; }
	  section { display: block; margin: 1em; padding-bottom: 2em; }

	  .h5form-datetime input { width: 6em; }
	  .h5form-spinNumber button, .h5form-spinTime button { height: 12px; margin-top: 1px; }
	  .delete  { color: gray; text-decoration: line-through; }
	  .explanation { color: gray; font-style: italic;  }
	</style>

	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>
	<script type="text/javascript" src="en/jquery.h5form--laster.js"></script>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>

<script type="text/javascript">
$(function() {
	$('body').append('<datalist></datalist>');
	$('form.h5form').h5form({ addSpin: true });

<?php
foreach ($_POST as $name => $value):
	if (preg_match('/test-/', $name)):
	$response = '$_POST = ' . str_replace(array("'", "\n", '  '), array("\\'", '<br>', '&nbsp;&nbsp;'), print_r($_POST, 1));
?>
		$('#<?php echo $name ?>').before('<span class="h5form-response"><p><?php echo $response ?></p></span>');
<?php endif; endforeach;?>

	$('table.sample td').hover(
		function() {
			$(this).find('.source').show();
		},
		function() {
			$(this).find('.source').hide();
		}
	);

//	$('.delete :input').attr('disabled', 'disabled');

});
</script>

  <?php  if (file_exists('../site.inc.php')) include '../site.inc.php'; ?>
  </head>

  <body>

<form  method="post" class="h5form">

					<ul>
						<li>
							<p>Jm?no:</p>
							<input placeholder="Jm?no" id="jmeno" name="jmeno" type="text" required>
						</li>
						<li>
							<p>Email:</p>
							<input placeholder="Email" id="email" name="email" type="email" required>
						</li>
					</ul>

					<textarea placeholder="Va?e zpr?va..." name="text" id="text" required></textarea>

					<textarea placeholder="Message" name="message" id="message"></textarea>

					<p class="required">*V?echna pole ve formul??i jsou povinn?.</p>
					<button type="submit">Odeslat</button>

				</form>


  </body>
</html>
