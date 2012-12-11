# jQuery.h5form - HTML Forms Plugin

Author: by Yoshiyuki Mikomde [http://www.rapidexp.com/h5form](http://www.rapidexp.com/h5form)

Copyright (c) 2012 [Yoshiyuki Mikome](http://www.rapidexp.com)
Dual licensed under the MIT (MIT-LICENSE.txt)
and GPL (GPL-LICENSE.txt) licenses.

Built for [jQuery](http://jquery.com)

-----------------------------------------------------------------------------------------------


This plugin gives all browsers the HTML5 forms like the Opera.

Whether these enhancements are determined in the presence or absence of the object in a input element.
For the other versions of browsers, it will be able to support nearly maintenance-free ... maybe.

And this will also fix several bugs of the Internet Explorer on submit, and will allow you to use the button element.



__More information about the support of each browser, [please see here...](http://www.rapidexp.com/h5form)__

And if you wish, you can get a smaller size javascript by removing unnecessary features.





## History

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
