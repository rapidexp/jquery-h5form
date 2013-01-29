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

	$('.delete :input').attr('disabled', 'disabled');

});
</script>

  <?php  if (file_exists('../site.inc.php')) include '../site.inc.php'; ?>
  </head>

  <body>
	<header>
	  <h1>HTML5 Forms using jQuery.h5form</h1>

	  <p>There are a lot of testing  for the HTML5 forms.
		Please try to test using Internet Explorer!!<br>
		These forms that have following class on this page are bound <a href="http://www.rapidexp.com/h5form/">jquery.h5form</a>.</p>


<pre>
  $('form.h5form').h5form();
</pre>

	  <p>The indicators in the title of each testing represent the browsers this plugin will give the enhancement.</p>
	</header>


	<section>
	  <h2>Bugs of Internet Explorer</h2>

	  <h3>Test-1. <a id="test-1">Press the enter key</a> <sup>[IE 8-]</sup></h3>

	  <p>If there is only one text box in the form and you press the enter key in the text box, it does not sent any values on IE 8 or earlier.<br>
		The plugin fixed this problem.</p>


	  <table class="sample">
		<tr>
		  <th>Naked</th>
		  <th>bind h5form</th>
		</tr>

		<tr>
		  <td>
			<form action="#test-1" method="post">
			  <input type="text" name="input-1" value="Press the enter key!">
			  <input type="submit" name="test-1" value="submit">
			</form>
<pre class="source" style="display:none">
&lt;form action="#test-1" method="post"&gt;
  &lt;input type="text" name="input-1" value="Press the enter key!"&gt;
  &lt;input type="submit" name="test-1" value="submit"&gt;
&lt;/form&gt;
</pre>
		  </td>
		  <td>
			<form action="#test-1" method="post" class="h5form">
			  <input type="text" name="input-1" value="Press the enter key!">
			  <input type="submit" name="test-1" value="submit">
			</form>
<pre class="source" style="display:none">
&lt;form action="#test-1" method="post" <strong>class="h5form"</strong>&gt;
  &lt;input type="text" name="input-1" value="Press the enter key!"&gt;
  &lt;input type="submit" name="test-1" value="submit"&gt;
&lt;/form&gt;
</pre>
		  </td>
		</tr>
	  </table>




	  <h3>Test-2. <a id="test-2">Click the button</a> <sup>[IE 7-]</sup></h3>

	  <p>It send the context of clicked button rather than the value on IE 7 or earlier.
		And when you press the enter key in text box, it does not send any values.<br>
		Besides, it send contexts of all buttons regardless of type "button" or "submit".<br>
		The plugin fixed all these problems.</p>

	  <table class="sample">
		<tr>
		  <th>Naked</th>
		  <th>bind h5form</th>
		</tr>

		<tr>
		  <td>
			<form action="#test-2" method="post" id="hoge">
			  <input type="text" name="input-2" value="Which button did you press?"><br>
			  <button type="submit" name="test-2" value="It is the button A">button A</button>
			  <button type="submit" name="test-2" value="It is the button B">button B</button>
			  <button type="button" name="test-2-c" value="It is the button C">button C</button>
			</form>
<pre class="source" style="display:none">
&lt;form action="#test-2" method="post" id="hoge"&gt;
  &lt;input type="text" name="input-2" value="Which button did you press?"&gt;&lt;br&gt;
  &lt;button type="submit" name="test-2" value="It is the button A"&gt;button A&lt;/button&gt;
  &lt;button type="submit" name="test-2" value="It is the button B"&gt;button B&lt;/button&gt;
  &lt;button <strong>type="button"</strong> name="test-2-c" value="It is the button C"&gt;button C&lt;/button&gt;
&lt;/form&gt;
</pre>
		  </td>
		  <td>
			<form action="#test-2" method="post" class="h5form">
			  <input type="text" name="input-2" value="Which button did you press?"><br>
			  <button type="submit" name="test-2" value="It is the button A">button A</button>
			  <button type="submit" name="test-2" value="It is the button B">button B</button>
			  <button type="button" name="test-2-c" value="It is the button C">button C</button>
			</form>
<pre class="source" style="display:none">
&lt;form action="#test-2" method="post" <strong>class="h5form"</strong>&gt;
  &lt;input type="text" name="input-2" value="Which button did you press?"&gt;&lt;br&gt;
  &lt;button type="submit" name="test-2" value="It is the button A"&gt;button A&lt;/button&gt;
  &lt;button type="submit" name="test-2" value="It is the button B"&gt;button B&lt;/button&gt;
  &lt;button type="button" name="test-2-c" value="It is the button C"&gt;button C&lt;/button&gt;
&lt;/form&gt;
</pre>
		  </td>
		</tr>
	  </table>





	  <h3>Test-3. <a id="test-3">Default type of the button</a></h3>

	  <p>The default type of a button element is "button" rather than "submit" on IE 7 or earlier.<br>
		However oops, the plugin can not fix this problem.
		We must not eliminate a type of a button element for the time being.</p>

	  <table class="sample">
		<tr>
		  <th>Naked</th>
		</tr>

		<tr>
		  <td>
			<form action="#test-3" method="post">
			  <input type="text" name="input-3" value="Click the right button!">
			  <button name="test-3" value="This type is not specified.">button</button>
			</form>
<pre class="source" style="display:none">
&lt;form action="#test-3" method="post"&gt;
  &lt;input type="text" name="input-3" value="Click the right button!"&gt;
  <strong>&lt;button name="test-3" value="This type is not specified"&gt;</strong>button&lt;/button&gt;
&lt;/form&gt;
</pre>
		  </td>
		</tr>
	  </table>
	</section>


	<section>
	  <h2>HTML5 Validations</h2>

	  <h3>Test-4. <a id="test-4">The required attribute and etc.</a> <sup>[IE 9-]</sup></h3>

	  <p>The following input elements have new attributes of HTML5 as the placeholder, the pattern and the required.<br>
		And you will not be entered on the text box that an incorrect value.</p>

	  <table class="sample">
		<tr>
		  <th>Naked</th>
		  <th>bind h5form</th>
		</tr>

		<tr>
		  <td>
			<form action="#test-4" method="post">
			  <input type="text" name="input-4" placeholder="xxxx-xxx" pattern="\d{4}-\d{3}" title="Enter such as 1234-567." required>
			  <input type="submit" name="test-4" value="submit">
			</form>
<pre class="source" style="display:none">
&lt;form action="#test-4" method="post"&gt;
  &lt;input type="text" name="input-4" <strong>placeholder="xxxx-xxx" required</strong>
  <strong>pattern="\d{4}-\d{3}"</strong> title="Enter such as 1234-567." &gt;
 &lt;input type="submit" name="test-4" value="submit"&gt;
&lt;/form&gt;
</pre>
		  </td>
		  <td>
			<form action="#test-4" method="post" class="h5form">
			  <input type="text" name="input-4" placeholder="xxxx-xxx" pattern="\d{4}-\d{3}" title="Enter such as 1234-567." required>
			  <input type="submit" name="test-4" value="submit">
			</form>
<pre class="source" style="display:none">
&lt;form action="#test-4" method="post" <strong>class="h5form"</strong>&gt;
  &lt;input type="text" name="input-4" <strong>placeholder="xxxx-xxx" required</strong>
  <strong>pattern="\d{4}-\d{3}"</strong> title="Enter such as 1234-567." &gt;
 &lt;input type="submit" name="test-4" value="submit"&gt;
&lt;/form&gt;
</pre>
		  </td>
		</tr>

		<tr>
		  <td>
			<form action="#test-4.5" method="post">
			  <input type="text" name="input-4.5" placeholder="Press the enter key!" title="Press the enter key!" required>
			  <button type="submit" name="test-4.5" value="button">button</button>
			</form>
<pre class="source" style="display:none">
&lt;form action="#test-4.5" method="post"&gt;
  &lt;input type="text" name="input-4.5" placeholder="Press the enter key!" <strong>required</strong>
  title="Press the enter key!" &gt;
 &lt;button type="submit" name="test-4.5" value="button"&gt;button&lt;/button&gt;
&lt;/form&gt;
</pre>
		  </td>
		  <td>
			<form action="#test-4.5" method="post" class="h5form">
			  <input type="text" name="input-4.5" placeholder="Press the enter key!" title="Press the enter key!" required>
			  <button type="submit" name="test-4.5" value="button">button</button>
			</form>
<pre class="source" style="display:none">
&lt;form action="#test-4.5" method="post" <strong>class="h5form"</strong>&gt;
  &lt;input type="text" name="input-4.5" placeholder="Press the enter key!" <strong>required</strong>
  title="Press the enter key!" &gt;
 &lt;button type="submit" name="test-4.5" value="button"&gt;button&lt;/button&gt;
&lt;/form&gt;
</pre>
		  </td>
		</tr>
	  </table>



	  <h3>Test-5. <a id="test-5">The maxlength attributes of textarea</a> <sup>[IE 9-]</sup></h3>

	  <p>If you are using multi-byte languages, you will notice that the plugin is not able to input monitoring via the input method.<br>
	  However, the plugin will alert the number of characters that has been exceeded as the auxiliary.</p>

	  <table class="sample">
		<tr>
		  <th>Naked</th>
		  <th>bind h5form</th>
		</tr>

		<tr>
		  <td>
			<form action="#test-5" method="post">
			  <textarea name="textarea-5"  maxlength="100" title="Please enter less than 100 characters."></textarea>
			  <input type="submit" name="test-5" value="submit">
			</form>
<pre class="source" style="display:none">
&lt;form action="#test-5" method="post"&gt;
  &lt;textarea name="textarea-5" <strong>maxlength="100"</strong>
    title="Please enter less than 100 characters."&gt;&lt;/textarea&gt;
  &lt;input type="submit" name="test-5" value="submit"&gt;
&lt;/form&gt;
</pre>
		  </td>
		  <td>
			<form action="#test-5" method="post" class="h5form">
			  <textarea name="textarea-5"  maxlength="100" title="Please enter less than 100 characters."></textarea>
			  <input type="submit" name="test-5" value="submit">
			</form>
<pre class="source" style="display:none">
&lt;form action="#test-5" method="post" <strong>class="h5form"</strong>&gt;
  &lt;textarea name="textarea-5" <strong>maxlength="100"</strong>
    title="Please enter less than 100 characters."&gt;&lt;/textarea&gt;
  &lt;input type="submit" name="test-5" value="submit"&gt;
&lt;/form&gt;
</pre>
		  </td>
		</tr>
	  </table>



	  <h3>Test-6. <a id="test-6">The email and url state</a> <sup>[IE 9-]</sup></h3>

	  <p>The validation of email and url state will become effective only need to specify the type.</p>


	  <table class="sample">
		<tr>
		  <th>naked</th>
		  <th>bind h5form</th>
		</tr>

		<tr>
		  <td>
			<form action="#test-6" method="post">
			  <input type="email" name="input-6-eml"><br>
			  <input type="url" name="input-6-url" placeholder="http://">
			  <input type="submit" name="test-6" value="submit">
			</form>
<pre class="source" style="display:none">
&lt;form action="#test-6" method="post"&gt;
  &lt;input <strong>type="email"</strong> name="input-6-eml"&gt;&lt;br&gt;
  &lt;input <strong>type="url"</strong> name="input-6-url" placeholder="http://"&gt;
  &lt;input type="submit" name="test-6" value="submit"&gt;
&lt;/form&gt;
</pre>
		  </td>
		  <td>
			<form action="#test-6" method="post" class="h5form">
			  <input type="email" name="input-6-eml"><br>
			  <input type="url" name="input-6-url" placeholder="http://">
			  <input type="submit" name="test-6" value="submit">
			</form>
<pre class="source" style="display:none">
&lt;form action="#test-6" method="post" class="h5form"&gt;
  &lt;input <strong>type="email"</strong> name="input-6-url"&gt;&lt;br&gt;
  &lt;input <strong>type="url"</strong> name="input-6-eml" placeholder="http://"&gt;
  &lt;input type="submit" name="test-6" value="submit"&gt;
&lt;/form&gt;
</pre>
		  </td>
		</tr>
	  </table>


	  <h3>Test-7. <a id="test-7">The number and range state</a> <sup>[IE 9-] [Firefox]</sup></h3>

	  <p>These states are not currently supported on the Firefox.
		The plugin to achieve the range states with the help of jQuery UI.</p>

	  <table class="sample">
		<tr>
		  <th>Naked</th>
		  <th>bind h5form</th>
		</tr>

		<tr>
		  <td>
			<form action="#test-7" method="post">
			  <input type="number" name="input-7-num" min="12" max="30" step="0.5" title="From 12 to 30 step 0.5"><br>
			  <input type="range" name="input-7-ran" step="10">
			  <input type="submit" name="test-7" value="submit">
			</form>
<pre class="source" style="display:none">
&lt;form action="#test-7" method="post"&gt;
  &lt;input <strong>type="Number"</strong> name="input-7-num"
    <strong>min="12" max="30" step="0.5"</strong> title="From 12 to 30 step 0.5"&gt;&lt;br&gt;
  &lt;input <strong>type="range"</strong> name="input-7-ran" <strong>step="10"</strong>&gt;
  &lt;input type="submit" name="test-7" value="submit"&gt;
&lt;/form&gt;
</pre>
		  </td>
		  <td>
			<form action="#test-7" method="post" class="h5form">
			  <input type="number" name="input-7-num" min="12" max="30" step="0.5" title="From 12 to 30 step 0.5"><br>
			  <input type="range" name="input-7-ran" step="10">
			  <input type="submit" name="test-7" value="submit">
			</form>
<pre class="source" style="display:none">
&lt;form action="#test-7" method="post" class="h5form"&gt;
  &lt;input <strong>type="number"</strong> name="input-7-num"
    <strong>min="12" max="30" step="0.5"</strong> title="From 12 to 30 step 0.5"&gt;&lt;br&gt;
  &lt;input <strong>type="range"</strong> name="input-7-ran" <strong>step="10"</strong>&gt;
  &lt;input type="submit" name="test-7" value="submit"&gt;
&lt;/form&gt;
</pre>
		  </td>
		</tr>
	  </table>

	  <h3>Test-8. <a id="test-8">The date state and the time state</a> <sup>[IE 9-] [Firefox] [Safari]</sup></h3>

	  <p>Even with the date state, the plugin is achieved with the help of jQuery UI on Internet Explorer, Firefox, Chrome and Safari.</p>

	  <table class="sample">
		<tr>
		  <th>Naked</th>
		  <th>bind h5form</th>
		</tr>

		<tr>
		  <td>
			<form action="#test-8" method="post">
			  <input type="date" name="input-8-date" min="<?php echo date('Y-m-d');?>" max="<?php echo date('Y-m-d', strtotime('+1 week'));?>" title="One week from today"><br>
			  <input type="time" name="input-8-time" min="7:00" max="18:00" step="600" title="From 7:00 to 18:00 step 10 minutes">
			  <input type="submit" name="test-8" value="submit">
			</form>
<pre class="source" style="display:none">
&lt;form action="#test-8" method="post"&gt;
  &lt;input <strong>type="date"</strong> name="input-8-date" <strong>min="<?php echo date('Y-m-d');?>"</strong>
    <strong>max="<?php echo date('Y-m-d', strtotime('+1 week'));?>"</strong> title="One week from today"&gt;&lt;br&gt;
  &lt;input <strong>type="time"</strong> name="input-8-time" <strong>min="7:00" max="18:00"</strong>
    <strong>step="600"</strong>  title="From 7:00 to 18:00 step 10 minutes"&gt;
  &lt;input type="submit" name="test-8" value="submit" &gt;
&lt;/form&gt;
</pre>
		  </td>
		  <td>
			<form action="#test-8" method="post" class="h5form">
			  <input type="date" name="input-8-date" min="<?php echo date('Y-m-d');?>" max="<?php echo date('Y-m-d', strtotime('+1 week'));?>" title="One week from today"><br>
			  <input type="time" name="input-8-time" min="7:00" max="18:00" step="600" title="From 7:00 to 18:00 step 10 minutes">
			  <input type="submit" name="test-8" value="submit">
			</form>
<pre class="source" style="display:none">
&lt;form action="#test-8" method="post" class="h5form"&gt;
  &lt;input <strong>type="date"</strong> name="input-8-date" <strong>min="<?php echo date('Y-m-d');?>"</strong>
    <strong>max="<?php echo date('Y-m-d', strtotime('+1 week'));?>"</strong> title="One week from today"&gt;&lt;br&gt;
  &lt;input <strong>type="time"</strong> name="input-8-time" <strong>min="7:00" max="18:00"</strong>
    <strong>step="600"</strong>  title="From 7:00 to 18:00 step 10 minutes"&gt;
  &lt;input type="submit" name="test-8" value="submit" &gt;
&lt;/form&gt;
</pre>
		  </td>
		</tr>
	  </table>


	  <h3>Test-9. <a id="test-9">The date and time state</a> <sup>[IE 9-] [Firefox] [Chrome] [Safari]</sup></h3>

	  <p>In the global date and time state, you can set and get the time as a forced-UTC global data and time string.
		And your user set and view the time in their own time zone.<br>
		In the following forms, please note that the format is different specified minimum value.
		Of course, you will have different format of the return value.</p>

	  <table class="sample">
		<tr>
		  <th>Naked</th>
		  <th>bind h5form</th>
		</tr>

		<tr>
		  <td>
			<form action="#test-9" method="post">
			  <input type="datetime" name="input-9-gm" min="<?php echo gmdate('Y-m-d\TH:i:s', ceil(time()/1800)*1800).'Z';?>" step="1800" title="Every 30 minutes from now."><br>
			  <input type="datetime-local" name="input-9-lc" min="<?php echo date('Y-m-d\TH:i:s', ceil(time()/1800)*1800); ?>" step="1800" title="Every 30 minutes from now.">
			  <input type="submit" name="test-9" value="submit">
			</form>
<pre class="source" style="display:none">
&lt;form action="#test-9" method="post" class="h5form"&gt;
  &lt;input <strong>type="datetime"</strong> name="input-9-gm"
    <strong>min="<?php echo gmdate('Y-m-d\TH:i:s', ceil(time()/1800)*1800).'Z';?>" step="1800"</strong>
    title="Every 30 minutes from now."&gt;&lt;br&gt;
  &lt;input <strong>type="datetime-local"</strong> name="input-9-lc"
    <strong>min="<?php echo date('Y-m-d\TH:i:s', ceil(time()/1800)*1800);?>" step="1800"</strong>
    title="Every 30 minutes from now."&gt;
  &lt;input type="submit" name="test-9" value="submit"&gt;
&lt;/form&gt;
</pre>
		  </td>
		  <td>
			<form action="#test-9" method="post" class="h5form">
			  <input type="datetime" name="input-9-gm" min="<?php echo gmdate('Y-m-d\TH:i:s', ceil(time()/1800)*1800).'Z';?>" step="1800" title="Every 30 minutes from now."><br>
			  <input type="datetime-local" name="input-9-lc" min="<?php echo date('Y-m-d\TH:i:s', ceil(time()/1800)*1800); ?>" step="1800" title="Every 30 minutes from now.">
			  <input type="submit" name="test-9" value="submit">
			</form>
<pre class="source" style="display:none">
&lt;form action="#test-9" method="post"&gt;
  &lt;input <strong>type="datetime"</strong> name="input-9-gm"
    <strong>min="<?php echo gmdate('Y-m-d\TH:i:s', ceil(time()/1800)*1800).'Z';?>" step="1800"</strong>
    title="Every 30 minutes from now."&gt;&lt;br&gt;
  &lt;input <strong>type="datetime-local"</strong> name="input-9-lc"
    <strong>min="<?php echo date('Y-m-d\TH:i:s', ceil(time()/1800)*1800);?>" step="1800"</strong>
    title="Every 30 minutes from now."&gt;
  &lt;input type="submit" name="test-9" value="submit"&gt;
&lt;/form&gt;
</pre>
		  </td>
		</tr>
	  </table>


	  <h3>Test-10. <a id="test-10">Auto complate off</a></h3>

	  <p>IE has no feature of the auto complete, so this plugin does not give anything.</p>

	  <table class="sample">
		<tr>
		  <th>Naked</th>
		  <th>bind h5form</th>
		</tr>

		<tr>
		  <td>
			<form action="#test-10" method="post">
			  <input type="text" name="name" value="" autocomplete="off">
			  <button type="submit" name="test-10" value="submit">button</button>
			</form>
<pre class="source" style="display:none">
&lt;form action="#test-10" method="post"&gt;
  &lt;input type="text" name="name" value="" <strong>autocomplete="off"</strong>&gt;
  &lt;button type="submit" name="test-10" value="submit"&gt;button&lt;/button&gt;
&lt;/form&gt;
</pre>
		  </td>


		  <td>
			<form action="#test-10" method="post" class="h5form">
			  <input type="text" name="name" value="" autocomplete="off">
			  <button type="submit" name="test-10" value="submit">button</button>
			</form>
<pre class="source" style="display:none">
&lt;form action="#test-10" method="post" <strong>class="h5form"</strong>&gt;
  &lt;input type="text" name="name" value="" <strong>autocomplete="off"</strong>&gt;
  &lt;button type="submit" name="test-10" value="submit"&gt;button&lt;/button&gt;
&lt;/form&gt;
</pre>
		  </td>
		</tr>
	  </table>

	  <h3>Test-11. <a id="test-11">Auto complete width Datalist</a> <sup>[IE 8-] <del>[IE 9]</del></sup></h3>

	  <p>
		Even with the plugin, this feature is not available in IE 9. Because it doesn't read childen of the datalist to DOM.<br>
		To make the work even IE 9, you sould add the following meta tag to your header.<br>
		<pre>  &lt;meta http-equiv="X-UA-Compatible" content="IE=10; IE=8"&gt;</pre>
		Note: This document is set "IE=edge" for testing under the plane condition of the browser.
		Please change document mode to IE 8 after press F12 in your IE 9.
	  </p>

	  <table class="sample">
		<tr>
		  <th>Naked</th>
		  <th>bind h5form</th>
		</tr>

		<tr>
		  <td>
			<form action="#test-11" method="post">
			  <input type="text" name="name" value="" autocomplete="off" list="list-11a">
			  <button type="submit" name="test-11" value="submit">button</button>
			  <datalist id="list-11a">
				<option value="Apple"></option>
				<option value="Avocado"></option>
				<option value="Lemon"></option>
				<option value="Orange"></option>
				<option value="Strawberry"></option>
			  </datalist>
			</form>
<pre class="source" style="display:none">
&lt;form action="#test-11" method="post"&gt;
  &lt;input type="text" name="name" value="" <strong>autocomplete="off" list="list-11"</strong>&gt;
  &lt;button type="submit" name="test-11" value="submit"&gt;button&lt;/button&gt;
  <strong>&lt;datalist id="list-11"&gt;</strong>
	&lt;option value="Apple"&gt;&lt;/option&gt;
	&lt;option value="Avocado"&gt;&lt;/option&gt;
	&lt;option value="Lemon"&gt;&lt;/option&gt;
	&lt;option value="Orange"&gt;&lt;/option&gt;
	&lt;option value="Strawberry"&gt;&lt;/option&gt;
  &lt;/datalist&gt;
&lt;/form&gt;
</pre>
		  </td>


		  <td>
			<form action="#test-11" method="post" class="h5form">
			  <input type="text" name="name" value="" autocomplete="off" list="list-11b">
			  <button type="submit" name="test-11" value="submit">button</button>
			  <datalist id="list-11b">
				<option value="Apple"></option>
				<option value="Avocado"></option>
				<option value="Lemon"></option>
				<option value="Orange"></option>
				<option value="Strawberry"></option>
			  </datalist>
			</form>
<pre class="source" style="display:none">
&lt;form action="#test-11" method="post" <strong>class="h5form"</strong>&gt;
  &lt;input type="text" name="name" value="" <strong>autocomplete="off" list="list-11"</strong>&gt;
  &lt;button type="submit" name="test-11" value="submit"&gt;button&lt;/button&gt;
  <strong>&lt;datalist id="list-11"&gt;</strong>
	&lt;option value="Apple"&gt;&lt;/option&gt;
	&lt;option value="Avocado"&gt;&lt;/option&gt;
	&lt;option value="Lemon"&gt;&lt;/option&gt;
	&lt;option value="Orange"&gt;&lt;/option&gt;
	&lt;option value="Strawberry"&gt;&lt;/option&gt;
  &lt;/datalist&gt;
&lt;/form&gt;
</pre>
		  </td>
		</tr>
	  </table>


	</section>


	<section>
	  <h2>Button Attributes</h2>

<div class="delete">
	  <h3>Test-12. <a id="test-12">The form attribute</a> <sup>[IE 9-]</sup></h3>

	  <p>The following buttons have a form attribute associated with the other form.<br>
		If you click the button, the text of the other form will be send with the value of the cliked button.</p>


	  <table class="sample">
		<tr>
		  <th>Form A</th>
		  <th>Form B</th>
		</tr>

		<tr>
		  <td>
			<form id="form-a" action="#test-12" method="post" class="h5form">
			  <input type="text" name="input-12" value="This is Form A" required>
			  <input type="submit" name="test-12" value="input" form="form-b">
			</form>
<pre class="source" style="display:none">
&lt;form <strong>id="form-a"</strong> action="#test-12" method="post" class="h5form"&gt;
  &lt;input type="text" name="input-12" value="This is From A" required&gt;
  &lt;input type="submit" name="test-12" value="input"
   <strong>form="form-b"</strong>&gt;
&lt;/form&gt;
</pre>
		  </td>
		  <td>
			<form id="form-b" action="#test-12" method="post" class="h5form">
			  <input type="test" name="input-12" value="This is Form B" required>
			  <button type="submit" name="test-12" value="This is Button B" form="form-a">button</button>
			</form>
<pre class="source" style="display:none">
&lt;form <strong>id="form-b"</strong> action="#test-12" method="post" class="h5form"&gt;
  &lt;input type="test" name="input-12" value="This is Form B" required&gt;
  &lt;button type="submit" name="test-12" value="This is Button B"
   <strong>form="form-a"</strong>&gt;button&lt;/button&gt;
&lt;/form&gt;
</pre>
		  </td>
		</tr>
	  </table>
</div>
	  <p class="explanation">
		Sorry, this attribute have been removed because it was not work as strict specifications and it was also a breeding ground for bugs for other features.
	  </p>


	  <h3>Test-13. <a id="test-13">The formaction attribute and etc.</a> <sup>[IE 9-]</sup></h3>

	  <p>The right button of each form has the form-attributes.
		Please think what happens when you click each button.</p>

	  <table class="sample">
		<tr>
		  <th>It has attributes of formaction, formmethod and formtarget.</th>
		  <th>It has the formnovalidate attribute.</th>
		</tr>

		<tr>
		  <td>
			<form action="#test-13" method="post" class="h5form">
			  <input type="text" name="q" value="h5form"><br>
			  <button type="submit" name="test-13" value="submit">button</button>
			  <button type="submit" formmethod="get" formaction="http://www.google.com/search" formtarget="_blank">button</button>
			</form>
<pre class="source" style="display:none">
&lt;form action="#test-13" method="post" class="h5form"&gt;
  &lt;input type="text" name="q" value="h5form"&gt;&lt;br&gt;
  &lt;button type="submit" name="test-13" value="submit"&gt;button&lt;/button&gt;
  &lt;button type="submit" <strong>formmethod="get"</strong>
    <strong>formaction="http://www.google.com/search"</strong>
    <strong>formtarget="_blank"</strong>&gt;button&lt;/button&gt;
&lt;/form&gt;
</pre>
		  </td>


		  <td>
			<form action="#test-13" method="post" class="h5form">
			  <input type="text" name="input" required pattern="\d{4}-\d{3}"><br>
			  <button type="submit" name="test-13" value="validate">button</button>
			  <button type="submit" name="test-13" value="novalidate" formnovalidate="novalidate">button</button>
			</form>
<pre class="source" style="display:none">
&lt;form action="#test-13" method="post" class="h5form"&gt;
  &lt;input type="text" name="input" <strong>required pattern="\d{4}-\d{3}"</strong>&gt;&lt;br&gt;
  &lt;button type="submit" name="test-13" value="validate"&gt;button&lt;/button&gt;
  &lt;button type="submit" name="test-13" value="novalidate"
    <strong>formnovalidate="novalidate"</strong>&gt;button&lt;/button&gt;
&lt;/form&gt;
</pre>
		  </td>
		</tr>
	  </table>
	</section>





	<footer>
	  <p>Author: by Yoshiyuki Mikome <a href="http://www.rapidexp.com/h5form">http://www.rapidexp.com/h5form</a><br>
		Copyright (c) 2012 - 2013 <a href="http://www.rapidexp.com">Yoshiyuki Mikome</a>
	  </p>

	  <p>
		Dual licensed under the MIT (MIT-LICENSE.txt) and GPL (GPL-LICENSE.txt) licenses.
	  </p>

	  <p>Built for <a href="http://jquery.com">jQuery</a></p>

	  <p>I wrote this document  under the guidance of English teacher Google.
		I'm sorry if there is a cryptic sentence. ;-)</p>

	</footer>

  </body>
</html>
