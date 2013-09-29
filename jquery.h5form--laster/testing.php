<!DOCTYPE html>
<html>
  <head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Test of jQuery.h5form</title>

	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/themes/smoothness/jquery-ui.css">
	<link rel="stylesheet" href="css/jquery.h5form--laster.css">

<style>
body, td, input, select, textarea { font-family: Meiryo, sans-serif; font-size: 10pt;  }
strong { color: firebrick; }

table.sample { width: 90%; margin: auto; }
table.sample th { width: 50%; text-align: left; }

.source { position:absolute; display: none; border: 2px solid orange; padding: 5px 10px; color: dimgray; background-color: white; border-radius: 8px; box-shadow: 3px 3px 6px gainsboro; z-index: 3; /*width:400px;*/ }
.source strong { color: firebrick; font-weight: normal; }
h3 sup { font-size: 10px; color: red; }

header { display: block; color: white; background-color: black; padding: 1em 2em;  }
footer { display: block; margin-top: 6em; padding: 1em; color: white; background-color: black; }
header a, footer a { color: yellow; }
section { display: block; margin: 1em; padding-bottom: 2em; }

.h5form-spinNumber button, .h5form-spinTime button { height: 12px; margin-top: 1px; }
.delete  { color: gray; text-decoration: line-through; }
.explanation { color: gray; font-style: italic;  }
</style>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>

	<!-- mask フォーカスで反転するタイプ -->
	<script src="/lib/jquery.maskedinput.js"></script>

	<script src="en/jquery.h5form--laster.js"></script>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>

<script>
$(function() {
	$('form.h5form').h5form({
		timeSpinRatio: 2,
		datepicker: {
			dateFormat: 'yy-mm-dd',
			autoSize: true,
			changeMonth: true,
			changeYear: true,
			showOn: 'button'
		}
	});
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
	<header>
	  <h1>HTML5 Forms using jQuery.h5form</h1>

	  <p>There are a lot of testing  for HTML5 forms.
		Please try to test using Internet Explorer!!<br>
		These forms that have a following class on this page are bound <a href="http://www.rapidexp.com/h5form/">jquery.h5form</a>.</p>


<pre>
  $('form.h5form').h5form();
</pre>

	  <p>The indicators in the title of each testing represents the browsers this plugin will give the enhancement.</p>
	</header>

	<section>
	  <h2>Bugs of Internet Explorer</h2>

	  <h3 id="test-1">Test-1. Press enter key <sup>[IE 8-]</sup></h3>

	  <p>If there is only one text box in a form and you press enter key in the text box, it does not sent any values with IE 8 or earlier.<br>
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




	  <h3 id="test-2">Test-2. Click the button <sup>[IE 7-]</sup></h3>

	  <p>It send the context of clicked button rather than the value with IE 7 or earlier.
		And when you press enter key in a text box, it does not send any values.<br>
		Besides, it send the contexts of all buttons regardless of type "button" or "submit".<br>
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





	  <h3 id="test-3">Test-3. Default type of the button</h3>

	  <p>The default type of a button element is "button" rather than "submit" with IE 7 or earlier.<br>
		However oops, the plugin can not fix this problem.
		We must not eliminate a type of button elements for the time being.</p>

	  <table class="sample">
		<tr>
		  <th>Naked</th>
		  <th>bind h5form</th>
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

		  <td>
			<form action="#test-3" method="post" class="h5form">
			  <input type="text" name="input-3" value="Click the right button!">
			  <button name="test-3" value="This type is not specified.">button</button>
			</form>
<pre class="source" style="display:none">
&lt;form action="#test-3" method="post" <strong>class="h5form"</strong>&gt;
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

	  <h3 id="test-4">Test-4. The required attribute and etc. <sup>[IE 9-]</sup></h3>

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
			  <input type="text" name="input-4a" required><br>
			  <input type="text" name="input-4b" placeholder="xxxx-xxx" pattern="\d{4}-\d{3}" title="Enter such as 1234-567." required><br>
			  <input type="checkbox" name="input-4c" value="Y" required title="You must agree."> I agreee

			  <input type="radio" name="input-4d" value="apple" required> Apple
			  <input type="radio" name="input-4d" value="orange" required> Orange

			  <input type="submit" name="test-4" value="submit">
			</form>
<pre class="source" style="display:none">
&lt;form action="#test-4" method="post"&gt;
  &lt;input type="text" name="input-4a" <strong>required</strong>&gt;&lt;br&gt;
  &lt;input type="text" name="input-4b" <strong>placeholder="xxxx-xxx"</strong>
  <strong>pattern="\d{4}-\d{3}"</strong> title="Enter such as 1234-567." <strong>required</strong>&gt;&lt;br&gt;
  &lt;input type="checkbox" name="input-4c" value="Y"
  <strong>required title="You must agree."</strong>&gt; I agreee
  &lt;input type="submit" name="test-4" value="submit"&gt;
&lt;/form&gt;
</pre>
		  </td>
		  <td>
			<form action="#test-4" method="post" class="h5form">
			  <input type="text" name="input-4a" required><br>
			  <input type="text" name="input-4b" placeholder="xxxx-xxx" pattern="\d{4}-\d{3}" title="Enter such as 1234-567." required><br>
			  <input type="checkbox" name="input-4c" value="Y"  required title="You must agree."> I agreee

			  <input type="radio" name="input-4d" value="apple" required> Apple
			  <input type="radio" name="input-4d" value="orange" required> Orange

			  <input type="submit" name="test-4" value="submit">
			</form>
<pre class="source" style="display:none">
&lt;form action="#test-4" method="post" <strong>class="h5form"</strong>&gt;
  &lt;input type="text" name="input-4a" <strong>required</strong>&gt;&lt;br&gt;
  &lt;input type="text" name="input-4b" <strong>placeholder="xxxx-xxx"</strong>
  <strong>pattern="\d{4}-\d{3}"</strong> title="Enter such as 1234-567." <strong>required</strong>&gt;&lt;br&gt;
  &lt;input type="checkbox" name="input-4c" value="Y"
  <strong>required title="You must agree."</strong>&gt; I agreee
  &lt;input type="submit" name="test-4" value="submit"&gt;
&lt;/form&gt;
</pre>
		  </td>
		</tr>
	  </table>

	  <p id="test-4.5">What about when you press enter key in the text box with button type?</p>

	  <table class="sample">
		<tr>
		  <th>Naked</th>
		  <th>bind h5form</th>
		</tr>
		<tr>
		  <td>
			<form action="#test-4.5" method="post">
			  <input type="text" name="input-4.5" placeholder="Press the enter key!" title="Press the enter key!" required>
			  <button type="submit" name="test-4.5" value="button">button</button>
			</form>
<pre class="source" style="display:none">
&lt;form action="#test-4.5" method="post"&gt;
  &lt;input type="text" name="input-4.5" <strong>placeholder="Press the enter key!"</strong>
  <strong>required</strong> title="Press the enter key!" &gt;
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
  &lt;input type="text" name="input-4.5" <strong>placeholder="Press the enter key!"</strong>
  <strong>required</strong> title="Press the enter key!" &gt;
 &lt;button type="submit" name="test-4.5" value="button"&gt;button&lt;/button&gt;
&lt;/form&gt;
</pre>
		  </td>
		</tr>
	  </table>



	  <h3 id="test-5">Test-5. The maxlength attribute of textarea <sup>[IE 9-]</sup></h3>

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



	  <h3 id="test-6">Test-6. The email and url state <sup>[IE 9-]</sup></h3>

	  <p>
		The validation of the email and the url  will become effective only need to specify a type.
	  </p>


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
&lt;form action="#test-6" method="post" <strong>class="h5form"</strong>&gt;
  &lt;input <strong>type="email"</strong> name="input-6-eml"&gt;&lt;br&gt;
  &lt;input <strong>type="url"</strong> name="input-6-url" placeholder="http://"&gt;
  &lt;input type="submit" name="test-6" value="submit"&gt;
&lt;/form&gt;
</pre>
		  </td>
		</tr>
	  </table>


	  <h3 id="test-7">Test-7. The number and range state <sup>[IE 9-] [Firefox]</sup></h3>

	  <p>
		The plugin to achieve the range states with the help of jQuery UI.
	  </p>

	  <table class="sample">
		<tr>
		  <th>Naked</th>
		  <th>bind h5form</th>
		</tr>

		<tr>
		  <td>
			<form action="#test-7" method="post">
			  <input type="number" name="input-7-num" min="0" max="30" step="0.5" title="From 0 to 30 step 0.5"><br>
			  <input type="range" name="input-7-ran" step="10">
			  <input type="submit" name="test-7" value="submit">
			</form>
<pre class="source" style="display:none">
&lt;form action="#test-7" method="post"&gt;
  &lt;input <strong>type="Number"</strong> name="input-7-num"
    <strong>min="0" max="30" step="0.5"</strong> title="From 0 to 30 step 0.5"&gt;&lt;br&gt;
  &lt;input <strong>type="range"</strong> name="input-7-ran" <strong>step="10"</strong>&gt;
  &lt;input type="submit" name="test-7" value="submit"&gt;
&lt;/form&gt;
</pre>
		  </td>
		  <td>
			<form action="#test-7" method="post" class="h5form">
			  <input type="number" name="input-7-num" min="0" max="30" step="0.5" title="From 0 to 30 step 0.5"><br>
			  <input type="range" name="input-7-ran" step="10">
			  <input type="submit" name="test-7" value="submit">
			</form>
<pre class="source" style="display:none">
&lt;form action="#test-7" method="post" <strong>class="h5form"</strong>&gt;
  &lt;input <strong>type="number"</strong> name="input-7-num"
    <strong>min="0" max="30" step="0.5"</strong> title="From 0 to 30 step 0.5"&gt;&lt;br&gt;
  &lt;input <strong>type="range"</strong> name="input-7-ran" <strong>step="10"</strong>&gt;
  &lt;input type="submit" name="test-7" value="submit"&gt;
&lt;/form&gt;
</pre>
		  </td>
		</tr>
	  </table>

	  <h3 id="test-8">Test-8. The date state and the time state <sup>[IE 10-] [Firefox] [Safari]</sup></h3>

	  <p>Even with the date state, the plugin is achieved with the help of jQuery UI with IE, Firefox and Safari.</p>

	  <table class="sample">
		<tr>
		  <th>Naked</th>
		  <th>bind h5form</th>
		</tr>

		<tr>
		  <td>
			<form action="#test-8" method="post">
			  <input type="date" name="input-8-date1"><br>
			  <input type="date" name="input-8-date2" min="<?php echo date('Y-m-d');?>" max="<?php echo date('Y-m-d', strtotime('+1 week'));?>" title="One week from today"><br>
			  <input type="time" name="input-8-time" min="7:00" max="18:00" step="120" title="From 7:00 to 18:00 step 2 minutes">
			  <input type="submit" name="test-8" value="submit">
			</form>
<pre class="source" style="display:none">
&lt;form action="#test-8" method="post"&gt;
  &lt;input <strong>type="date"</strong> name="input-8-date"></strong>
    <strong>max="<?php echo date('Y-m-d', strtotime('+1 week'));?>"</strong> title="One week from today"&gt;&lt;br&gt;
  &lt;input <strong>type="time"</strong> name="input-8-time" <strong>min="7:00" max="18:00"</strong>
    <strong>step="120"</strong>  title="From 7:00 to 18:00 step 2 minutes"&gt;
  &lt;input type="submit" name="test-8" value="submit" &gt;
&lt;/form&gt;
</pre>
		  </td>
		  <td>
			<form action="#test-8" method="post" class="h5form">
			  <input type="date" name="input-8-date1" value="<?=(isset($_POST['input-8-date1']))?$_POST['input-8-date1']:''?>"><br>
			  <input type="date" name="input-8-date2" min="<?php echo date('Y-m-d');?>" max="<?php echo date('Y-m-d', strtotime('+1 week'));?>" title="One week from today"><br>
			  <input type="time" name="input-8-time" min="7:00" max="18:00" step="120" title="From 7:00 to 18:00 step 2 minutes">
			  <input type="submit" name="test-8" value="submit">
			</form>
<pre class="source" style="display:none">
&lt;form action="#test-8" method="post" <strong>class="h5form</strong>"&gt;
  &lt;input <strong>type="date"</strong> name="input-8-date" <strong>min="<?php echo date('Y-m-d');?>"</strong>
    <strong>max="<?php echo date('Y-m-d', strtotime('+1 week'));?>"</strong> title="One week from today"&gt;&lt;br&gt;
  &lt;input <strong>type="time"</strong> name="input-8-time" <strong>min="7:00" max="18:00"</strong>
    <strong>step="120"</strong>  title="From 7:00 to 18:00 step 2 minutes"&gt;
  &lt;input type="submit" name="test-8" value="submit" &gt;
&lt;/form&gt;
</pre>
		  </td>
		</tr>
	  </table>


	  <h3 id="test-9">Test-9. The date and time state <sup>[IE 10-] [Firefox] [Chrome] [Safari]</sup></h3>

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
		  <td>
			<form action="#test-9" method="post" class="h5form">
			  <input type="datetime" name="input-9-gm" min="<?php echo gmdate('Y-m-d\TH:i:s', ceil(time()/1800)*1800).'Z';?>" step="1800" title="Every 30 minutes from now."><br>
			  <input type="datetime-local" name="input-9-lc" min="<?php echo date('Y-m-d\TH:i:s', ceil(time()/1800)*1800); ?>" step="1800" title="Every 30 minutes from now.">
			  <input type="submit" name="test-9" value="submit">
			</form>
<pre class="source" style="display:none">
&lt;form action="#test-9" method="post" <strong>class="h5form"</strong>&gt;
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


	  <h3 id="test-10">Test-10. The other state </h3>

	  <p>This plugin does not give anything for the month, week and color state.</p>

	  <table class="sample">
		<tr>
		  <th>Naked</th>
		  <th>bind h5form</th>
		</tr>

		<tr>
		  <td>
			<form action="#test-10" method="post">
			  <input type="month" name="input-10-m"><br>
			  <input type="week" name="input-10-w"><br>
			  <input type="color" name="input-10-c">
			  <input type="submit" name="test-10" value="submit">
			</form>
<pre class="source" style="display:none">
&lt;form action="#test-10" method="post"&gt;
  &lt;input <strong>type="month"</strong> name="input-10-m"&gt;&lt;br&gt;
  &lt;input <strong>type="week"</strong> name="input-10-w"&gt;&lt;br&gt;
  &lt;input <strong>type="color"</strong> name="input-10-c"&gt;
  &lt;input type="submit" name="test-10" value="submit"&gt;
&lt;/form&gt;
</pre>
		  </td>
		  <td>
			<form action="#test-10" method="post" class="h5form">
			  <input type="month" name="input-10-m"><br>
			  <input type="week" name="input-10-w"><br>
			  <input type="color" name="input-10-c">
			  <input type="submit" name="test-10" value="submit">
			</form>
<pre class="source" style="display:none">
&lt;form action="#test-10" method="post" <strong>class="h5form"</strong>&gt;
  &lt;input <strong>type="month"</strong> name="input-10-m"&gt;&lt;br&gt;
  &lt;input <strong>type="week"</strong> name="input-10-w"&gt;&lt;br&gt;
  &lt;input <strong>type="color"</strong> name="input-10-c"&gt;
  &lt;input type="submit" name="test-10" value="submit"&gt;
&lt;/form&gt;
</pre>
		  </td>
		</tr>
	  </table>


	  <h3 id="test-11">Test-11. Auto complate off</h3>

	  <p>IE has no feature of the auto complete, so this plugin does not give anything.</p>

	  <table class="sample">
		<tr>
		  <th>Naked</th>
		  <th>bind h5form</th>
		</tr>

		<tr>
		  <td>
			<form action="#test-11" method="post">
			  <input type="text" name="name" value="" autocomplete="off">
			  <button type="submit" name="test-11" value="submit">button</button>
			</form>
<pre class="source" style="display:none">
&lt;form action="#test-11" method="post"&gt;
  &lt;input type="text" name="name" value="" <strong>autocomplete="off"</strong>&gt;
  &lt;button type="submit" name="test-11" value="submit"&gt;button&lt;/button&gt;
&lt;/form&gt;
</pre>
		  </td>


		  <td>
			<form action="#test-11" method="post" class="h5form">
			  <input type="text" name="name" value="" autocomplete="off">
			  <button type="submit" name="test-11" value="submit">button</button>
			</form>
<pre class="source" style="display:none">
&lt;form action="#test-11" method="post" <strong>class="h5form"</strong>&gt;
  &lt;input type="text" name="name" value="" <strong>autocomplete="off"</strong>&gt;
  &lt;button type="submit" name="test-11" value="submit"&gt;button&lt;/button&gt;
&lt;/form&gt;
</pre>
		  </td>
		</tr>
	  </table>

	  <h3 id="test-12">Test-12. Auto complete width Datalist <sup>[IE 8-] <del>[IE 9]</del></sup></h3>

	  <p>
		Even with the plugin, this feature is not available in IE 9. Because it does not read childen of the datalist to DOM.<br>
		To make work even IE 9, you should append a data-option attribute encoded to json in the datalist.
	  </p>

	  <table class="sample">
		<tr>
		  <th>Naked</th>
		  <th>bind h5form</th>
		</tr>

		<tr>
		  <td>
			<form action="#test-12" method="post">
			  <input type="text" name="name" value="" autocomplete="off" list="list-12a">
			  <button type="submit" name="test-12" value="submit">button</button>

			  <datalist id="list-12a">
				<option value="Apple"></option>
				<option value="Avocado"></option>
				<option value="Lemon"></option>
				<option value="Orange"></option>
				<option value="Strawberry"></option>
			  </datalist>

			</form>
<pre class="source" style="display:none">
&lt;form action="#test-12" method="post"&gt;
  &lt;input type="text" name="name" value=""
    <strong>autocomplete="off" list="list-12"</strong>&gt;
  &lt;button type="submit" name="test-12" value="submit"&gt;button&lt;/button&gt;
  <strong>&lt;datalist id="list-12"&gt;</strong>
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
			<form action="#test-12" method="post" class="h5form">
			  <input type="text" name="name" value="" autocomplete="off" list="list-12b">
			  <button type="submit" name="test-12" value="submit">button</button>
			  <datalist id="list-12b" data-option='["Apple","Avocado","Lemon","Orange","Strawberry"]'>
				<option value="Apple"></option>
				<option value="Avocado"></option>
				<option value="Lemon"></option>
				<option value="Orange"></option>
				<option value="Strawberry"></option>
			  </datalist>
			</form>
<pre class="source" style="display:none">
&lt;form action="#test-12" method="post" <strong>class="h5form"</strong>&gt;
  &lt;input type="text" name="name" value=""
    <strong>autocomplete="off" list="list-12"</strong>&gt;
  &lt;button type="submit" name="test-12" value="submit"&gt;button&lt;/button&gt;
  <strong>&lt;datalist id="list-12"</strong>
    <strong>data-option='["Apple","Avocado","Lemon","Orange","Strawberry"]'&gt;</strong>
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
	  <h3 id="test-13">Test-13. The form attribute <sup>[IE 9-]</sup></h3>

	  <p>The following buttons have a form attribute associated with the other form.<br>
		If you click the button, the text of the other form will be send with the value of the cliked button.</p>


	  <table class="sample">
		<tr>
		  <th>Form A</th>
		  <th>Form B</th>
		</tr>

		<tr>
		  <td>
			<form id="form-a" action="#test-13" method="post" class="h5form">
			  <input type="text" name="input-13" value="This is Form A" required>
			  <input type="submit" name="test-13" value="input" form="form-b">
			</form>
<pre class="source" style="display:none">
&lt;form <strong>id="form-a"</strong> action="#test-13" method="post" class="h5form"&gt;
  &lt;input type="text" name="input-13" value="This is From A" required&gt;
  &lt;input type="submit" name="test-13" value="input"
   <strong>form="form-b"</strong>&gt;
&lt;/form&gt;
</pre>
		  </td>
		  <td>
			<form id="form-b" action="#test-13" method="post" class="h5form">
			  <input type="test" name="input-13" value="This is Form B" required>
			  <button type="submit" name="test-13" value="This is Button B" form="form-a">button</button>
			</form>
<pre class="source" style="display:none">
&lt;form <strong>id="form-b"</strong> action="#test-13" method="post" class="h5form"&gt;
  &lt;input type="test" name="input-13" value="This is Form B" required&gt;
  &lt;button type="submit" name="test-13" value="This is Button B"
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


	  <h3 id="test-14">Test-14. The formaction attribute and etc. <sup>[IE 9-]</sup></h3>

	  <p>The right button of each form has form-attributes.
		Please think what happens when you click the each button.</p>

	  <table class="sample">
		<tr>
		  <th>It has attributes of the formaction, the formmethod and the formtarget.</th>
		  <th>It has the formnovalidate attribute.</th>
		</tr>

		<tr>
		  <td>
			<form action="#test-14" method="post" class="h5form">
			  <input type="text" name="q" value="h5form"><br>
			  <button type="submit" name="test-14" value="submit">button</button>
			  <button type="submit" formmethod="get" formaction="http://www.google.com/search" formtarget="_blank">button</button>
			</form>
<pre class="source" style="display:none">
&lt;form action="#test-14" method="post" class="h5form"&gt;
  &lt;input type="text" name="q" value="h5form"&gt;&lt;br&gt;
  &lt;button type="submit" name="test-14" value="submit"&gt;button&lt;/button&gt;
  &lt;button type="submit" <strong>formmethod="get"</strong>
    <strong>formaction="http://www.google.com/search"</strong>
    <strong>formtarget="_blank"</strong>&gt;button&lt;/button&gt;
&lt;/form&gt;
</pre>
		  </td>


		  <td>
			<form action="#test-14" method="post" class="h5form">
			  <input type="text" name="input" required pattern="\d{4}-\d{3}"><br>
			  <button type="submit" name="test-14" value="validate">button</button>
			  <button type="submit" name="test-14" value="novalidate" formnovalidate="novalidate">button</button>
			</form>
<pre class="source" style="display:none">
&lt;form action="#test-14" method="post" class="h5form"&gt;
  &lt;input type="text" name="input" <strong>required pattern="\d{4}-\d{3}"</strong>&gt;&lt;br&gt;
  &lt;button type="submit" name="test-14" value="validate"&gt;button&lt;/button&gt;
  &lt;button type="submit" name="test-14" value="novalidate"
    <strong>formnovalidate="novalidate"</strong>&gt;button&lt;/button&gt;
&lt;/form&gt;
</pre>
		  </td>
		</tr>
	  </table>
	</section>

	<section>
	  <h2>Utilities</h2>

	  <h3 id="test-15">Test-15. checkValidity</h3>

	  <p>
		If one of all elements of the designated selector has an error, it returns FALSE.
	  </p>


	  <table class="sample">
		<tr>
		  <th>Script</th>
		  <th>HTML</th>
		</tr>

		<tr>
		  <td><pre>
$('[name="test-15b"]').click(function() {
    if (<strong>$.fn.h5form.checkValidity($('.test-15'))</strong>) {
        alert('OK');
    } else {
        alert("Here is some errors.");
    }
});
</pre>
		  </td>
		  <td>
			<script type="text/javascript">
				$(function() {
					$('[name="test-15b"]').click(function() {
						if ($.fn.h5form.checkValidity($('.test-15'))) {
							alert('OK');
						} else {
							alert("Here is some errors.");
						}
					});
				});
			</script>
			<form action="#test-15" method="post" class="h5form">
			  <input class="test-15" type="email" name="input-15a" required title="Enter valid email address."><br>
			  <input class="test-15" type="text" name="input-15b" required pattern="\d{4}-\d{3}" title="Enter such as 1234-567.">
			  <input type="submit" name="test-15" value="OK">
			</form>
			<input name="test-15b" type="button" value="checkValidity">
<pre class="source" style="display:none">
&lt;form action="#test-15" method="post" <strong>class="h5form"</strong>&gt;
  &lt;input <strong>class="test-15"</strong> type="email" name="input-15a"
  required title="Enter valid email address."&gt;&lt;br&gt;
  &lt;input <strong>class="test-15"</strong> type="text" name="input-15b" required
  pattern="\d{4}-\d{3}" title="Enter such as 1234-567."&gt;
  &lt;input type="submit" name="test-15" value="OK"&gt;
&lt;/form&gt;
&lt;input <strong>name="test-15b"</strong> type="button" value="checkValidity"&gt;
</pre>
		  </td>
		</tr>
	  </table>


	  <h3 id="test-16">Test-16. setCustomValidity, showBalloon</h3>

	  <p>
		A stored message by setCustomValidity cannot be cleared by other means with modern browsers, but may be cleared by change events with IE.
	  </p>

	  <p>
		And, please adjust the window size of your browser so that the OK button becomes the right-side end.<br>
		The balloon message is performed reversing display of by the position of the OK button.
	  </p>

	  <table class="sample">
		<tr>
		  <th>Script</th>
		  <th>HTML</th>
		</tr>

		<tr>
		  <td><pre>
box = $('[name="input-16"]');
ok = $('[name="test-16"]');

$('#test-16b').click(function() {
    <strong>$.fn.h5form.setCustomValidity</strong>(box, "Here is some errors.");
    <strong>$.fn.h5form.showBalloon</strong>(ok, 'Please click this button!');
});
$('#test-16c').click(function() {
    <strong>$.fn.h5form.setCustomValidity</strong>(box, "");
});
</pre>
		  </td>
		  <td>
			<script type="text/javascript">
				$(function() {
					box = $('[name="input-16"]');
					ok = $('[name="test-16"]');
					$('#test-16b').click(function() {
						$.fn.h5form.setCustomValidity(box, "Here is some errors.");
						$.fn.h5form.showBalloon(ok, 'Please click this button!');
					});
					$('#test-16c').click(function() {
						$.fn.h5form.setCustomValidity(box, "");
					});
				});
			</script>
			<form action="#test-16" method="post" class="h5form">
			  <input type="text" name="input-16">
			  <input type="submit" name="test-16" value="OK">
			</form>
			<input id="test-16b" type="button" value="setCustomValidity">
			<input id="test-16c" type="button" value="Clear">
<pre class="source" style="display:none">
&lt;form action="#test-16" method="post" <strong>class="h5form"</strong>&gt;
  &lt;input type="text" <strong>name="input-16"</strong>&gt;
  &lt;input type="submit" <strong>name="test-16"</strong> value="OK"&gt;
&lt;/form&gt;
&lt;input <strong>id="test-16b"</strong> type="button" value="setCustomValidity"&gt;
&lt;input <strong>id="test-16c"</strong> type="button" value="Clear"&gt;
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
