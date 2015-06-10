/**
 *	jQuery.h5form - HTML5 Forms Plugin
 *	Version 2.13.1 / Portuguese Brazil
 *
 *	Author: by Yoshiyuki Mikomde http://www.rapidexp.com/h5form
 *      Translator: Job Diogenes Ribeiro Borges - https://github.com/jobdiogenes
 *
 *	Copyright (c) 2012 - 2013 Yoshiyuki Mikome (http://www.rapidexp.com)
 *	Dual licensed under the MIT (MIT-LICENSE.txt)
 *	and GPL (GPL-LICENSE.txt) licenses.
 *
 *	Built for jQuery library
 *	http://jquery.com
 *
 */
(function($) {

	$.fn.h5form = function(options) {
		// Check UA
		var ua = window.navigator.userAgent.toLowerCase(),
			msie = document.documentMode || parseInt(ua.replace(/.*msie (\d+).*/, '$1')),
			firefox = parseInt(ua.replace(/.*firefox\/(\d+).*/, '$1')),
			chrome = parseInt(ua.replace(/.*chrome\/(\d+).*/, '$1')),
			// "opara/9.80" or "opera 10.10"
			opera = parseInt(ua.replace(/.*opera[\/ ](\d+).*/, '$1')),
			// "Version/5.0 Safari/533.16"
			safari = parseInt(ua.replace(/.*version\/(\d+).*safari.*/, '$1')),
			android = parseInt(ua.replace(/.*android (\d+).*/, '$1'));

		var outerHTML = function(ui) {
			// Firefox 10 or earlier does not have outerHTML
			var obj = ui.get(0);
			return obj.outerHTML || new XMLSerializer().serializeToString(obj);
		};

		//default configuration properties
		var defaults = {
			exprResponse: '.h5form-response, .h5form-reversed',
			exprBehind: '.h5fom-behind',
			styleErr: { backgroundColor: 'mistyrose' },
			classPlaceholder: 'h5form-placeholder',
			msgEmpty: 'Campo obrigatório.',
			msgUnselect: 'Você preciso slecionar um item.',
			msgUncheck: 'Você precisa confirmar.',
			msgPattern: 'Não esta de acordo com o padrão requerido.',
			msgEmail: 'E-mail em formato inválido.',
			msgUrl: 'URL é inválida.',
			msgNumber: 'Número incorreto.',
			msgDatetime: 'Data e horas incorretas.',
			msgDate: 'Data incorreta.',
			msgTime: 'Horas incorreto',
			msgStep: 'Limite incorreto.',
			msgMin: 'Entre com um valor maior ou igual a #.',
			msgMax: 'Entre com um valor menor ou iqual a #.',
			msgMaxlen: 'O máximo de caracteres é de #.',
			classRange: 'h5form-range',
			classSpinTime: 'h5form-spinTime',
			classDatetime: 'h5form-datetime',
			datepicker: {
				onClose: function() { $(this).blur(); }
			},
			maskDate: '9999-99-99',
			maskMonth: '9999-99',
			maskTime: '99:99',
			msgSpin: 'Pressione "Shift" para mudar a hora ou pressione "Ctrl" para passos curtos.',
			options: {},
			dynamicHtml: '.h5form-dynamic'
		};
		var opts = $.extend({}, defaults, options);

		// Test browser
		var test1 = $('<input>').hide().appendTo($('body')).get(0),
			test2 = $('textarea:first').get(0) || new Object(),
			reqCustomValidity = !('setCustomValidity' in test1) || android,
			reqAutofocus = !('autofocus' in test1),
			reqRequired = !('required' in test1) || android,
			reqPattern = !('pattern' in test1) || android,
			reqEmail = reqUrl = reqCustomValidity || reqPattern || android, // maybe
			reqPlaceholder = !('placeholder' in test1),
			// android must be reqSpin = false and reqNumber = true
			// reqNumber provieds validation of min and max
			reqSpin = !('step' in test1) || !('min' in test1) || !!firefox || !!msie,
			reqNumber = (!!android || reqSpin && !(msie > 9)),
			reqRange = reqNumber && !(firefox > 22),
			reqDateTimeLocal = !(opera > 8 || chrome > 24),
			reqDateTime = !(opera > 8),
			reqDate = reqDateTimeLocal && !(chrome > 21),
			reqTime = reqDateTimeLocal && !(chrome > 22),
			reqMonth = reqDateTimeLocal,	// I don't know the detailed version of Chrome
			reqMaxlength = !('maxLength' in test2),
			reqFormAttr = !('form' in test1) || !('formAction' in test1) || android,
			reqDatalist = !('autocomplete' in test1) || !('list' in test1),
			reqBugButton = (msie && msie < 8),
			reqBugEnter = (msie && msie < 9) || android;

		for (name in opts.options) {
			eval(name + '=' + opts.options[name] + ';');
		}

		$('input:last').remove();

		var validatable = ':input:enabled:not(:button, :submit, [type="hidden"])';
		// clear balloons
		if ('on' in $(document)) {
			// .live() was removed by jQuery 1.9
			$(document).on('click', validatable, function() {
				$(this).siblings(opts.exprResponse).remove();
				$(opts.exprBehind).removeAttr('disabled');
			})
			.on('click', opts.exprResponse, function() {
				$(this).remove();
			});
		} else {
			$(validatable).live('click', function() {
				$(this).siblings(opts.exprResponse).remove();
				$(opts.exprBehind).removeAttr('disabled');
			});
			$(opts.exprResponse).live('click', function() {
				$(this).remove();
			});
		}
		// focus server side error
		if ($(opts.exprResponse).length) {
			var ui = $(opts.exprResponse).eq(0).next(':input');
			if (ui.is(':hidden')) {
				ui = ui.parent().find(':input:not(:hidden)');
			}
			ui.eq(0).focus();
		}

		var getAttr = function(ui, name) {
			var attr = ui.attr(name);
			return (attr == undefined) ? '' : attr;
		};

		/**
		 * Change Type
		 * @param {string} type -- type.
		 * @return {object} -- this.
		 */
		var typeTo = function(ui, type, orgType) {
			var	at = ui.get(0).attributes,
				ui2 = $('<input type="' + type + '">'),
				flg = ['required', /*'disabled',*/ 'readonly', 'checked'];

			for (i = at.length - 1; i >= 0; i--) {
				name = at[i].nodeName;
				value = at[i].nodeValue;
				if (!value && $.inArray(name, flg) >= 0) {
					value = name;
				}
				if (name && value) {
					if (name != 'type') {
						ui2.attr(name, value);
					}
				}
			}
			ui2.addClass('h5form-' + orgType);

			return ui2.replaceAll(ui);
		};

		/**
		 * Set a custom validity to the elements
		 * @param {string} message -- message.
		 * @return {object} -- this.
		 */
		var $firstTime = true,
			$novalidate = false,
			setCustomValidity = function(ui, message) {
			if ($novalidate) message = '';	// null is invalid in opera
			if (ui.is(validatable)) {
				// Add a title to the message
				if (message && (title = getAttr(ui, 'title'))) {
					message = $.trim(message + '\n' + title);
				}
				// Set a custon validity
				if (reqCustomValidity) {
					if (message) {
						ui.data('customValidity', message.replace(/\n/, '<br />'));
					} else {
						ui.removeData('customValidity');
					}

					if (!$firstTime && opts.styleErr) {
						if (message) {
							ui.css(opts.styleErr);
						} else {
							for (key in opts.styleErr) {
								ui.css(key, '');
							}
						}
					}
				} else {
					ui.get(0).setCustomValidity(message);
				}
			}
			return ui;
		};
		$.fn.h5form.setCustomValidity = setCustomValidity;

		/**
		 * Check validity of the element
		 * @param {object} ui		-- element.
		 * @return {bool}			-- valid.
		 */
		$.fn.h5form.checkValidity = function(ui) {
			var result = true;
			ui.each(function() {
				if (reqCustomValidity) {
					if ($(this).data('customValidity')) {
						return (result = false);
					}
				} else {
					if (!$(this).get(0).checkValidity()) {
						return (result = false);
					}
				}
			});
			return result;
		};
		var showBalloon = function(ui, message) {
			if (!ui.prev().is(opts.exprResponse)) {
				var m = opts.exprResponse.match(/^\.([^, ]+),? *\.?([^, ]*)/),
				name = ($(window).width() - ui.offset().left < 300 && !!m[2]) ?
					m[2] : m[1];
				ui.before('<span class="' + name + '"></span>');
				$(opts.exprBehind).attr('disabled', 'disabled');
			}
			ui.prev().html('<p>' +
						   message.replace(/\n/, '<br/>') + '</p>');
 			ui.focus().select();	// focus only does not work in IE
		};
		$.fn.h5form.showBalloon = showBalloon;

		// for each form
		return $(this).each(function() {

			//Private properties
			var form = $(this),
				elmAutofocus,
				validatableElements = form.find(validatable);

			// form.attr('novalidate') result undefined,
			// when from has simply "novalidate" rather than "novalidate='novalidate'"
			$novalidate = !!outerHTML(form).match(/^[^>]+ novalidate/);

			var evNumber = function(ev) {
				var allow = [8, 9, 35, 36, 37, 39, 46, 58, 186, 190];
				var cc = ev.charCode || ev.keyCode;
				return (($.inArray(cc, allow) >= 0) || (cc >= 48 && cc <= 57));
			}
			var spinShift = false,
				spinCtrl = false;

			var spinAcc = (function(ev, flag) {
				var cc = ev.charCode || ev.keyCode;
				if (cc == 17) spinCtrl = flag;
				if (cc == 16) spinShift = flag;
			});

			$('body')
				.unbind('keydown', spinAcc)
				.unbind('keyup', spinAcc)
				.keydown(function(ev) { spinAcc(ev, true); })
				.keyup(function(ev) { spinAcc(ev, false); });

			var spinTime = function(ui, isDown) {
				var min = attr2num(ui, 'min', 0),
					max = attr2num(ui, 'max', 86400),
					step = step0 = attr2num(ui, 'step', 60),
					base = 0,
					val = str2sec(ui.val(), true);

				if (spinShift) step = 3600;
				else if (spinCtrl) step = step0;
				else step = (step0 < 600) ? 600 : step0;

				val = val - ((val - base) % step) + step * ((isDown) ? -1 : 1);

				if ((max || max == '0') && val > max) val = max;
				if ((min || min == '0') && val < min) val = min;

				ui.val(sec2str(val, step % 60, true));
				return ui;
			};
			/**
			 * For each control function
			 * @return {object} -- this.
			 */
			var initControl = function(elm, firstTime) {
				$firstTime = firstTime;

				return elm.each(function() {

					var ui = $(this),
						type = getAttr(ui, 'type').toLowerCase();

					// Is autofoucs
					if (reqAutofocus && !elmAutofocus && getAttr(ui, 'autofocus')) {
						elmAutofocus = ui;
					}
					// Focus and blur attach for Placeholder
					var placeholder = getAttr(ui, 'placeholder');
					if (reqPlaceholder && placeholder) {
						$(this).prev('.'+opts.classPlaceholder).remove();
						var phld = $('<span />').insertBefore(ui)
							.addClass(opts.classPlaceholder)
							.text(placeholder).click(function() { ui.focus(); });
						var evPlaceholder = (function() {
							if (ui.val().length > 0) phld.hide(); else phld.show();
						});
						ui.bind('keyup keydown cut past', evPlaceholder).keyup()
						  .removeAttr('placeholder');
					}

					if ('spinner' in ui) {
						if (reqSpin && type == "number")
						{
							ui = typeTo(ui, 'text', type).spinner()
								.unbind('keydown', evNumber).keydown(evNumber);
						}
						if (reqTime && type == 'time')
						{
							ui = typeTo(ui, 'text', type).spinner({spin: function() {return false;} });

							if (('mask' in ui)) {
								ui.unbind('mask').mask(opts.maskTime);
							}

							wi = ui.spinner('widget');
							wi.find('.ui-icon')
							.attr('title', opts.msgSpin)
							.click(function() {
								spinTime(ui, $(this).parents('.ui-spinner').find('.ui-icon').index($(this))).change().blur();
							});
						}
					}
					// Datepicker
					if ((reqDate && type == 'date') || (reqMonth && type == 'month')) {
						var mask;
						if ('datepicker' in ui) {
							var option = opts.datepicker;
							switch(type) {
							case 'date':
								option.dateFormat = 'yy-mm-dd';
								option.minDate = getAttr(ui, 'min');
								option.maxDate = getAttr(ui, 'max');
								mask = opts.maskDate;
								break;
							case 'month':
								option.dateFormat = 'yy-mm';
								mask = opts.maskMonth;
								// Datepicker has a bug in minDate and maxDate of yy-mm
								option.minDate = '';
								option.maxDate = '';
								break;
							}
							ui = typeTo(ui, 'text', type).datepicker(option);
						}
						if ('mask' in ui) {
							ui.unbind('mask').mask(mask);
						}
					}
					// Slider
					if (reqRange && (type == 'range') && ('slider' in ui)) {
						var min = attr2num(ui, 'min', 0),
							max = attr2num(ui, 'max', 100),
							step = attr2num(ui, 'step', 1),
							val = attr2num(ui, 'val', (min + max) / 2 - ((min + max) / 2 % step));

						ui.hide().css({width: 0, margin:0}).after('<span class="' + opts.classRange +
										'"><div></div></span>').val(val);
						ui.next().children().slider({
							min: min, max: max, step: step, value: val,
							change: function(ev, sl) {
								ui.val($(this).slider('value'));
							}
						});
					}

					// Maxlength
					if (reqMaxlength && ui.is('textarea') &&
						(maxlength = getAttr(ui, 'maxlength'))) {
						// Keypress event attach
						var evKeypress = (function(ev) {
							var cc = ev.charCode || ev.keyCode;
							return (($.inArray(cc, [8, 9, 37, 39, 46]) >= 0) ||
									(this.value.length < maxlength));
						});
						ui.unbind('keypress', evKeypress).keypress(evKeypress);
					}

					// Datetime
					if ((isLocal = (reqDateTimeLocal && type == 'datetime-local')) || (reqDateTime && type == 'datetime')) {
						ui = typeTo(ui, 'text', type);
						var val = getLocalDatetime(ui.val(), isLocal),
							min = getLocalDatetime(getAttr(ui, 'min'), isLocal),
							max = getLocalDatetime(getAttr(ui, 'max'), isLocal),
							tz = (type == 'datetime') ?
								'<span class="h5form-timezone">' + getTZ() + '</span>' : '';

						ui.hide().after(
							'<span class="' + opts.classDatetime + '">' +

							'<input type="date" value="' + val[0] + '"' +
							' min="' + min[0] + '" max="' + max[0] + '"' +
							' size="' + getAttr(ui, 'size') + '"' +
							' class="' + getAttr(ui, 'class') + '"' +
							' title="' + getAttr(ui, 'title') + '">' +

							'<input type="time" value="' + val[1] + '"' +
							' step="' + attr2num(ui, 'step', 60) + '"' +
							' size="' + getAttr(ui, 'size') + '"' +
							' class="' + getAttr(ui, 'class') + '"' +
							' title="' + getAttr(ui, 'title') + '">' +
							tz +
							'</span>');
						if (getAttr(ui, 'required')) {
							ui.removeAttr('required');
							initControl(ui.next().children().attr('required', 'required'));
						} else {
							initControl(ui.next().children());
						}
					}
					if ((reqDatalist) &&
						(list = getAttr(ui, 'list')) &&
						(list = $('#' + list)) &&
						('autocomplete' in ui))
					{
						var arr = new Array();
						if (list.find('option').length) {
							list.find('option').each(function() {
								arr.push($(this).val());
							});
						} else if (str = list.attr('data-option')) {
							arr = $.parseJSON(str);
						}
						// Avoid conflicts with the browser
						ui.removeAttr('list');

						ui.autocomplete({
							source: arr,
							// under imput method
							search: function(ev, ui) {
								if (ev.keyCode == 229) return false;
								return true;
							}

						})
						.keyup(function(ev) {
							// output imput method
							if (ev.keyCode == 13) $(this).autocomplete('search');
						});
					}

					/**
					 * Change event
					 * @return {bool} -- isNecessary.
					 */
					var evChange = (function() {

						var isNecessary = false,
							name = ui.attr('name'),
							isChecked = $('[name="' + name + '"]:checked').length,
							isEmpty = ((ui.val() == '') ||
									   (ui.is(':checkbox, :radio') && !isChecked));

						// clear validity first
						// NOTE: null is invalid in opera
						setCustomValidity($('[name="' + name + '"]'), '');
						if (reqBugEnter && !ui.is('select, textarea, button')) {
							// Keypress event attach
							var evKeypress2 = (function(ev) {
								var cc = ev.charCode || ev.keyCode;
								if (cc == 13) {
									if (android &&
										(idx = validatableElements.index(ui) + 1) < validatableElements.length) {
										validatableElements.eq(idx).focus();
									} else {
										form.find('[type="submit"]').eq(0).focus().click();
									}
									return false;
								}
								return true;
							});
							ui.unbind('keypress', evKeypress2).keypress(evKeypress2);
							isNecessary = true;
						}
						// Required
						if (reqRequired && getAttr(ui, 'required')) {
							isNecessary = true;
							if (isEmpty) {
								var msg = opts.msgEmpty;
								if (ui.is('select, :radio')) msg = opts.msgUnselect;
								if (ui.is(':checkbox')) msg = opts.msgUncheck;
								setCustomValidity(ui, msg);
								return true;
							}
						}
						// Pattern
						if (reqPattern && (pattern = getAttr(ui, 'pattern'))) {
							isNecessary = true;
							if (!isEmpty &&
								validateRe(ui, '^(' + pattern.replace(/^\^?(.*)\$?$/, '$1') + ')$')) {
								setCustomValidity(ui, opts.msgPattern);
								return true;
							}
						}
						// Email
						if (reqEmail && type == 'email') {
							isNecessary = true;
							if (!isEmpty && validateRe(ui,
							   '[\\w-\\.]{3,}@([\\w-]{2,}\\.)*([\\w-]{2,}\\.)[\\w-]{2,4}', 'i')) {
								setCustomValidity(ui, opts.msgEmail);
								return true;
							}
						}

						// URL
						if (reqUrl && type == 'url') {
							isNecessary = true;
							if (!isEmpty && validateRe(ui,
							   '[\\w-\\.]{3,}:\\/\\/([\\w-]{2,}\\.)*([\\w-]{2,}\\.)[\\w-]{2,4}',
							   'i')) {
								setCustomValidity(ui, opts.msgUrl);
								return true;
							}
						}

						// Maxlength
						if (reqMaxlength && ui.is('textarea') && getAttr(ui, 'maxlength')) {
							isNecessary = true;
							if (over = validateMaxlength(ui)) {
								setCustomValidity(ui, opts.msgMaxlen.replace(/#/, over));
								return true;
							}
						}

						// Number, Date, Time
						if (
							(reqNumber && type == 'number') ||
							(reqDate && type == 'date') || (reqTime && type == 'time') || (reqMonth && type == 'month') ||
							false) {
							isNecessary = true;

							// Set values to local
							var ui0 = ui, type0 = type, $ui = ui;
							// Is this control within datetime?
							var uiParent = ui.parents('.' + opts.classDatetime);
							if (uiParent.length) {
								ui0 = uiParent.prev();	// hidden datetime control
								// datetime or datetime-local
								type0 = getAttr(ui0, 'class').replace(/.*h5form-([^ ]+).*/, '$1').toLowerCase();
								var isLocal = (type0 == 'datetime-local');

								$ui = uiParent.find('input');
								// ui2 is the other of data and time
								var i = $ui.index(ui), ui2 = $ui.eq(1 - i);

								if (ui.val() == '') {
									ui2.val('');
									ui0.val('');
								} else {
									if (ui2.val() == '') {
										var min = getLocalDatetime(getAttr(ui0, 'min'), isLocal, true);
										ui2.val(min[1 - i]).change().blur();
									}
									// i==0 ui: date, ui2: time / i==1: ui: time, ui2: date
									ui0.val($.trim((i) ?
										(ui2.val() + 'T' + ui.val()) : (ui.val() + 'T' + ui2.val())));
								}
							}
							setCustomValidity($ui, '');

							// Set validation parameters
							var pattern = '^-?\\d+\\.?\\d*$',
								min = 0,
								step = 1;
							switch (type0) {
							case 'date':
								if (validateDate(ui0.val())) {
									setCustomValidity($ui, opts.msgDate);
									return true;
								}
								min = '1970-01-01';
								step = 1;
								break;
							case 'time':
								if (validateTime(ui0.val())) {
									setCustomValidity($ui, opts.msgTime);
									return true;
								}
								min = '00:00';
								step = 60;
								break;
							case 'datetime':
							case 'datetime-local':
								if (validateDatetime(ui0.val())) {
									setCustomValidity($ui, opts.msgDatetime);
									return true;
								}
								min = '1970-01-01T00:00';
								step = 60;
								break;
							case 'month':
								pattern = '^\\d{4}-(0?\\d|1[012])$';
								min = '1970-01-01';
								// FALL THROUGH
							default:
								if (validateRe(ui0, pattern)) {
									setCustomValidity($ui, opts.msgNumber);
									return true;
								}
								break;
							}
							// Perform validtions

							if (validateStep(ui0, min, step)) {
								setCustomValidity($ui, opts.msgStep);
								return true;
							}
							if (validateMin(ui0)) {
								setCustomValidity($ui, opts.msgMin.replace(/#/, getAttr(ui0, 'min')));
								return true;
							}
							if (validateMax(ui0)) {
								setCustomValidity($ui, opts.msgMax.replace(/#/, getAttr(ui0, 'max')));
								return true;
							}

							if (type0 == 'datetime' && ui0.val()) {
								var dt = getUTCDatetime(ui0.val());
								ui0.val(dt[0] + 'T' + dt[1]);
							}
						}
						return isNecessary;
					});

					// Test the change event, to run concurrently
					if (evChange()) {
						// Attach the change event if necessary
						ui.unbind('change', evChange).change(evChange);
					} else {
						var elm = ui.get(0);
						var initValidity = function() {
 							setCustomValidity(ui, '');
						};
						var setInvalid = function() {
							var msgError = '';
							if (elm.validity.valueMissing) {
								if (ui.is('select')) msgError = opts.msgUnselect;
								else if (ui.is(':checkbox')) msgError = opts.msgUncheck;
								else msgError = opts.msgEmpty;
							}
							else if (elm.validity.patternMismatch) {
								msgError = opts.msgPattern;
							}
							else if (elm.validity.tooLong) {
								msgError = opts.msgMaxlen.replace(/#/. validateMaxlength(ui));
							}
							else if (elm.validity.rangeOverflow) {
								msgError = opts.msgMax.replace(/#/, gertAttr(ui, 'max'));
							}
							else if (elm.validity.rangeUnderflow) {
								msgError = opts.msgMin.replace(/#/, getAttr(ui, 'min'));
							}
							else if (elm.validity.typeMismatch) {
								switch(type) {
									case 'email': msgError = opts.msgEmail; break;
									case 'url': msgError = opts.msgUrl; break;
									case 'date': msgError = opts.msgDate; break;
									case 'time': msgError = opts.msgTime; break;
									case 'datetime': msgError = opts.msgDatetime; break;
									case 'datetime-local': msgError = opts.msgDatetime; break;
								}
							}
							else if (elm.validity.stepMismatch) {
								msgError = opts.msgStep;
							}
							if (msgError) {
								setCustomValidity(ui, msgError);
							}
						};

						ui.unbind('change', initValidity).change(initValidity);
						if (elm.removeEventListener && elm.addEventListener) {
							elm.removeEventListener('invalid', setInvalid);
							elm.addEventListener('invalid', setInvalid, false);
						} else {
							elm.detachEvent('invalid', setInvalid);
							elm.attachEvent('invalid', setInvalid);
						}
					}
				});
			};
			initControl(validatableElements, true);

			if (elmAutofocus) {
				elmAutofocus.focus().select();	// focus only does not work in IE
			}

			//
			// When submit
			//

			form.find('input:submit, input:image, button:submit')
				.click(function(ev) {

				if (ev.result == false) return false;	// Canceled in the previous handler

				var ui = $(this),
					validatableElements = form.find(validatable);	// Rescan becase for typeTo
				if (reqFormAttr) {
					if (attr = getAttr(ui, 'formaction')) {
						form.attr('action', attr);
					}
					if (attr = getAttr(ui, 'formeenctype')) {
						form.attr('enctype', attr);
					}
					if (attr = getAttr(ui, 'formmethod')) {
						form.attr('method', attr);
					}
					if (attr = getAttr(ui, 'formtarget')) {
						form.attr('target', attr);
					}
					if (null != ui.attr('formnovalidate')) {
						form.attr('novalidate', 'novalidate');
						validatableElements.each(function() {
							setCustomValidity($(this), '');
						});
					}
				}
				// Re-scan for dinamic controls
				initControl(form.find(opts.dynamicHtml));

				// Show balloons message
				if (reqCustomValidity) {
					var result = true;
					validatableElements.each(function() {
						if (message = $(this).data('customValidity')) {
							err = $(this);
							if (opts.styleErr) err.css(opts.styleErr);
							if (result) {
								showBalloon(err, message);
								result = false;
							}
						}
					});
					if (!result) return false;
				}
				// Submit if no error

				if (reqBugButton)
				{
					// Set a value of button:submit you clicked to input:hidden.
					$('<input type="hidden" name="' + getAttr(ui, 'name') +
					  '" value="' + ui.val() + '">').appendTo(form);

					form.find('button, input:submit').attr('name', '');

					if (ui.is('button')) {
						form.find('input:submit').remove();
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
		function validateTime(val) {
			var sec = val.match(/\d+:\d+:\d+/);
			return (val && sec2str(str2sec(val,true), sec, true) != val);
		}
		function validateDate(val) {
			var arr;
			return (val && (arr = getUTCDatetime(val + ' 00:00Z')) && arr[0] != val);
		}
		function validateDatetime(val) {
			if (!val) return false;
			var arr = val.split(/[TZ ]/);	// remove Z of end
			return (validateDate(arr[0]) || validateTime(arr[1]));
		}

		function validateMaxlength(item) {
			var len = item.val().length,
				max = attr2num(item, 'maxlength', 0);
			// if error, reulst value is number of overflow
			return (len && max && (len > max)) ? len - max : 0;
		}
		function validateStep(item, min, step) {
			min = (getAttr(item, 'class').toLowerCase().indexOf('datetime')) ?
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
			var val = def;
			if (name) { val = (name == 'val') ? item.val() : getAttr(item, name); }

			if (val == undefined || val == '') val = '' + def;
			// Result seconds on unix time if the type is time
			// or resuts days on unix time if the type is date
			// because the return value is compared with the step base.
			if (val.match(/\d+-\d+-\d+[ T]\d+:\d/))
				return Date.parse(utc2js(val)) / (1000);	// seconds
			if (val.match(/\d+-\d+-\d+/))
				return Date.parse(utc2js(val)) / (1000 * 60 * 60 * 24);	// days
			if (val.match(/\d+:\d/)) return str2sec(val, true);	// seconds
			if (val.length) val = Number(val);
			return val;
		}
		function str2sec(str, gmt) {
			if (str.search(/\d+:\d+/)) str = '00:00';
			if (gmt) str += ' GMT';
			return Date.parse('1970/1/1 ' + str) / 1000;
		}
		function sec2str(time, sec, gmt) {
			var date = new Date(time * 1000);
			ret = (gmt) ? date.toUTCString() : date.toString();
			return ret.replace((sec) ? /.* (\d+:\d+:\d+).*$/ : /.* (\d+:\d+).*$/, '$1');
		}
		function getLocalDatetime(val, isLocal, NullIsToday) {
			if (!val && !NullIsToday) return new Array('', '');
			if (isLocal) return val.replace(/(:\d+):00$/, '$1').split(/[T ]/);

			// string to date for TZ
			var dt = (!val) ? new Date() : new Date(utc2js(val)),
				date = dt.getFullYear() + '-' + (dt.getMonth() + 1) + '-' + dt.getDate();

			date = date.replace(/\b(\d)\b/g, '0$1');
			var time = (val) ?
				dt.toString().replace(/.* (\d+:\d+:\d+).*$/, '$1')
					.replace(/(\d+:\d+):00/, '$1') : '12:00';

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
			return val.replace(/-/g, '/')					// 2013-09-21 ... --> 2013/09/21 ...
				.replace(/T/, ' ').replace(/Z/, ' GMT')		// 2013/09/21T07:30:00Z --> 2013/09/21 07:30:00 GMT
				.replace(/([+-])(\d+):(\d+)/, ' GMT$1$2$3')	// 2013/09/21 07:30:00+09:00 --> 2013/09/21 07:30:00 GMT+0900
				.replace(/^(\d+\/\d+\/\d+)$/, '$1GMT');		// a plane date must be GMT, because 1970-01-01 is 0 as unix time.
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
	};

})(jQuery);
