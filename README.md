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

### Version 2.9.4 (2013-03-15)

* Removed support of time state from Chrome 25.
* Added debug options in options.

### Version 2.9.3 (2013-02-23)

* Added $.fn.showBalloon(selector, message).
* Fixed css of reversed balloon.

### Version 2.9.2 (2013-02-22)

* Draw the line between public and private methods.
* Added $.fn.checkValidity(selector).
* Added $.fn.setCustomValidity(selector, message).
* Hook again to Opera for checkValidity.
* Unnecessary validation in input type="button".
* Spin of number state was as time.
* Error of number, data and time state slipped at submit.
* Tested with Android 4.0.
* Support agin jQuery 1.6.3 or later

### Version 2.9.1 (2013-02-16)

* Added support required for checkbox and radio
* Support jQuery 1.9 (exclude 1.6 or earlier)
* Fixed error on the number, date and time state with IE 7.
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
* Fixed enbug of 2.8.0 about button with IE 7.


### Version 2.8.0 (2013-01-12)

* Removed support of time state from Chrome 23.
* Fixed determination of number and rang with FireFox 17.
* Close balloon when also click itself.
* Disabled spin button of Number and time in default.
* Typo of the message in English.
* Stored customValidity in .data() with IE.


### Version 2.7.2 (2012-12-11)

* Fixed the formnovalidate attribute.
* Close balloon when click the owner control.

### Version 2.7.1 (2012-11-14)

* Japanese and English version were not in sync.

### Version 2.7.0 (2012-10-16)

* Invert the balloon that has small right margin.
* Updated css for inverted balloon.
* Added support required when press the Enter on a text box with submission button with Android.
* The required attribute was not working when press the Enter on a text box with IE.

### Version 2.6.1 (2012-09-29)

* Fixed a easy bug.

### Version 2.6.0 (2012-09-29)

* Removed support of date state from Chrome 22.
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
* Added support for bugs on submit with IE.

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
