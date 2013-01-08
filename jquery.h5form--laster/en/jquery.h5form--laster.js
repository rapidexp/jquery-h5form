/**
 *	jQuery.h5form - HTML5 Forms Plugin
 *	Version -laster / English
 *
 *	Author: by Yoshiyuki Mikomde http://www.rapidexp.com/h5form
 *
 *	Copyright (c) 2012 Yoshiyuki Mikome (http://www.rapidexp.com)
 *	Dual licensed under the MIT (MIT-LICENSE.txt)
 *	and GPL (GPL-LICENSE.txt) licenses.
 *
 *	Built for jQuery library
 *	http://jquery.com
 *
 */
(function($) {

	$.fn.h5form = function(options) {

		$.fn.outerHTML = function() {
			// Firefox 10 or earlier does not have outerHTML
			var obj = $(this).get(0);
			return obj.outerHTML || new XMLSerializer().serializeToString(obj);
		};

		//default configuration properties
		var defaults = {
//# REQUIRED|PATTERN|NUMBER|DATETIME|EMAILURL|MAXLENGTH
			exprResponse: '.h5form-response, .h5form-reversed',
			exprBehind: '.h5fom-behind',
			colorErr: 'mistyrose',
//# REQUIRED
			emptyMessage: 'Please enter this field.',
			unselectedMessage: 'Please select an item in the list.',
//# PATTERN
			patternMessage: 'Does not match the required pattern.',
//# EMAILURL
			emailMessage: 'E-mail address is not correct.',
			urlMessage: 'URL is not correct.',
//# PLACEHOLDER
			colorOff: '#a1a1a1',
//# MAXLENGTH
			maxlengthMessage: 'Too many # characters.',
//# NUMBER|DATETIME
			invalidMessage: 'Value is invalid.',
			minMessage: 'Please be greater than or equal to #.',
			maxMessage: 'Please be less than or equal to #.',
//# NUMBER
			classSpinNumber: 'h5form-spinNumber',
			classRange: 'h5form-range',
//# DATETIME
			classSpinTime: 'h5form-spinTime',
			classDatetime: 'h5form-datetime',
//#
			hasOptions: [],
			dynamicHtml: '.h5form-dynamic'
		};
		var opts = $.extend({}, defaults, options);

		// Test browser
		var ua = window.navigator.userAgent.toLowerCase(),
			version = parseInt($.browser.version),
			isAndroid = (navigator.userAgent.search(/Android/) != -1),
			test1 = $('<input>').hide().appendTo($('body')).get(0),
			test2 = $('textarea:first').get(0) || new Object(),
//# REQUIRED|PATTERN|NUMBER|DATETIME|EMAILURL|MAXLENGTH
			hasCustomValidity = ('setCustomValidity' in test1) && !isAndroid,
			hasAppendTitle = (!!$.browser.webkit && version >= 533) && !isAndroid,
//# AUTOFOCUS
			hasAutofocus = ('autofocus' in test1),
//# REQUIRED
			hasRequired = ('required' in test1) && !isAndroid,
			hasPattern = ('pattern' in test1) && !isAndroid,
//# EMAILURL
			hasEmail = hasUrl = hasCustomValidity && hasPattern && !isAndroid, // maybe
//# PLACEHOLDER
			hasPlaceholder = ('placeholder' in test1),
//# NUMBER
			hasNumber = hasSpin = hasRange =
				('step' in test1) && ('min' in test1) && !isAndroid,
//# DATETIME
			hasDateTime = (!!$.browser.opera && version > 9) && !isAndroid,
			hasDate = hasDateTime ||
				(ua.indexOf('chrome') != -1 && version > 536) && !isAndroid,
			hasTime = hasDateTime,
//# MAXLENGTH
			hasMaxlength = ('maxLength' in test2),
//# FORM
			hasFormAttr = ('form' in test1) && ('formAction' in test1) && !isAndroid,
//#
			hasBugButton = ($.browser.msie && version < 9);
			hasBugEnter = ($.browser.msie && version < 9) || isAndroid;

		for (i in opts.hasOptions) {
			eval(opts.hasOptions[i] + '=true;');
		}

		$('input:last').remove();

		var validatable = ':input:enabled:not(:button, :submit, :radio, :checkbox)';
//# REQUIRED|PATTERN|NUMBER|DATETIME|EMAILURL|MAXLENGTH
		// clear balloons
		$(validatable).click(function() {
			$(this).siblings(opts.exprResponse).remove();
			$(opts.exprBehind).removeAttr('disabled');
		});
//#

		// for each form
		return this.each(function() {

			//Private properties
			var form = $(this),
//# AUTOFOCUS
				elmAutofocus,
//# PLACEHOLDER
				elmPlaceholder = new Array(),
//#
				customValidity = new Object(),
				validatableElements = form.find(validatable),
				novalidate = !!form.outerHTML().match(/^[^>]+ novalidate/);
				// form.attr('novalidate') result undefined,
				// when from has simply "novalidate" rather than "novalidate='novalidate'"

//# REQUIRED|PATTERN|NUMBER|DATETIME|EMAILURL|MAXLENGTH
			/**
			 * Set a custom Validity to the elements
			 * @param {string} message -- message.
			 * @return {object} -- this.
			 */
			$.fn.setCustomValidity = function(customValidity, message) {
				if (novalidate) message = null;
				var ui = $(this);
				if (ui.is(validatable)) {
					// Add a title to the message
					if (!hasAppendTitle && message && (title = ui.getAttr('title'))) {
						message += '\n' + title;
					}
					// Set a custon validity
					if (hasCustomValidity) {
						ui.get(0).setCustomValidity(message);
					} else {
						var i = validatableElements.index(ui);
						if (message) {
							customValidity[i] = new Array(ui, message.replace(/\n/, '<br />'));
							ui.css('backgroundColor', opts.colorErr);
						} else {
							customValidity[i] = null;
							ui.css('backgroundColor', '');
						}
					}
				}
				return ui;
			};

//# NUMBER|DATETIME
			/**
			 * Spin number or time
			 * @param {bool} isDown -- isDown.
			 * @return {object} -- this.
			 */
			$.fn.spin = function(isDown) {
				var ui = $(this),
					isNumber = (ui.getAttr('type').toLowerCase() == 'number'),
					min = attr2num(ui, 'min', (isNumber) ? '' : 0),
					max = attr2num(ui, 'max', (isNumber) ? '' : 86400),
					step = attr2num(ui, 'step', (isNumber) ? 1 : 60),
					base = (isNumber) ? min : 0,
					val = (isNumber) ? Number(ui.val()) : str2sec(ui.val(), true);

				val = val - ((val - base) % step) + step * ((isDown) ? -1 : 1);

				if (max != '' && val > max) val = max;
				if (min != '' && val < min) val = min;

				ui.val((isNumber) ? val : sec2str(val, step % 60, true));
				return ui;
			};
//#

			$.fn.getAttr = function(name) {
				var attr = $(this).attr(name);
				return (attr == undefined) ? '' : attr;
			};

			/**
			 * For each control function
			 * @return {object} -- this.
			 */
			$.fn.initControl = function() {
				return this.each(function() {

					var ui = $(this),
						type = ui.getAttr('type').toLowerCase();

//# AUTOFOCUS
					// Is autofoucs
					if (!hasAutofocus && !elmAutofocus && ui.getAttr('autofocus')) {
						elmAutofocus = ui;
					}
//# PLACEHOLDER
					// Focus and blur attach for Placeholder
					var placeholder = ui.getAttr('placeholder');

					if (!hasPlaceholder && placeholder && type != 'password') {
						elmPlaceholder.push(ui);

						var evFocus = (function() {
							if (ui.val() == placeholder) {
								ui.attr('value', '').css('color', '');
							}
						});
						ui.unbind('focus', evFocus).focus(evFocus);

						var evBlur = (function() {
							if (ui.val() == '' || ui.val() == placeholder) {
								ui.val(placeholder).css('color', opts.colorOff);
							}
						});
						ui.unbind('blur', evBlur).blur(evBlur).blur();
					}

//# NUMBER|DATETIME
					// Spin button
					if (
//# NUMBER
						(!hasSpin && type == 'number') ||
//# DATETIME
						(!hasTime && type == 'time') ||
//# NUMBER|DATETIME
						false) {
						var className, allow;
						switch (type) {
//# NUMBER
						case 'number':
							className = opts.classSpinNumber;
							allow = [8, 9, 35, 36, 37, 39, 46, 190];
							break;
//# DATETIME
						default:
							className = opts.classSpinTime;
							allow = [8, 9, 35, 36, 37, 39, 46, 59, 186, 190];
							break;
//# NUMBER|DATETIME
						}

						// Keydown event attach
						var evKeydown = (function(ev) {
							var cc = ev.charCode || ev.keyCode;
							if (cc == 38) ui.spin(0);
							if (cc == 40) ui.spin(1);
							if (($.inArray(cc, allow) >= 0) || (cc >= 48 && cc <= 57)) return true;
							return false;
						});
						ui.unbind('keydown', evKeydown).keydown(evKeydown)
						.after('<span class="' + className + '">' +
							   '<button type="button">&and;</button>' +
							   '<button type="button">&or;</button></span>');

						// Click button
						ui.next().children().click(function() {
							ui.spin(ui.next().children().index($(this))).change();
							// change for Chrome
						});
					}

//# DATETIME
					// Datepicker
					if (!hasDate && (type == 'date') && ('datepicker' in ui)) {
						var option = { dateFormat: 'yy-mm-dd' };
						option.minDate = ui.getAttr('min');
						option.maxDate = ui.getAttr('max');
						ui.datepicker(option);
					}

//# NUMBER
					// Slider
					if (!hasRange && (type == 'range') && ('slider' in ui)) {
						var min = attr2num(ui, 'min', 0),
							max = attr2num(ui, 'max', 100),
							step = attr2num(ui, 'step', 1),
							val = attr2num(ui, 'val', (min + max) / 2 - ((min + max) / 2 % step));

						ui.hide().after('<span class="' + opts.classRange +
										'"><div></div></span>').val(val);
						ui.next().children().slider({
							min: min, max: max, step: step, value: val,
							change: function(ev, sl) {
								ui.val($(this).slider('value'));
							}
						});
					}

//# MAXLENGTH
					// Maxlength
					if (!hasMaxlength && ui.is('textarea') &&
						(maxlength = ui.getAttr('maxlength'))) {
						// Keypress event attach
						var evKeypress = (function(ev) {
							var cc = ev.charCode || ev.keyCode;
							if (($.inArray(cc, [8, 9, 37, 39, 46]) < 0) &&
								(this.value.length >= maxlength)) {
								return false;
							}
							return true;
						});
						ui.unbind('keypress', evKeypress).keypress(evKeypress);
					}

//# DATETIME
					// Datetime
					if (!hasDateTime && (type == 'datetime' || type == 'datetime-local')) {
						if (!ui.next().hasClass(opts.classDatetime)) {
							var val = getLocalDatetime(ui.val()),
								min = getLocalDatetime(ui.getAttr('min')),
								max = getLocalDatetime(ui.getAttr('max')),
								tz = (type == 'datetime') ?
									'<span class="h5form-timezone">' + getTZ() + '</span>' : '';

							ui.hide().after(
								'<span class="' + opts.classDatetime + '">' +

								'<input type="date" value="' + val[0] + '"' +
								' min="' + min[0] + '" max="' + max[0] + '"' +
								' size="' + ui.getAttr('size') + '"' +
								' class="' + ui.getAttr('class') + '"' +
								' title="' + ui.getAttr('title') + '">' +

								'<input type="time" value="' + val[1] + '"' +
								' step="' + attr2num(ui, 'step', 60) + '"' +
								' size="' + ui.getAttr('size') + '"' +
								' class="' + ui.getAttr('class') + '"' +
								' title="' + ui.getAttr('title') + '">' +
								tz +
								'</span>');
//# REQUIRED|DATETIME
							if (ui.getAttr('required')) {
								ui.removeAttr('required');
								ui.next().children().attr('required', 'required').initControl();
							} else {
//# DATETIME
								ui.next().children().initControl();
//# REQUIRED|DATETIME
							}
//# DATETIME
						}
					}
//#

					/**
					 * Change event
					 * @return {bool} -- isNecessary.
					 */
					var evChange = (function() {

						var isNecessary = false,
							isEmpty = ((ui.val() == '') ||
//# PLACEHOLDER
									   (placeholder && ui.val() == placeholder) ||
//#
									   false);

//# REQUIRED|PATTERN|NUMBER|DATETIME|EMAILURL|MAXLENGTH
						// clear validity first
						ui.setCustomValidity(customValidity, null);
//#
						if (hasBugEnter && !ui.is('select, textarea, button')) {
							// Keypress event attach
							var evKeypress2 = (function(ev) {
								var cc = ev.charCode || ev.keyCode;
								if (cc == 13) {
									form.find('input:submit, button:submit').eq(0).click();
									return false;
								}
								return true;
							});
							ui.unbind('keypress', evKeypress2).keypress(evKeypress2);
							isNecessary = true;
						}
//# REQUIRED
						// Required
						if (!hasRequired && ui.getAttr('required')) {
							isNecessary = true;
							if (isEmpty) {
								ui.setCustomValidity(customValidity, (ui.is('select')) ?
									opts.unselectedMessage : opts.emptyMessage);
								return true;
							}
						}
//# PATTERN
						// Pattern
						if (!hasPattern && (pattern = ui.getAttr('pattern'))) {
							isNecessary = true;
							if (!isEmpty &&
								validateRe(ui, '^(' + pattern.replace(/^\^?(.*)\$?$/, '$1') + ')$')) {
								ui.setCustomValidity(customValidity, opts.patternMessage);
								return true;
							}
						}
//# EMAILURL
						// Email
						if (!hasEmail && type == 'email') {
							isNecessary = true;
							if (!isEmpty && validateRe(ui,
							   '[\\w-\\.]{3,}@([\\w-]{2,}\\.)*([\\w-]{2,}\\.)[\\w-]{2,4}', 'i')) {
								ui.setCustomValidity(customValidity, opts.emailMessage);
								return true;
							}
						}

						// URL
						if (!hasUrl && type == 'url') {
							isNecessary = true;
							if (!isEmpty && validateRe(ui,
							   '[\\w-\\.]{3,}:\\/\\/([\\w-]{2,}\\.)*([\\w-]{2,}\\.)[\\w-]{2,4}',
							   'i')) {
								ui.setCustomValidity(customValidity, opts.urlMessage);
								return true;
							}
						}

//# MAXLENGTH
						// Maxlength
						if (!hasMaxlength && ui.is('textarea') && ui.getAttr('maxlength')) {
							isNecessary = true;
							if (over = validateMaxlength(ui)) {
								ui.setCustomValidity(customValidity,
													 opts.maxlengthMessage.replace(/#/, over));
								return true;
							}
						}

//# NUMBER|DATETIME
						// Number, Date, Time
						if (
//# NUMBER
							(!hasNumber && type == 'number') ||
//# DATETIME
							(!hasDateTime && (type == 'date' || type == 'time')) ||
//# NUMBER|DATETIME
							false) {
							isNecessary = true;

							// Set values to local
							var ui0 = ui, type0 = type, ui2 = ui;
//# DATETIME
							// Is this control within datetime?
							if (ui.parent().hasClass(opts.classDatetime)) {
								ui0 = ui.parent().prev();	// hidden datetime control
								type0 = ui0.getAttr('type').toLowerCase();	// datetime or datetime-local

								ui2 = ui.parent().children('input');	// a set of date & time
								ui2.setCustomValidity(customValidity, '');
								var i = ui2.index(ui), date = ui2.eq(0).val(), time = ui2.eq(1).val();
								if (date != '' || time != '') {
									// Complement the other control if empty
									if (date == '' || time == '') {
										var min = getLocalDatetime(ui0.getAttr('min'), true);	// use min value
										if (i == 0 && date != '' && time == '') { ui2.eq(1).val(min[1]); }
										if (i == 1 && time != '' && date == '') { ui2.eq(0).val(min[0]); }
										date = ui2.eq(0).val(), time = ui2.eq(1).val();
									}
									// Copy to hidden datetime control
									var val = $.trim(date + 'T' + time);
									if (type0 == 'datetime-local') {
										ui0.val(val);
									} else {
										var dt = getUTCDatetime(val);
										ui0.val(dt[0] + 'T' + dt[1]);
									}
								} else {
									ui0.val('');
								}
							}
//# NUMBER|DATETIME
							// Set validation parameters
							var pattern = '^-?\\d+\\.?\\d*$',
								min = 0,
								step = 1;
//# DATETIME
							switch (type0) {
							case 'date':
								pattern = '^\\d+-\\d+-\\d+$';
								min = '1970-01-01';
								step = 1;
								break;
							case 'time':
								pattern = '^\\d+:\\d+:?\\d*\\.?\\d*$';
								min = '00:00';
								step = 60;
								break;
							case 'datetime':
								pattern = '^\\d+-\\d+-\\d+T\\d+:\\d+:?\\d*\\.?\\d*Z$';
								min = '1970-01-01T00:00';
								step = 60;
								break;
							case 'datetime-local':
								pattern = '^\\d+-\\d+-\\d+T\\d+:\\d+:?\\d*\\.?\\d*$';
								min = '1970-01-01T00:00';
								step = 60;
								break;
							}
//# NUMBER|DATETIME
							// Perform validtions
							if (validateRe(ui0, pattern) || (validateStep(ui0, min, step))) {
								ui2.setCustomValidity(customValidity, opts.invalidMessage);
								return true;
							}
							if (validateMin(ui0)) {
								ui2.setCustomValidity(customValidity,
													  opts.minMessage.replace(/#/, ui0.getAttr('min')));
								return true;
							}
							if (validateMax(ui0)) {
								ui2.setCustomValidity(customValidity,
													  opts.maxMessage.replace(/#/, ui0.getAttr('max')));
								return true;
							}
						}
//#
						return isNecessary;
					});

					// Test the change event, to run concurrently
					if (evChange()) {
						// Attach the change event if necessary
						ui.unbind('change', evChange).change(evChange);
					}

				});
			};
			validatableElements.initControl();

//# AUTOFOCUS
			if (elmAutofocus) {
				elmAutofocus.focus().select();	// focus only does not work in IE
			}
//#

			//
			// When submit
			//


			form.find('input:submit, input:image, input:button, button:submit')
				.click(function(ev) {

				if (ev.result == false) return false;	// Canceled in the previous handler

				var ui = $(this);
//# FORM
				if (!hasFormAttr) {
					if (attr = ui.getAttr('formaction')) {
						form.attr('action', attr);
					}
					if (attr = ui.getAttr('formeenctype')) {
						form.attr('enctype', attr);
					}
					if (attr = ui.getAttr('formmethod')) {
						form.attr('method', attr);
					}
					if (attr = ui.getAttr('formtarget')) {
						form.attr('target', attr);
					}
					if (null != ui.attr('formnovalidate')) {
						form.attr('novalidate', 'novalidate');
//# REQUIRED|PATTERN|NUMBER|DATETIME|EMAILURL|MAXLENGTH
						validatableElements.each(function() {
							$(this).setCustomValidity(customValidity, '');
						});
//# FORM
					}
				}
//#
				// Re-scan for dinamic controls
				form.find(opts.dynamicHtml).initControl();

//# REQUIRED|PATTERN|NUMBER|DATETIME|EMAILURL|MAXLENGTH
				// Show balloons message
				if (!hasCustomValidity) {
					var i;
					for (var j in customValidity) {
						if (customValidity[j] && (i == null || i > j)) i = j;
					}
					if (i != null) {
						var err = customValidity[i][0],
							message = customValidity[i][1];
						err = err.eq(0);

						if (!err.prev().is(opts.exprResponse)) {
							var m = opts.exprResponse.match(/^\.([^, ]+),? *\.?([^, ]*)/),
								name = ($(window).width() - err.offset().left < 300 && !!m[2]) ?
									m[2] : m[1];
							err.before('<span class="' + name + '"></span>');
							$(opts.exprBehind).attr('disabled', 'disabled');
						}
						err.prev().html('<p>' + message.replace(/\n/, '<br/>') + '</p>');
						err.focus().select();	// focus only does not work in IE
						return false;
					}
				}
//#
				// Submit if no error

//# PLACEHOLDER
				// Clear Placeholder
				if (!hasPlaceholder) {
					for (var i in elmPlaceholder) {
						if (i != undefined) {
							var elm = elmPlaceholder[i];
							if (elm.val() == elm.getAttr('placeholder')) {
								elm.val('');
							}
						}
					}
				}

//#
				if (hasBugButton)
				{
					// Set a value of button:submit you clicked to input:hidden.
					$('<input type="hidden" name="' + ui.getAttr('name') +
					  '" value="' + ui.val() + '">').appendTo(form);

					form.find('button, input:submit').attr('name', '');

					if (ui.is('button')) {
						form.find('input:submit').remove();
					}
				}
			});

		});

//# PATTERN|EMAILURL|NUMBER|DATETIME
		// Validations
		// if error, result value is true (is not zero).
		// search returns zero when first match.

		function validateRe(item, pattern, flags) {
			re = new RegExp(pattern, flags);
			return ((item.val() != '') && item.val().search(re));
		}
//# MAXLENGTH
		function validateMaxlength(item) {
			var len = item.val().length,
				max = attr2num(item, 'maxlength', 0);
			// if error, reulst value is number of overflow
			return (len && max && (len	> max)) ? len - max : 0;
		}
//# NUMBER|DATETIME
		function validateStep(item, min, step) {
			min = (item.getAttr('type').toLowerCase().indexOf('datetime')) ?
				attr2num(item, 'min', min) : attr2num(item, '', min);
			step = attr2num(item, 'step', step);
			var val = attr2num(item, 'val', '');
			return ((val != '') && ((val - min) % step));
		}
		function validateMin(item) {
			var val = attr2num(item, 'val', ''),
				min = attr2num(item, 'min', '');
			return ((val != '') && (min != '') && (val < min));
		}
		function validateMax(item) {
			var val = attr2num(item, 'val', ''),
				max = attr2num(item, 'max', '');
			return ((val != '') && (max != '') && (val > max));
		}

		// functions of datetime

		function attr2num(item, name, def) {
			var val = (name) ? ((name == 'val') ? item.val() : item.getAttr(name)) : def;
			if (val == undefined || val == '') val = '' + def;
//# DATETIME
			// Result seconds on unix time if the type is time
			// or resuts days on unix time if the type is date
			// because the return value is compared with the step base.
			if (val.match(/\d+-\d+-\d+[ T]\d+:\d/))
				return Date.parse(utc2js(val)) / (1000);	// seconds
			if (val.match(/\d+-\d+-\d+/))
				return Date.parse(utc2js(val)) / (1000 * 60 * 60 * 24);	// days
			if (val.match(/\d+:\d/)) return str2sec(val, true);	// seconds
//# NUMBER|DATETIME
			return Number(val);
		}
//# DATETIME
		function str2sec(str, gmt) {
			if (str.search(/\d+:\d+/)) str = '00:00';
			if (gmt) str += ' GMT';
			return Date.parse('1970/1/1 ' + str) / 1000;
		}
		function sec2str(time, sec, gmt) {
			var date = new Date(time * 1000);
			ret = (gmt) ? date.toUTCString() : toString();
			return ret.replace((sec) ? /.* (\d+:\d+:\d+).*$/ : /.* (\d+:\d+).*$/, '$1');
		}
		function getLocalDatetime(val, NullIsToday) {
			if (!val && !NullIsToday) return new Array('', '');
			// string to date for TZ
			var dt = (!val) ? new Date() : new Date(utc2js(val)),
				date = dt.getFullYear() + '-' + (dt.getMonth() + 1) + '-' + dt.getDate();

			date = date.replace(/\b(\d)\b/g, '0$1');
			var time = (val) ?
				dt.toString().replace(/.* (\d+:\d+:\d+).*$/, '$1') : '12:00';

			return new Array(date, time);
		}
		function getUTCDatetime(val) {
			// string to date for TZ
			var dt = new Date(utc2js(val)),
				date = dt.getUTCFullYear() + '-' + (dt.getUTCMonth() + 1) +
					'-' + dt.getUTCDate();

			date = date.replace(/\b(\d)\b/g, '0$1');
			var time = dt.toUTCString().replace(/.* (\d+:\d+:\d+).*$/, '$1Z');

			return new Array(date, time);
		}
		function utc2js(val) {
			return val.replace(/-/g, '/').replace(/T/, ' ').replace(/Z/, ' GMT')
				.replace(/([+-])(\d+):(\d+)/, ' GMT$1$2$3');
		}
		function getTZ()
		{
			var dt = new Date(),
				min = -1 * dt.getTimezoneOffset();

			if (min) {
				var	ret = min / 60 + ':' + min % 60;
				return ret.replace(/\b(\d)\b/g, '0$1').replace(/^(\d)/, '+$1');
			} else {
				return 'UTC';
			}
		}
//#
	};


})(jQuery);
