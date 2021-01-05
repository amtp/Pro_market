(function(){/*
sigplus client-side initialization script
@author  Levente Hunyadi
@version 1.5.0
@remarks Copyright (C) 2011-2017 Levente Hunyadi
@remarks Licensed under GNU/GPLv3, see http://www.gnu.org/licenses/gpl-3.0.html
@see     http://hunyadi.info.hu/projects/sigplus
*/
'use strict';var k=window.sigplus||{};window.sigplus=k;k.lightbox=k.lightbox||{};
window.__sigplusInitialize=function(d){var e=document.querySelector("#"+d+".sigplus-gallery");e&&([].forEach.call(e.querySelectorAll("noscript"),function(a){var b=document.createElement("div");b.innerHTML=a.innerText;a.parentNode.replaceChild(b.firstChild===b.lastChild?b.firstChild:b,a)}),[].forEach.call(e.querySelectorAll("a"),function(a){var b=a.querySelector("img");b&&a.setAttribute("title",b.getAttribute("alt"));if(b=a.parentNode){var c=b.querySelector(".sigplus-summary");if(c){a.setAttribute("title",
c.innerText);var f=c.innerHTML;f&&a.setAttribute("data-summary",f);if(f=c.querySelector("a"))a.setAttribute("data-href",f.href),a.setAttribute("data-target",f.target);c.parentNode.removeChild(c)}if(c=b.querySelector(".sigplus-download"))a.setAttribute("data-download",c.href),c.parentNode.removeChild(c);if(b=b.querySelector(".sigplus-title"))(c=b.innerHTML)&&a.setAttribute("data-title",c),b.parentNode.removeChild(b)}}));[].forEach.call(document.querySelectorAll("#"+d+".sigplus-lightbox-none a.sigplus-image"),
function(a){var b=a.getAttribute("data-href");b?(a.href=b,a.target=a.getAttribute("data-target"),a.removeAttribute("data-href"),a.removeAttribute("data-target")):a.addEventListener("click",function(a){a.preventDefault()})})};
window.__sigplusCaption=function(d,e,a){function b(a){if(0==a)return"0 B";var b=Math.log(a)/Math.log(1E3)|0;return(a/Math.pow(1E3,b)).toPrecision(3)+" "+["B","KB","MB","GB","TB"][b]}function c(a,b){return(a=b.exec(a))?a[1]:""}var f=document.querySelectorAll("#"+d+" a.sigplus-image");e=e||"{$text}";a=a||"{$text}";[].forEach.call(f,function(d,l){function m(a,d){var e=decodeURIComponent(g.getAttribute("data-image-file-name")||g.pathname||""),h={text:d||"",name:c(e,/([^\/]+?)(\.[^.\/]+)?$/),filename:c(e,
/([^\/]+)$/),filesize:b(parseInt(g.getAttribute("data-image-file-size"),10)),current:l+1,total:f.length};return a.replace(/\\?\{\$([^{}]+)\}/g,function(a,b){return h[b]})}function h(a,b,c){a.setAttribute(b,m(c,a.getAttribute(b)))}var g=d;h(g,"data-summary",a);h(g,"title",a);(d=g.querySelector("img"))&&h(d,"alt",e)})};}).call(this);
