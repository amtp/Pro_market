/**
* @file
* @brief    sigplus Image Gallery Plus index image population for search results script
* @author   Levente Hunyadi
* @version  1.5.0
* @remarks  Copyright (C) 2009-2017 Levente Hunyadi
* @remarks  Licensed under GNU/GPLv3, see http://www.gnu.org/licenses/gpl-3.0.html
* @see      http://hunyadi.info.hu/projects/sigplus
*/

/*{"compilation_level":"ADVANCED_OPTIMIZATIONS"}*/
'use strict';

function __sigplusSearch(url, preview_url, width, height) {
	// Internet Explorer supports Element.msMatchesSelector() but not Element.matches()
	let matches = Element.prototype.matches || Element.prototype.msMatchesSelector;

	/**
	* Finds an ancestor element (or returns self) that matches a CSS selector.
	* @param {Element} elem The element whose ancestor element to seek.
	* @param {string} selector A CSS selector to match against.
	* @param {Element} The element found or null.
	*/
	function closest(elem, selector) {
		let ancestor = null;
		while (elem) {
			if (matches.call(elem, selector)) {
				ancestor = elem;
				break;
			}
			elem = elem.parentElement;
		}
		return ancestor;
	}

	/**
	* Finds a next sibling element that matches a CSS selector.
	* @param {Element} elem The element whose sibling element to seek.
	* @param {string} selector A CSS selector to match against.
	* @param {Element} The element found or null.
	*/
	function following(elem, selector) {
		let follower = null;
		if (elem) {
			elem = elem.nextElementSibling;
			while (elem) {
				if (matches.call(elem, selector)) {
					follower = elem;
					break;
				}
				elem = elem.nextElementSibling;
			}
		}
		return follower;
	}

	let resultlink = document.querySelector('.result-title a[href="' + url + '"]');
	if (resultlink) {
		let resulttext = following(closest(resultlink, '.result-title'), '.result-text');
		if (resulttext) {
			let image = /** @type {!HTMLImageElement} */ (document.createElement('img'));
			image.src = preview_url;
			image.width = width;
			image.height = height;
			resulttext.insertBefore(image, resulttext.firstChild);
		}
	}
}
window['__sigplusSearch'] = __sigplusSearch;
