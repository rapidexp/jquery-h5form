# jQuery.h5form - HTML Forms Plugin

Author: by Yoshiyuki Mikome [http://www.rapidexp.com/h5form](http://www.rapidexp.com/h5form)<br>
Copyright (c) 2012 - 2013 [Yoshiyuki Mikome](http://www.rapidexp.com)

Dual licensed under the MIT (MIT-LICENSE.txt)
and GPL (GPL-LICENSE.txt) licenses.

Built for [jQuery](http://jquery.com)

-----------------------------------------------------------------------------------------------


This plugin gives all browsers the HTML5 forms like the Opera.

These enhancements are determined in the presence or absence of the object in a input element.
Therefore it will be able to support nearly maintenance-free for the other versions of browsers.

Some of the features like the date state use to determine the type and version of browser.
Even if the browser improvements, it uses the extension of the plugin.<br>
Because, it is in order to avoid maintenance support
by fixing the state it was in when you install the plugin to your site.

And this will also fix several bugs of the Internet Explorer on submit, and will allow you to use the button element.

This has a large file size for multi-function.
However, it binds only the features that are needed by the browser for the element of the page, and it will work lightly.<br>
If you wish, you can get a smaller size javascript by removing unnecessary features.

__More information about the support of each browser, [please see here...](http://www.rapidexp.com/h5form)__



## History

### Version 2.9.1 (2013-02-16)

* Added support required for checkbox and radio
* Support jQuery 1.9 (exclude 1.6 or earlier)
* Fixed error in IE 7 with the number, date and time state.
* Added datapicker in options.

### Version 2.9.0 (2013-02-01)

* Display number, date and time state as type=text.
* Remove list for conflicts with the autocomplete of browser.
* Default of addSpin is now true.
* Tested with IE 10 RC.
* Shut all hooks to the Opera.
* Corrected the syntax of the array.
* Added styleErr and remove colorErr in options.

### Version 2.8.1 (2013-01-28)

* Added support Autocomplete.
* Fixed enbug of 2.8.0 about button on IE 7.


### Version 2.8.0 (2013-01-12)

* Removed support of time state from Chrome 23.
* Fixed determination of number and rang on FireFox 17.
* Close balloon when also click itself.
* Disabled spin button of Number and time in default.
* Typo of the message in English.
* Stored customValidity in .data() on IE.


### Version 2.7.2 (2012-12-11)

* Fixed the formnovalidate attribute.
* Close balloon when click the owner control.

### Version 2.7.1 (2012-11-14)

* Japanese and English version were not in sync.

### Version 2.7.0 (2012-10-16)

* Invert the balloon that has small right margin.
* Updated css for inverted balloon.
* Added support required when press the Enter on a text box with submission button in Android.
* The required attribute was not working when press the Enter on a text box in IE.

### Version 2.6.1 (2012-09-29)

* Fixed a easy bug.

### Version 2.6.0 (2012-09-29)

* Removed support of date state in Chrome.
* Close balloon when click itself instead of body.
* Added exprResponse in options.
* Added exprBehide in options.
* Removed classResponse in options.

### Version 2.5.0 (2012-09-04)

* Added support Android.
* Added hasOptions in options.


### Version 2.4.4 (2012-07-13)

* Fixed on submit!!! orz orz

### Version 2.4.4 (2012-07-10)

* Fixed en error!! orz


### Version 2.4.3 (2012-07-09)

* Fixed the datetime state that attribue is set to undefined.
* Fixed the datetime state that has the requed attribute.
* Does not submit if canceled in a previous handler.

### Version 2.4.2 (2012-06-30)

* Removed support the form attribute and fixed the button element on submit.
* Fixed the position of the active balloon using the uniqueNumber for get the position.

### Version 2.4.1 (2012-06-26)

* Added the custom download.

### Version 2.4 (2012-06-22)

* Added support the attributes for form submission.

### Version 2.3 (2012-06-18)

* Added support novalidate of form elemnt.

### Version 2.2 (2012-06-15)

* Fixed an error in the form that does not have any input element.
* Added support for bugs in IE on submit.

### Version 2.1 (2012-06-12)

* Judgment of jQuery UI was missing from 2,0.
* Maxlength control was missing from 2.0 in the textarea.
* Allowed the capitalization of the value of the type.

### Version 2.0 (2012-06-10)

* Set to CustomValidity an error during the editing of each control in supported browsers.
* Simulate artificially the CustomValidity in browsers that do not support.
* Judge controls in loading and attach events to only the necessary controls.
* Only display an pre-judgment error when submitting.
* Rescan before submitting for dynamic HTML is now optional.
* Judgment the browser and version is no longer needed except for some functions.
* Removed allBrowsers in options.
