(function(){/*
captionplus mouse-over image caption engine
@author  Levente Hunyadi
@version 1.5.0
@remarks Copyright (C) 2009-2014 Levente Hunyadi
@see     http://hunyadi.info.hu/projects/
*/
'use strict';var k={download:!0,overlay:!0,position:"bottom",visibility:"mouseover",horzalign:"center",vertalign:"center"};
function m(d,b){function f(a){var b=document.createElement("textarea");b.innerHTML=a;return b.value}function g(a,b){return a&&a.hasAttribute(b)?a.getAttribute(b):null}var c=function(a,b){a=a||{};for(var c in JSON.parse(JSON.stringify(b)))Object.prototype.hasOwnProperty.call(a,c)||(a[c]=b[c]);return a}(b,k);if(!d.querySelector(".captionplus")){var a=d.querySelector("img");if(a){b=d.querySelector("a");var e=g(b,"data-title")||a.alt,h;c.download&&(h=g(b,"data-download"));if(e||h){b=document.createElement("div");
b.classList.add("captionplus-align");b.classList.add("captionplus-horizontal-"+c.horzalign);b.classList.add("captionplus-vertical-"+c.vertalign);if(e){var l=document.createElement("div");l.innerHTML=f(e);b.appendChild(l)}a=a.width;b.style.maxWidth=a?a+"px":"none";a=document.createElement("div");a.classList.add(c.overlay?"captionplus-overlay":"captionplus-outside");a.classList.add("captionplus-"+c.position);a.classList.add("captionplus-"+c.visibility);a.appendChild(b);c=document.createElement("div");
c.classList.add("captionplus");for(e=0;e<d.children.length;e++)c.appendChild(d.children[e]);c.appendChild(a);h&&(a=document.createElement("a"),a.classList.add("captionplus-button"),a.classList.add("captionplus-download"),a.href=h,b.appendChild(a));d.appendChild(c)}}}}m.bind=function(d,b){if(d)for(var f=0;f<d.children.length;f++){var g=d.children[f];"li"==g.tagName.toLowerCase()&&new m(g,b)}};window.CaptionPlus=m;}).call(this);
