(function(a){if(typeof define==="function"&&define.amd){define(["jquery"],a);}else{if(typeof exports==="object"){a(require("jquery"));}else{a(window.jQuery);}}}(function(c){var a=0,d=c,b="parseJSON";if("JSON" in window&&"parse" in JSON){d=JSON;b="parse";}c.ajaxTransport("iframe",function(f){if(f.async){var e=f.initialIframeSrc||"javascript:false;",h,g,i;return{send:function(j,k){h=c('<form style="display:none;"></form>');h.attr("accept-charset",f.formAcceptCharset);i=/\?/.test(f.url)?"&":"?";if(f.type==="DELETE"){f.url=f.url+i+"_method=DELETE";f.type="POST";}else{if(f.type==="PUT"){f.url=f.url+i+"_method=PUT";f.type="POST";}else{if(f.type==="PATCH"){f.url=f.url+i+"_method=PATCH";f.type="POST";}}}a+=1;g=c('<iframe src="'+e+'" name="iframe-transport-'+a+'"></iframe>').bind("load",function(){var l,m=c.isArray(f.paramName)?f.paramName:[f.paramName];g.unbind("load").bind("load",function(){var n;try{n=g.contents();if(!n.length||!n[0].firstChild){throw new Error();}}catch(o){n=undefined;}k(200,"success",{iframe:n});c('<iframe src="'+e+'"></iframe>').appendTo(h);window.setTimeout(function(){h.remove();},0);});h.prop("target",g.prop("name")).prop("action",f.url).prop("method",f.type);if(f.formData){c.each(f.formData,function(n,o){c('<input type="hidden"/>').prop("name",o.name).val(o.value).appendTo(h);});}if(f.fileInput&&f.fileInput.length&&f.type==="POST"){l=f.fileInput.clone();f.fileInput.after(function(n){return l[n];});if(f.paramName){f.fileInput.each(function(n){c(this).prop("name",m[n]||f.paramName);});}h.append(f.fileInput).prop("enctype","multipart/form-data").prop("encoding","multipart/form-data");f.fileInput.removeAttr("form");}h.submit();if(l&&l.length){f.fileInput.each(function(o,n){var p=c(l[o]);c(n).prop("name",p.prop("name")).attr("form",p.attr("form"));p.replaceWith(n);});}});h.append(g).appendTo(document.body);},abort:function(){if(g){g.unbind("load").prop("src",e);}if(h){h.remove();}}};}});c.ajaxSetup({converters:{"iframe text":function(e){return e&&c(e[0].body).text();},"iframe json":function(e){return e&&d[b](c(e[0].body).text());},"iframe html":function(e){return e&&c(e[0].body).html();},"iframe xml":function(e){var f=e&&e[0];return f&&c.isXMLDoc(f)?f:c.parseXML((f.XMLDocument&&f.XMLDocument.xml)||c(f.body).html());},"iframe script":function(e){return e&&c.globalEval(c(e[0].body).text());}}});}));