/**
 *  Html5 Form Vlidation Plugin for IE - jQuery plugin
 *  Version -laster
 *
 *  Author: by Yoshiyuki Mikomde http://www.rapidexp.com
 *
 *  Copyright (c) 2012 Yoshiyuki Mikome (http://www.rapidexp.com)
 *  Dual licensed under the MIT (MIT-LICENSE.txt)
 *  and GPL (GPL-LICENSE.txt) licenses.
 *
 *  Built for jQuery library
 *	http://jquery.com
 *
 */



This plugin gives all browsers the HTML5 form validation such as Opera. *1

 * The controls of date will be extended in Chrome and Safari.

 * The controls of date and number will be extended in FireFox.

 * In addtiion to them in IE, the attribute of required, spaceHolder, autoFocus
   and novalidate and the validation of url, email and pattern will be all enabled.
   The error message will be balloon like other modern browsers.

 * As a result will not be anything in the Opera.

These features are judged by whether or not the input element has there object.
For future versions of browsers or for unknown browsers, they will be able to
support nearly maintenance-free. *2


And this will also fix all of the bug in IE on submit, and will allow you to use
button elements.

 * When you click the button element of submit, IE does not send the value of the
   clicked button but send the context of all button.

 * When you press Enter in input element of text, IE does not send the value of the
   first button element of submit.

 * When you press Enter in input element of text, IE does not send the value of the
   first input element of submit if there is only one input element of text.

 * The default type of button element in IE is button rather than submit.


Note
 *1 The specification of the global date and time (datetime) has been adopted the
    W3C draft. Therefore, it's user interface is unlike the Opera.

 *2 Whether there is a calendar in the interface of date are determined by the type
    of browser. This part will need to be changed when the version-up of browsers.



Installation
============================

You may only append to your HTML header the following code:

  <link rel="stylesheet" type="text/css" href="css/jquery.h5form-x.x.css" />
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
  <script type="text/javascript" src="jquery.h5form-x.x.min.js"></script>

  <script type="text/javascript">
  $(function() {
    $('form').h5form();
  });
  </script>


Note: IE6/7 will cause an error to use jQuery 1.7.




Options
============================

If you have Dynamic HTML elements that require validation, please add them
to the option "dinamicHtml".


  $('form').h5form({ dinamicHtml: '[name="password"]' });




jQuery UI
============================

Please install the jQeury UI for the type date or range.

  <link rel="stylesheet" type="text/css" href="../../css/smoothness/jquery-ui-custom.css" />
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>

On the elements of type date or range, the datepicker or the slider will be
automatically handle.
Because the judgment the existence of the jQury UI, you don't need to enter
additional settings.



Thanks
============================

This plugin was derived from jquery.html5form-1.5.js.
But the first concept of modification was already different from the original
direction. And I had to make significant changes to policy design in version 2.
Therefore I determined that the project become apparent to another code, I was
allowed to change to a single copyright in the header from version 2.
Some Variable names and structure may still have left a remnant of html5form.


Based project: jquery.html5form-1.5.js
Copyright (c) 2010 Matias Mancini (http://www.matiasmancini.com.ar)




History
============================

Version 2.3		(2012-06-18)

 * Added support novalidate of form elemnt.


Version 2.2		(2012-06-15)

 * Fixed an error in the form that does not have any input element.
 * Added support for bugs in IE on submit.


Version 2.1		(2012-06-12)

 * Judgment of jQuery UI was missing from 2,0.
 * Maxlength control was missing from 2.0 in the textarea.
 * Allowed the capitalization of the value of the type.


Version 2.0		(2012-06-10)

 * Set to CustomValidity an error during the editing of each control in supported browsers.
 * Simulate artificially the CustomValidity in browsers that do not support.
 * Judge controls in loading and attach events to only the necessary controls.
 * Only display an pre-judgment error when submitting.
 * Rescan before submitting for dynamic HTML is now optional.
 * Judgment the browser and version is no longer needed except for some functions.
 * Removed allBrowsers in options.


Version 1.3		(2012-06-07)

 * Added support type=range used jQuery UI.
 * An error has occurred in IE7 or earlier imperceptibly.


Version 1.2.1	(2012-06-06)

 * Fixed IE can not read the value of datetime with time zone.


Version 1.2		(2012-06-05)

 * Renamed again the script file name.
 * Added support type=number.
 * Added support type=time.
 * Added support type=date, datetime and datetime-local used jQuery UI.
 * Improved the maxlength of textarea.
 * Changeed to span the container of responseDiv.


Version 1.1		(2012-05-31)

 * Added support realtime Validation.


Version 1.0		(2012-05-26)

 * Added support dinamic required.
 * Added support pattern and type=url.


Version 0.0		(2012-05-18)

 * Modified html5form-1.5.js as not to assume asynchronous ajax.
 * Error message will be displayed in balloons for each control.




I wrote this document while under the guidance of English teacher Google.
I'm sorry if there is a cryptic sentence. ;-)
