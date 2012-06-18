/**
 *  Html5 Form Vlidation Plugin - jQuery plugin
 *  Version -laster  / Japanese
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
(function($){

    $.fn.h5form = function(options) {

		$.fn.outerHTML = function() {
			// Firefox 10 or earlier does not have outerHTML
			var obj = $(this).get(0);
			return obj.outerHTML || new XMLSerializer().serializeToString(obj);
		};

		//default configuration properties
		var defaults = {
			classResponse : 'h5form-response',
			classSpinNumber : 'h5form-spinNumber',
			classSpinTime : 'h5form-spinTime',
			classRange : 'h5form-range',
			classDatetime: 'h5form-datetime',
			classDummy: 'h5form-dummy',
			colorOff : '#a1a1a1',
			colorErr : 'mistyrose',
			emptyMessage : 'このフィールドを入力してください。',
			unselectedMessage : 'リスト内の項目を選択してください。',
			emailMessage : 'メールアドレスが正しくありません。',
			urlMessage : 'URLが正しくありません。',
			patternMessage : '必用なパターンに一致していません。',
			invalidMessage : '値が無効です。',
			minMessage : '# 以上にしてください。',
			maxMessage : '# 以下にしてください。',
			maxlengthMessage : '指定の文字数上限より # 文字多いです。',
			dinamicHtml : false
		};
		var opts = $.extend({}, defaults, options);

		// Test browser
		var version = parseInt($.browser.version),
 			test1 = $('<input>').hide().appendTo($('body')).get(0),
 			test2 = $('textarea:first').get(0) || new Object(),
//			test3 = $('button:first').get(0) || new Object(),
			hasCustomValidity = ('setCustomValidity' in test1),
			hasAppendTitle = ($.browser.webkit && version >= 533),	// maybe
			hasAutofocus = ('autofocus' in test1),
			hasRequired = ('required' in test1),
			hasPlaceholder = ('placeholder' in test1),
			hasPattern = ('pattern' in test1),
			hasEmail = hasUrl = hasCustomValidity && hasPattern, // maybe
			hasNumber  = hasRange = ('step' in test1) && ('min' in test1),	// maybe
			hasDateTime = ($.browser.opera && version > 9),	// maybe
			hasMaxlength = ('maxLength' in test2),
//			hasFormAttr = ('formAction' in test3),
			hasIeBugs = ($.browser.msie && version < 9);

		$('input:last').remove();

		// clear balloons
		$('body').click(function () {
			$('.'+opts.classResponse).remove();
		});

		// for each form
        return this.each(function() {

            //Private properties
            var form = $(this),
				elmAutofocus,
				elmPlaceholder = new Array(),
				customValidity = new Object(),
				validatable = ':input:enabled:not(:button, :submit, :radio, :checkbox, :hidden)',
				validatableElements = form.find(validatable),
				novalidate = !!form.outerHTML().match(/^[^>]+ novalidate/);
				// form.attr('novalidate') result undefined,
				// when from has novalidate rather than novalidate="novalidate"

			/**
			 * Set a custom Validity to the elements
			 * @param string message
			 * @return object this
			 */
			$.fn.setCustomValidity = function(message) {
				return this.each(function() {
					if (novalidate) message = null;
					var ui = $(this);
					if (ui.is(validatable)) {
						// Add a title to the message
						if (!hasAppendTitle && message && (title = ui.attr('title'))) {
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
				});
			};

			/**
			 * Spin number or time
			 * @param bool isDown
			 * @return object this
			 */
			$.fn.spin = function(isDown) {
				var ui = $(this),
					isNumber = (ui.attr('type').toLowerCase() == 'number'),
					min = attr2num(ui, 'min', (isNumber) ? '' : 0),
					max = attr2num(ui, 'max', (isNumber) ? '' : 86400),
					step = attr2num(ui, 'step', (isNumber) ? 1 : 60),
					base = (isNumber) ? min : 0,
					val = (isNumber) ? Number(ui.val()) : str2sec(ui.val(), true);

				val = val - ((val - base) % step) + step * ((isNumber) ? -1 : 1);

				if (max != '' && val > max) val = max;
				if (min != '' && val < min) val = min;

				ui.val((isNumber) ? val : sec2str(val, step%60, true));
				return ui;
			};

			/**
             * For each control function
			 * @return object this
			 */
			$.fn.initControl = function() {
				return this.each(function() {

					var ui = $(this),
						type = ui.attr('type'),
						placeholder = ui.attr('placeholder');
					if (type) type = type.toLowerCase();

					// Is autofoucs
					if (!hasAutofocus && !elmAutofocus && ui.attr('autofocus')) {
						elmAutofocus = ui;
					}

					// Focus and blur attach for Placeholder
					if (!hasPlaceholder && placeholder && type != 'password') {
						elmPlaceholder.push(ui);

						var evFocus  = (function() {
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


					// Spin button
					if ((!hasNumber && type=="number") || (!hasDateTime && type == "time")) {
						var isNumber = (type == 'number'),
							className = (isNumber) ? opts.classSpinNumber : opts.classSpinTime,
							allow = [8, 9, 35, 36, 37, 39, 46].concat((isNumber) ? [190] : [59, 186, 190]);

						// Keydown event attach
						var evKeydown = (function(ev) {
							var cc = ev.charCode || ev.keyCode;
							if (cc == 38) ui.spin(0);
							if (cc == 40) ui.spin(1);
							if (($.inArray(cc, allow) >= 0) || (cc >= 48 && cc <= 57)) return true;
							return false;
						});
						ui.unbind('keydown', evKeydown).keydown(evKeydown)
						.after('<div class="'+className+'">'+
							   '<button type="button">&and;</button>'+
							   '<button type="button">&or;</button></div>');

						// Click button
						ui.next().children().click(function() {
							ui.spin(ui.next().children().index($(this))).change();	// change for Chrome
						});
					}

					// Datepicker
					if (!hasDateTime && (type == 'date') && ('datepicker' in ui)) {
						var option = { dateFormat : 'yy-mm-dd' }
						if (ui.attr('min') != undefined) option.minDate = ui.attr('min');
						if (ui.attr('max') != undefined) option.maxDate = ui.attr('max');
						ui.datepicker(option);
					}

					// Slider
					if (!hasRange && (type == 'range') && ('slider' in ui)) {
						var min = attr2num(ui, 'min', 0),
							max = attr2num(ui, 'max', 100),
							step = attr2num(ui, 'step', 1),
							val = attr2num(ui, 'val', (min+max)/2 - ((min+max)/2%step));

						ui.hide().after('<div class="'+opts.classRange+'"><div></div></div>').val(val);
						ui.next().children().slider({
							min: min, max: max, step: step, value: val,
							change : function(ev, sl) {
 								ui.val($(this).slider('value'));
							}
						});
					}

					// Maxlength
					if (!hasMaxlength && ui.is('textarea') && (maxlength = ui.attr('maxlength'))) {
						// Keypress event attach
						var evKeypress = (function(ev) {
							var cc = ev.charCode || ev.keyCode;
							if (($.inArray(cc, [8, 9, 37, 39, 46]) < 0) &&
								(this.value.length >= maxlength)) {
								return false;
							}
							return true;
						});
						ui.unbind('keypress', evKeypress).keypress(evKeypress)
					}

					// Datetime
					if (!hasDateTime && (type == 'datetime' || type == 'datetime-local')) {
						if (!ui.next().hasClass(opts.classDatetime)) {
							var val = getLocalDatetime(ui.val()),
								min = getLocalDatetime(ui.attr('min')),
								max = getLocalDatetime(ui.attr('max'));

							ui.hide().after('<span class="'+opts.classDatetime+'">'+
											'<input type="date" value="'+val[0]+'" min="'+min[0]+'" max="'+max[0]+'"'+
											' size="'+ui.attr('size')+'" class="'+ui.attr('class')+'" title="'+ui.attr('title')+'">'+
											'<input type="time" value="'+val[1]+'" step="'+attr2num(ui, 'step', 60)+'"'+
											' size="'+ui.attr('size')+'" class="'+ui.attr('class')+'" title="'+ui.attr('title')+'">'+
											'</span>')
							.next().children().initControl();
						}
					}


					/**
					 * Change event
					 * @return bool isNecessary
					 */
					var evChange = (function() {

						var isNecessary = false,
							isEmpty = (ui.val() == '' || (placeholder && ui.val() == placeholder));

						// clear validity first
						ui.setCustomValidity('');

						// Required
						if (!hasRequired && ui.attr('required')) {
							isNecessary = true;
							if (isEmpty) {
								ui.setCustomValidity((ui.is('select')) ? opts.unselectedMessage : opts.emptyMessage);
								return true;
							}
						}

						// Pattern
						if (!hasPattern && (pattern = ui.attr('pattern'))) {
							isNecessary = true;
							if (!isEmpty && validateRe(ui, '^(' + pattern.replace(/^\^?(.*)\$?$/, '$1') + ')$')) {
								ui.setCustomValidity(opts.patternMessage);
								return true;
							}
						}

						// Email
						if (!hasEmail && type == 'email') {
							isNecessary = true;
							if (!isEmpty && validateRe(ui, '[\\w-\\.]{3,}@([\\w-]{2,}\\.)*([\\w-]{2,}\\.)[\\w-]{2,4}', 'i')) {
								ui.setCustomValidity(opts.emailMessage);
								return true;
							}
						}

						// URL
						if (!hasUrl && type == 'url') {
							isNecessary = true;
							if (!isEmpty && validateRe(ui, '[\\w-\\.]{3,}:\\/\\/([\\w-]{2,}\\.)*([\\w-]{2,}\\.)[\\w-]{2,4}', 'i')) {
								ui.setCustomValidity(opts.urlMessage);
								return true;
							}
						}

						// Maxlength
						if (!hasMaxlength && ui.is('textarea') && ui.attr('maxlength')) {
							isNecessary = true;
							if (over = validateMaxlength(ui)) {
								ui.setCustomValidity(opts.maxlengthMessage.replace(/#/, over));
								return true;
							}
						}

						// Number, Date, Time
						if ((!hasNumber && type == 'number') ||
							(!hasDateTime && (type == 'date' || type == "time"))) {
							isNecessary = true;

							// Set values to local
							var ui0 = ui, type0 = type, ui2 = ui;;

							// Is this control within datetime?
							if (ui.parent().hasClass(opts.classDatetime)) {
								ui0 = ui.parent().prev();	// hidden datetime control
								type0 = ui0.attr('type').toLowerCase();	// datetime or datetime-local

								ui2 = ui.parent().children();	// a set of date & time
								ui2.setCustomValidity('');
								var i = ui2.index(ui), date = ui2.eq(0).val(), time = ui2.eq(1).val();
								if (date != '' || time != '') {
									// Complement the other control if empty
									if (date == '' || time == '') {
										var min = getLocalDatetime(ui0.attr('min'), true);	// use min value
										if (i == 0 && date != '' && time == '') { ui2.eq(1).val(min[1]); }
										if (i == 1 && time != '' && date == '') { ui2.eq(2).val(min[0]); }
										date = ui2.eq(0).val(), time = ui2.eq(1).val();
									}
									// Copy to hidden datetime control
									var val = $.trim(date + 'T' + time);
									if (type0 == 'datetime-local') {
										ui0.val(val);
									} else {
										var dt = getUTCDatetime(val);
										ui0.val(dt[0]+'T'+dt[1]);
									}
								} else {
									ui0.val('');
								}
							}

							// Set validation parameters
							var pattern, min, step;
							switch(type0) {
								case 'number':	pattern = '^-?\\d+\\.?\\d*$'; min = 0; step = 1; break;
								case 'date':	pattern = '^\\d+-\\d+-\\d+$'; min ='1970-01-01'; step = 1; break;
								case 'time':	pattern = '^\\d+:\\d+:?\\d*\\.?\\d*$'; min="00:00"; step = 60; break;
								case 'datetime':pattern = '^\\d+-\\d+-\\d+T\\d+:\\d+:?\\d*\\.?\\d*Z$'; min = '1970-01-01T00:00'; step = 60; break;
								case 'datetime-local': pattern = '^\\d+-\\d+-\\d+T\\d+:\\d+:?\\d*\\.?\\d*$'; min = '1970-01-01T00:00'; step = 60; break;
							}

							// Perform validtions
							if (validateRe(ui0, pattern) || (validateStep(ui0, min, step))) {
								ui2.setCustomValidity(opts.invalidMessage);
								return true;
							}
							if (validateMin(ui0)) {
								ui2.setCustomValidity(opts.minMessage.replace(/#/, ui0.attr('min')));
								return true;
							}
							if (validateMax(ui0)) {
								ui2.setCustomValidity(opts.maxMessage.replace(/#/, ui0.attr('max')));
								return true;
							}
						}
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


			if (hasIeBugs) {
				// The correct default type of button is "submit".
				form.find('button').each(function() {
					var html = $(this).outerHTML();
					if (!html.match(/^[^>]+ type/)) {
						$(this).after(html.replace(/<button/i, '<button type="submit"')).remove();
					}
				});
				// IE does not send a value of button:submit
				// when you press Enter in a input:text.
				form.find('button:submit, input:submit').each(function(i) {
					if (!i && $(this).is('button')) {
						$('<input type="hidden" name="'+$(this).attr('name')+'" value="'+$(this).val()+'" class="'+opts.classDummy+'">').appendTo(form);
					}
				});
			}

			if (elmAutofocus) {
				elmAutofocus.focus().select();	// focus only does not work in IE
			}

			//
			// When submit
			//


			form.find('input:submit, input:image, input:button, button:submit').click(function() {

				// Re-scan for dinamic controls
				if (opts.dinamicHtml) {
					form.find(opts.dinamicHtml).initControl();
				}

				// Show balloons message
				if (!hasCustomValidity) {
					var i;
					for (var j in customValidity) {
						if (customValidity[j] && (i == null || i > j)) i = j;
					}
					if (i != null) {
						var ui = customValidity[i][0],
							message = customValidity[i][1];

						if (!ui.prev().hasClass(opts.classResponse)) {
							ui.before('<span class="' + opts.classResponse + '"></span>');
						}
						ui.prev().html('<p>'+message.replace(/\n/, '<br/>')+'</p>');
						ui.focus().select();	// focus only does not work in IE
						return false;
					}
				}

				// Submit when no-error

				// Clear Placeholder
				if (!hasPlaceholder) {
					for(var i in elmPlaceholder) {
						var ui = elmPlaceholder[i];
						if (ui.val() == ui.attr('placeholder')) {
							ui.val('');
						}
					}
				}

				if (hasIeBugs)
				{
					// Remove dummy of button first
					$('.' + opts.classDummy).remove();
					if ($(this).is('button')) {
						// Set a value of button:submit you clicked to input:hidden.
						$('<input type="hidden" name="'+$(this).attr('name')+'" value="'+$(this).val()+'">').appendTo(form);
						// Remove names of all buttons so that IE does not send the context.
						$('button').attr('name','');
					}
				}
			});

        });

		// Validations
		// if error, result value is true (is not zero).
		// search returns zero when first match.

		function validateRe(item, pattern, flags) {
			re = new RegExp(pattern, flags);
			return ((item.val() != '') && item.val().search(re));
		}
		function validateStep(item, min, step) {
			min = (item.attr('type').toLowerCase().indexOf('datetime')) ? attr2num(item, 'min', min) : attr2num(item, '', min);
			step = attr2num(item, 'step', step);
			var val = attr2num(item, 'val', '');
			return ((val != '') && ((val - min) % step));
		}
		function validateMin(item) {
			var val = attr2num(item, 'val', ''),
				min = attr2num(item, 'min', '');
			return ((val != '') && (min != '') && (val  < min));
		}
		function validateMax(item) {
			var val = attr2num(item, 'val', ''),
				max = attr2num(item, 'max', '');
			return ((val != '') && (max != '') && (val  > max));
		}
		function validateMaxlength(item) {
			var len = item.val().length,
				max = attr2num(item, 'maxlength', 0);
			// if error, reulst value is number of overflow
			return (len && max && (len  > max)) ? len - max : 0;
		}

		// functions of datetime

		function attr2num(item, name, def) {
			// This function results seconds of unit time if the type is data
			// or resuts days of unit time if the type is date.
			// Because the return value is compared with the step base.
			var val = (name) ? ((name == 'val') ? item.val() : item.attr(name)) : def;
			if (val == undefined || val == '') val = ''+def;
			if (val.match(/\d+-\d+-\d+[ T]\d+:\d/)) return Date.parse(utc2js(val)) / (1000);	// seconds
			if (val.match(/\d+-\d+-\d+/)) return Date.parse(utc2js(val)) / (1000 * 60 * 60 * 24);	// days
			if (val.match(/\d+:\d/)) return str2sec(val, true);	// seconds
			return Number(val);
		}
		function str2sec(str, gmt) {
			if (str.search(/\d+:\d+/)) str = '00:00';
			if (gmt) str += ' GMT'
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
			var time = dt.toString().replace(/.* (\d+:\d+:\d+).*$/, '$1');

			return new Array(date, time);
		}
		function getUTCDatetime(val) {
			// string to date for TZ
			var dt = new Date(utc2js(val)),
				date = dt.getUTCFullYear() + '-' + (dt.getUTCMonth() + 1) + '-' + dt.getUTCDate();

			date = date.replace(/\b(\d)\b/g, '0$1');
			var time = dt.toUTCString().replace(/.* (\d+:\d+:\d+).*$/, '$1Z');

			return new Array(date, time);
		}
		function utc2js(val) {
			return val.replace(/-/g, '/').replace(/T/, ' ').replace(/Z/, ' GMT').replace(/([+-])(\d+):(\d+)/, ' GMT$1$2$3');
		}
	};


})(jQuery);