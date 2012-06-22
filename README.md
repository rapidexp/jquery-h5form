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






## History

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
