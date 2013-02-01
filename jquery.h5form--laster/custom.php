<?php

$lang = (isset($_POST['lang'])) ? $_POST['lang'] : 'en';
$necessary = (isset($_POST['necessary'])) ? $_POST['necessary'] : array();

$code = '';
$hide = false;

foreach(file("./$lang/jquery.h5form--laster.js") as $line)
{
	if (preg_match('!^//# +(.+)!', $line, $m))
	{
		$hide = true;

		foreach(preg_split('/[ |]+/', $m[1]) as $key)
		{
			if (in_array($key, $necessary)) $hide = false;
		}
	}
	elseif (preg_match('!^//#!', $line))
	{
		$hide = false;
	}
	elseif (!$hide)
	{
		$code .= $line;
	}
}


$input = tempnam('/var/tmp', 'h5form');
$output = tempnam('/var/tmp', 'h5form');

file_put_contents($input, $code);
exec("yui-compressor --type js  --charset utf8 $input > $output");

$result = "// jQuery.h5form -laster by Author: Yoshiyuki Mikome http://www.rapidexp.com/h5form\n";

if (count($necessary) < 9)
{
	$result .= '// Selected options: '. join(', ', $necessary) . "\n";
}


$result .= file_get_contents($output);

unlink($input);
unlink($output);

header('Content-Disposition: attachment; filename="jquery.h5form-custom.js"');
header('Content-Type: application/octet-stream');
echo $result;

exit;

?>
