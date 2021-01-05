/* Copyright (C) YOOtheme GmbH, YOOtheme Proprietary Use License (http://www.yootheme.com/license) */

/**
 * @license Lightbox Plugin is based on Fancybox (http://fancybox.net, Janis Skarnelis, MIT License)
 */
(function($){var plugin,tmp,loading,overlay,wrap,outer,content,close,title,nav_left,nav_right,body_margin,selectedIndex=0,selectedOpts={},selectedArray=[],currentIndex=0,currentOpts={},currentArray=[],ajaxLoader=null,imgPreloader=new Image,loadingTimer,loadingFrame=1,imgRegExp=/\.(jpg|gif|png|bmp|jpeg)(.*)?$/i,swfRegExp=/[^\.]\.(swf)\s*$/i,youtubeRegExp=/(\/\/.*?youtube\.[a-z]+)\/watch\?v=([^&]+)&?(.*)/,youtubeRegExp2=/youtu\.be\/(.*)/,vimeoRegExp=/(\/\/.*?)vimeo\.[a-z]+\/([0-9]+).*?/,videoRegExp=/\.(mp4|ogv|webm|flv)(.*)?$/i,titleHeight=0,titleStr="",start_pos,final_pos,busy=false,fx=$.extend($("<div/>")[0],{prop:0});_abort=function(){loading.hide();imgPreloader.onerror=imgPreloader.onload=null;if(ajaxLoader){ajaxLoader.abort()}tmp.empty()},_error=function(){if(false===selectedOpts.onError(selectedArray,selectedIndex,selectedOpts)){loading.hide();busy=false;return}selectedOpts.titleShow=false;selectedOpts.width="auto";selectedOpts.height="auto";tmp.html('<p id="lightbox-error">The requested content cannot be loaded.<br />Please try again later.</p>');_process_inline()},_start=function(){var obj=selectedArray[selectedIndex],href,type,title,str,emb,ret;_abort();selectedOpts=$.extend({},plugin.defaults,typeof $(obj).data(plugin.name)=="undefined"?selectedOpts:$(obj).data(plugin.name));if($(obj).attr("data-lightbox")){$.each($(obj).attr("data-lightbox").split(";"),function(i,option){var opt=option.match(/\s*([A-Z_]*?)\s*:\s*(.+)\s*/i);if(opt){selectedOpts[opt[1]]=opt[2];if(selectedOpts[opt[1]]==="true"||selectedOpts[opt[1]]==="false"){selectedOpts[opt[1]]=eval(opt[2])}}})}ret=(typeof selectedOpts.onStart=="string"?window[selectedOpts.onStart]:selectedOpts.onStart)(selectedArray,selectedIndex,selectedOpts);if(ret===false){busy=false;return}else if(typeof ret=="object"){selectedOpts=$.extend(selectedOpts,ret)}title=selectedOpts.title||(obj.nodeName?$(obj).attr("title"):obj.title)||"";if(obj.nodeName&&!selectedOpts.orig){selectedOpts.orig=$(obj).children("img:first").length?$(obj).children("img:first"):$(obj)}if(title===""&&selectedOpts.orig&&selectedOpts.titleFromAlt){title=selectedOpts.orig.attr("alt")}href=selectedOpts.href||(obj.nodeName?$(obj).attr("href"):obj.href)||null;if(/^(?:javascript)/i.test(href)||href=="#"){href=null}if(selectedOpts.type){type=selectedOpts.type;if(!href){href=selectedOpts.content}}else if(selectedOpts.content){type="html"}else if(href){if(href.match(imgRegExp)){type="image"}else if(href.match(swfRegExp)){type="swf"}else if(href.match(videoRegExp)){type="video"}else if(href.match(youtubeRegExp)){href=href.replace(youtubeRegExp,"$1/embed/$2?$3").replace("/(.*)?$/","");type="iframe"}else if(href.match(youtubeRegExp2)){var parts=href.split("/");href="//www.youtube.com/embed/"+parts[parts.length-1];type="iframe"}else if(href.match(vimeoRegExp)){href=href.replace(vimeoRegExp,"$1player.vimeo.com/video/$2");type="iframe"}else if(href.indexOf("http://")!=-1&&href.indexOf(location.hostname.toLowerCase())==-1){type="iframe"}else if(href.indexOf("#wk-")===0){type=window["wk_ajax_render_url"]?"widget":false}else if(href.indexOf("#")===0){type="inline"}else{type="ajax"}}if(!type){_error();return}if(type=="inline"){obj=href.substr(href.indexOf("#"));type=$(obj).length>0?"inline":"ajax"}selectedOpts.type=type;selectedOpts.href=href;selectedOpts.title=title;if(selectedOpts.autoDimensions&&selectedOpts.type!=="iframe"&&selectedOpts.type!=="swf"&&selectedOpts.type!=="video"&&selectedOpts.type!=="widget"){selectedOpts.width="auto";selectedOpts.height="auto"}if(selectedOpts.modal){selectedOpts.overlayShow=true;selectedOpts.hideOnOverlayClick=false;selectedOpts.hideOnContentClick=false;selectedOpts.enableEscapeButton=false;selectedOpts.showCloseButton=false}selectedOpts.padding=parseInt(selectedOpts.padding,10);selectedOpts.margin=parseInt(selectedOpts.margin,10);tmp.css("padding",selectedOpts.padding+selectedOpts.margin);$(".lightbox-inline-tmp").unbind("lightbox-cancel").bind("lightbox-change",function(){$(this).replaceWith(content.children())});switch(type){case"html":tmp.html(selectedOpts.content);_process_inline();break;case"video":busy=false;selectedOpts.scrolling="no";var vwidth=selectedOpts.width=="auto"?320:selectedOpts.width,vheight=selectedOpts.height=="auto"?240:selectedOpts.height,vattrs=[];vattrs.push('src="'+href+'"');vattrs.push('width="'+vwidth+'"');vattrs.push('height="'+vheight+'"');vattrs.push('preload="none"');if($.type(selectedOpts["autoplay"])!="undefined")vattrs.push('autoplay="'+String(selectedOpts["autoplay"])+'"');if($.type(selectedOpts["controls"])!="undefined")vattrs.push('controls="'+String(selectedOpts["controls"])+'"');if($.type(selectedOpts["loop"])!="undefined")vattrs.push('loop="'+String(selectedOpts["loop"])+'"');if($.type(selectedOpts["poster"])!="undefined")vattrs.push('poster="'+String(selectedOpts["poster"])+'"');tmp.html("<video "+vattrs.join(" ")+" /></video>");if($.fn["mediaelementplayer"]){$("video",tmp).each(function(){var mjs=new mejs.MediaElementPlayer(this);if(vwidth>$(window).width()){mjs.setPlayerSize("100%","100%")}})}selectedOpts.width="auto";selectedOpts.height="auto";_process_inline();break;case"inline":if($(obj).parent().is("#lightbox-content")===true){busy=false;return}$('<div class="lightbox-inline-tmp" />').hide().insertBefore($(obj)).bind("lightbox-cleanup",function(){$(this).replaceWith(content.children())}).bind("lightbox-cancel",function(){$(this).replaceWith(tmp.children())});$(obj).appendTo(tmp);_process_inline();break;case"image":busy=false;plugin.showActivity();imgPreloader=new Image;imgPreloader.onerror=function(){_error()};imgPreloader.onload=function(){busy=true;imgPreloader.onerror=imgPreloader.onload=null;_process_image()};imgPreloader.src=href;break;case"swf":selectedOpts.scrolling="no";selectedOpts.autoDimensions=false;str='<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="'+selectedOpts.width+'" height="'+selectedOpts.height+'"><param name="movie" value="'+href+'"></param>';emb="";$.each(selectedOpts.swf,function(name,val){str+='<param name="'+name+'" value="'+val+'"></param>';emb+=" "+name+'="'+val+'"'});str+='<embed src="'+href+'" type="application/x-shockwave-flash" width="'+selectedOpts.width+'" height="'+selectedOpts.height+'"'+emb+"></embed></object>";tmp.html(str);_process_inline();break;case"ajax":busy=false;plugin.showActivity();selectedOpts.ajax.win=selectedOpts.ajax.success;ajaxLoader=$.ajax($.extend({},selectedOpts.ajax,{url:href,data:selectedOpts.ajax.data||{},error:function(XMLHttpRequest,textStatus,errorThrown){if(XMLHttpRequest.status>0){_error()}},success:function(data,textStatus,XMLHttpRequest){var o=typeof XMLHttpRequest=="object"?XMLHttpRequest:ajaxLoader;if(o.status==200){if(typeof selectedOpts.ajax.win=="function"){ret=selectedOpts.ajax.win(href,data,textStatus,XMLHttpRequest);if(ret===false){loading.hide();return}else if(typeof ret=="string"||typeof ret=="object"){data=ret}}tmp.html(data);_process_inline()}}}));break;case"widget":busy=false;selectedOpts.autoDimensions=false;plugin.showActivity();selectedOpts.ajax.win=selectedOpts.ajax.success;ajaxLoader=$.ajax($.extend({},selectedOpts.ajax,{url:wk_ajax_render_url(href.split("-")[1]),data:selectedOpts.ajax.data||{},error:function(XMLHttpRequest,textStatus,errorThrown){if(XMLHttpRequest.status>0){_error()}},success:function(data,textStatus,XMLHttpRequest){var o=typeof XMLHttpRequest=="object"?XMLHttpRequest:ajaxLoader;if(o.status==200){if(typeof selectedOpts.ajax.win=="function"){ret=selectedOpts.ajax.win(href,data,textStatus,XMLHttpRequest);if(ret===false){loading.hide();return}else if(typeof ret=="string"||typeof ret=="object"){data=ret}}tmp.html(data);_process_inline();$widgetkit.lazyload($("#lightbox-content"))}}}));break;case"iframe":selectedOpts.autoDimensions=false;_show();break}},_process_inline=function(){tmp.wrapInner('<div style="width:'+(selectedOpts.width=="auto"?"auto":selectedOpts.width+"px")+";height:"+(selectedOpts.height=="auto"?"auto":selectedOpts.height+"px")+";overflow: "+(selectedOpts.scrolling=="auto"?"auto":selectedOpts.scrolling=="yes"?"scroll":"hidden")+'"></div>');selectedOpts.width=tmp.width();selectedOpts.height=tmp.height();_show()},_process_image=function(){selectedOpts.width=imgPreloader.width;selectedOpts.height=imgPreloader.height;$("<img />").attr({id:"lightbox-img",src:imgPreloader.src,alt:selectedOpts.title}).appendTo(tmp);_show()},_show=function(){var pos,equal;loading.hide();if(wrap.is(":visible")&&false===currentOpts.onCleanup(currentArray,currentIndex,currentOpts)){$(".lightbox-inline-tmp").trigger("lightbox-cancel");busy=false;return}busy=true;$(content.add(overlay)).unbind();$(window).unbind("resize.fb scroll.fb");$(document).unbind("keydown.fb");if(wrap.is(":visible")&&currentOpts.titlePosition!=="outside"){wrap.css("height",wrap.height())}currentArray=selectedArray;currentIndex=selectedIndex;currentOpts=selectedOpts;if(currentOpts.overlayShow){overlay.css({"background-color":currentOpts.overlayColor,opacity:currentOpts.overlayOpacity,cursor:currentOpts.hideOnOverlayClick?"pointer":"auto",height:$(document).height()});if(!overlay.is(":visible")){overlay.show()}}else{overlay.hide()}final_pos=_get_zoom_to();_process_title();if(wrap.is(":visible")){$(close.add(nav_left).add(nav_right)).hide();pos=wrap.position(),start_pos={top:pos.top,left:pos.left,width:wrap.width(),height:wrap.height()};equal=start_pos.width==final_pos.width&&start_pos.height==final_pos.height;content.fadeTo(currentOpts.changeFade,.3,function(){var finish_resizing=function(){content.html(tmp.contents()).fadeTo(currentOpts.changeFade,1,_finish)};$(".lightbox-inline-tmp").trigger("lightbox-change");content.empty().removeAttr("filter").css({"border-width":currentOpts.padding,width:final_pos.width-currentOpts.padding*2,height:currentOpts.type=="image"||currentOpts.type=="swf"||currentOpts.type=="iframe"?final_pos.height-titleHeight-currentOpts.padding*2:"auto"});if(equal){finish_resizing()}else{fx.prop=0;$(fx).animate({prop:1},{duration:currentOpts.changeSpeed,easing:currentOpts.easingChange,step:_draw,complete:finish_resizing})}});return}wrap.removeAttr("style");content.css("border-width",currentOpts.padding);content.css("-webkit-transform","translateZ(0)");if(currentOpts.transitionIn=="elastic"){start_pos=_get_zoom_from();content.html(tmp.contents());wrap.show();if(currentOpts.opacity){final_pos.opacity=0}fx.prop=0;$(fx).animate({prop:1},{duration:currentOpts.speedIn,easing:currentOpts.easingIn,step:_draw,complete:_finish});return}if(currentOpts.titlePosition=="inside"&&titleHeight>0){title.show()}content.css({width:final_pos.width-currentOpts.padding*2,height:currentOpts.type=="image"||currentOpts.type=="swf"||currentOpts.type=="iframe"?final_pos.height-titleHeight-currentOpts.padding*2:"auto"}).html(tmp.contents());wrap.css(final_pos).fadeIn(currentOpts.transitionIn=="none"?0:currentOpts.speedIn,_finish)},_format_title=function(title){if(title&&title.length){return'<div id="lightbox-title-'+currentOpts.titlePosition+'">'+title+"</div>"}return false},_process_title=function(){titleStr=currentOpts.title||"";titleHeight=0;title.empty().removeAttr("style").removeClass();if(currentOpts.titleShow===false){title.hide();return}titleStr=$.isFunction(currentOpts.titleFormat)?currentOpts.titleFormat(titleStr,currentArray,currentIndex,currentOpts):_format_title(titleStr);if(!titleStr||titleStr===""){title.hide();return}title.addClass("lightbox-title-"+currentOpts.titlePosition).html(titleStr).appendTo("body").show();switch(currentOpts.titlePosition){case"inside":title.css({width:final_pos.width-currentOpts.padding*2,marginLeft:currentOpts.padding,marginRight:currentOpts.padding});titleHeight=title.outerHeight(true);title.appendTo(outer);final_pos.height+=titleHeight;break;case"over":title.css({marginLeft:currentOpts.padding,width:final_pos.width-currentOpts.padding*2,bottom:currentOpts.padding}).appendTo(outer);break;case"float":title.css("left",parseInt((title.width()-final_pos.width-40)/2,10)*-1).appendTo(wrap);break;default:title.css({width:final_pos.width-currentOpts.padding*2,paddingLeft:currentOpts.padding,paddingRight:currentOpts.padding}).appendTo(wrap);break}title.hide()},_set_navigation=function(){if(currentOpts.enableEscapeButton||currentOpts.enableKeyboardNav){$(document).bind("keydown.fb",function(e){if(e.keyCode==27&&currentOpts.enableEscapeButton){e.preventDefault();plugin.close()}else if((e.keyCode==37||e.keyCode==39)&&currentOpts.enableKeyboardNav&&e.target.tagName!=="INPUT"&&e.target.tagName!=="TEXTAREA"&&e.target.tagName!=="SELECT"){e.preventDefault();plugin[e.keyCode==37?"prev":"next"]()}})}if(!currentOpts.showNavArrows){nav_left.hide();nav_right.hide();return}if(currentOpts.cyclic&&currentArray.length>1||currentIndex!==0){nav_left.show()}if(currentOpts.cyclic&&currentArray.length>1||currentIndex!=currentArray.length-1){nav_right.show()}},_finish=function(){if(!$.support.opacity){content.get(0).style.removeAttribute("filter");wrap.get(0).style.removeAttribute("filter")}wrap.css("height","auto");if(currentOpts.type!=="image"&&currentOpts.type!=="swf"&&currentOpts.type!=="iframe"){content.css("height","auto")}if(titleStr&&titleStr.length){title.show()}if(currentOpts.showCloseButton){close.show()}_set_navigation();if(currentOpts.hideOnContentClick){content.bind("click",plugin.close)}if(currentOpts.hideOnOverlayClick){overlay.bind("click",plugin.close)}$(window).bind("resize.fb",plugin.resize);if(currentOpts.centerOnScroll){$(window).bind("scroll.fb",plugin.center)}if(currentOpts.type=="iframe"){$('<iframe id="lightbox-frame" name="lightbox-frame'+(new Date).getTime()+'" frameborder="0" hspace="0" '+(!$.support.opacity?'allowtransparency="true""':"")+' scrolling="'+selectedOpts.scrolling+'" src="'+currentOpts.href+'"></iframe>').appendTo(content)}wrap.show();busy=false;plugin.center();(typeof currentOpts.onComplete=="string"?window[currentOpts.onComplete]:currentOpts.onComplete)(currentArray,currentIndex,currentOpts);_preload_images()},_preload_images=function(){var href,objNext;if(currentArray.length-1>currentIndex){href=currentArray[currentIndex+1].href;if(typeof href!=="undefined"&&href.match(imgRegExp)){objNext=new Image;objNext.src=href}}if(currentIndex>0){href=currentArray[currentIndex-1].href;if(typeof href!=="undefined"&&href.match(imgRegExp)){objNext=new Image;objNext.src=href}}},_draw=function(pos){var dim={width:parseInt(start_pos.width+(final_pos.width-start_pos.width)*pos,10),height:parseInt(start_pos.height+(final_pos.height-start_pos.height)*pos,10),top:parseInt(start_pos.top+(final_pos.top-start_pos.top)*pos,10),left:parseInt(start_pos.left+(final_pos.left-start_pos.left)*pos,10)};if(typeof final_pos.opacity!=="undefined"){dim.opacity=pos<.5?.5:pos}wrap.css(dim);content.css({width:dim.width-currentOpts.padding*2,height:dim.height-titleHeight*pos-currentOpts.padding*2})},_get_viewport=function(){return[$(window).width()-currentOpts.margin*2,$(window).height()-currentOpts.margin*2,$(document).scrollLeft()+currentOpts.margin,$(document).scrollTop()+currentOpts.margin]},_get_zoom_to=function(){var view=_get_viewport(),to={},resize=currentOpts.autoScale,double_padding=currentOpts.padding*2,ratio;if(currentOpts.width.toString().indexOf("%")>-1){to.width=parseInt(view[0]*parseFloat(currentOpts.width)/100,10)}else{to.width=parseInt(currentOpts.width)+double_padding}if(currentOpts.height.toString().indexOf("%")>-1){to.height=parseInt(view[1]*parseFloat(currentOpts.height)/100,10)}else{to.height=parseInt(currentOpts.height)+double_padding}if(resize&&(to.width>view[0]||to.height>view[1])){if(selectedOpts.type=="image"||selectedOpts.type=="swf"){ratio=currentOpts.width/currentOpts.height;if(to.width>view[0]){to.width=view[0];to.height=parseInt((to.width-double_padding)/ratio+double_padding,10)}if(to.height>view[1]){to.height=view[1];to.width=parseInt((to.height-double_padding)*ratio+double_padding,10)}}else{to.width=Math.min(to.width,view[0]);to.height=Math.min(to.height,view[1])}}to.top=parseInt(Math.max(view[3]-20,view[3]+(view[1]-to.height-40)*.5),10);to.left=parseInt(Math.max(view[2]-20,view[2]+(view[0]-to.width-40)*.5),10);return to},_get_obj_pos=function(obj){var pos=obj.offset();pos.top+=parseInt(obj.css("paddingTop"),10)||0;pos.left+=parseInt(obj.css("paddingLeft"),10)||0;pos.top+=parseInt(obj.css("border-top-width"),10)||0;pos.left+=parseInt(obj.css("border-left-width"),10)||0;pos.width=obj.width();pos.height=obj.height();return pos},_get_zoom_from=function(){var orig=selectedOpts.orig?$(selectedOpts.orig):false,from={},pos,view;if(orig&&orig.length){pos=_get_obj_pos(orig);from={width:pos.width+currentOpts.padding*2,height:pos.height+currentOpts.padding*2,top:pos.top-currentOpts.padding-20,left:pos.left-currentOpts.padding-20}}else{view=_get_viewport();from={width:currentOpts.padding*2,height:currentOpts.padding*2,top:parseInt(view[3]+view[1]*.5,10),left:parseInt(view[2]+view[0]*.5,10)}}return from},_animate_loading=function(){if(!loading.is(":visible")){clearInterval(loadingTimer);return}$("div",loading).css("top",loadingFrame*-40+"px");loadingFrame=(loadingFrame+1)%12};var Plugin=function(){};Plugin.prototype=$.extend(Plugin.prototype,{name:"lightbox",defaults:{padding:10,margin:40,opacity:false,modal:false,cyclic:false,scrolling:"auto",width:560,height:340,autoScale:true,autoDimensions:true,centerOnScroll:false,ajax:{},swf:{wmode:"transparent"},hideOnOverlayClick:true,hideOnContentClick:false,overlayShow:true,overlayOpacity:.7,overlayColor:"#777",titleShow:true,titlePosition:"float",titleFormat:null,titleFromAlt:false,transitionIn:"fade",transitionOut:"fade",speedIn:300,speedOut:300,changeSpeed:300,changeFade:"fast",easingIn:"swing",easingOut:"swing",showCloseButton:true,showNavArrows:true,enableEscapeButton:true,enableKeyboardNav:true,onStart:function(){},onCancel:function(){},onComplete:function(){},onCleanup:function(){},onClosed:function(){},onError:function(){}},init:function(){var $this=this;if($("#lightbox-wrap").length){return}$("body").append(tmp=$('<div id="lightbox-tmp"></div>'),loading=$('<div id="lightbox-loading"><div></div></div>'),overlay=$('<div id="lightbox-overlay"></div>'),wrap=$('<div id="lightbox-wrap"></div>'));body_margin=overlay.show().position();overlay.hide();if(body_margin.top!=0){overlay.css("top",body_margin.top*-1)}outer=$('<div id="lightbox-outer"></div>').appendTo(wrap);outer.append(content=$('<div id="lightbox-content"></div>'),close=$('<a id="lightbox-close"></a>'),title=$('<div id="lightbox-title"></div>'),nav_left=$('<a href="javascript:;" id="lightbox-left"><span id="lightbox-left-ico"></span></a>'),nav_right=$('<a href="javascript:;" id="lightbox-right"><span id="lightbox-right-ico"></span></a>'));close.bind("click",this.close);loading.bind("click",this.cancel);nav_left.bind("click",function(e){e.preventDefault();$this.prev()});nav_right.bind("click",function(e){e.preventDefault();$this.next()});if($.fn.mousewheel){wrap.bind("mousewheel.fb",function(e,delta){if(busy||currentOpts.type=="image"){e.preventDefault()}$this[delta>0?"prev":"next"]()})}if("ontouchend"in document){wrap.bind("touchstart",function(event){var data=event.originalEvent.touches?event.originalEvent.touches[0]:event,start={time:(new Date).getTime(),coords:[data.pageX,data.pageY],origin:$(event.target)},stop;function moveHandler(event){if(!start){return}var data=event.originalEvent.touches?event.originalEvent.touches[0]:event;stop={time:(new Date).getTime(),coords:[data.pageX,data.pageY]};if(Math.abs(start.coords[0]-stop.coords[0])>10){event.preventDefault()}}wrap.bind("touchmove",moveHandler).one("touchend",function(event){wrap.unbind("touchmove",moveHandler);if(start&&stop){if(stop.time-start.time<1e3&&Math.abs(start.coords[0]-stop.coords[0])>30&&Math.abs(start.coords[1]-stop.coords[1])<75){start.origin.trigger("swipe").trigger(start.coords[0]>stop.coords[0]?"swipeleft":"swiperight")}}start=stop=undefined})});wrap.bind("swipeleft",function(e){if(busy||currentOpts.type=="image"){e.preventDefault()}$this.next()}).bind("swiperight",function(e){if(busy||currentOpts.type=="image"){e.preventDefault()}$this.prev()})}},open:function(obj){var opts;if(busy){return}busy=true;opts=typeof arguments[1]!=="undefined"?arguments[1]:{};selectedArray=[];selectedIndex=parseInt(opts.index,10)||0;if($.isArray(obj)){for(var i=0,j=obj.length;i<j;i++){if(typeof obj[i]=="object"){$(obj[i]).data(plugin.name,$.extend({},opts,obj[i]))}else{obj[i]=$({}).data(plugin.name,$.extend({content:obj[i]},opts))}}selectedArray=$.merge(selectedArray,obj)}else{if(typeof obj=="object"){$(obj).data(plugin.name,$.extend({},opts,obj))}else{obj=$({}).data(plugin.name,$.extend({content:obj},opts))}selectedArray.push(obj)}if(selectedIndex>selectedArray.length||selectedIndex<0){selectedIndex=0}_start()},showActivity:function(){clearInterval(loadingTimer);loading.show();loadingTimer=setInterval(_animate_loading,66)},hideActivity:function(){loading.hide()},next:function(){return this.pos(currentIndex+1)},prev:function(){return this.pos(currentIndex-1)},pos:function(pos){if(busy){return}pos=parseInt(pos);selectedArray=currentArray;if(pos>-1&&pos<currentArray.length){selectedIndex=pos;_start()}else if(currentOpts.cyclic&&currentArray.length>1){selectedIndex=pos>=currentArray.length?0:currentArray.length-1;_start()}return},cancel:function(){if(busy){return}busy=true;$(".lightbox-inline-tmp").trigger("lightbox-cancel");_abort();selectedOpts.onCancel(selectedArray,selectedIndex,selectedOpts);busy=false},close:function(){if(busy||wrap.is(":hidden")){return}busy=true;if(currentOpts&&false===currentOpts.onCleanup(currentArray,currentIndex,currentOpts)){busy=false;return}_abort();$(close.add(nav_left).add(nav_right)).hide();$(content.add(overlay)).unbind();$(window).unbind("resize.fb scroll.fb");$(document).unbind("keydown.fb");content.find("iframe").attr("src","about:blank");if(currentOpts.titlePosition!=="inside"){title.empty()}wrap.stop();function _cleanup(){overlay.fadeOut("fast");title.empty().hide();wrap.hide();$(".lightbox-inline-tmp").trigger("lightbox-cleanup");content.empty();currentOpts.onClosed(currentArray,currentIndex,currentOpts);currentArray=selectedOpts=[];currentIndex=selectedIndex=0;currentOpts=selectedOpts={};busy=false}if(currentOpts.transitionOut=="elastic"){start_pos=_get_zoom_from();var pos=wrap.position();final_pos={top:pos.top,left:pos.left,width:wrap.width(),height:wrap.height()};if(currentOpts.opacity){final_pos.opacity=1}title.empty().hide();fx.prop=1;$(fx).animate({prop:0},{duration:currentOpts.speedOut,easing:currentOpts.easingOut,step:_draw,complete:_cleanup})}else{wrap.fadeOut(currentOpts.transitionOut=="none"?0:currentOpts.speedOut,_cleanup)}},resize:function(){if(overlay.is(":visible")){overlay.css("height",$(document).height())}final_pos=_get_zoom_to();switch(currentOpts.titlePosition){case"float":title.css("left",parseInt((title.width()-final_pos.width-40)/2,10)*-1);break;default:title.css("width",final_pos.width-currentOpts.padding*2);break;if(wrap.is(":visible")){pos=wrap.position(),start_pos={top:pos.top,left:pos.left,width:wrap.width(),height:wrap.height()};equal=start_pos.width==final_pos.width&&start_pos.height==final_pos.height;content.css({width:final_pos.width-currentOpts.padding*2,height:currentOpts.type=="image"||currentOpts.type=="swf"||currentOpts.type=="iframe"?final_pos.height-titleHeight-currentOpts.padding*2:"auto"});if(!equal){fx.prop=0;$(fx).animate({prop:1},{duration:currentOpts.changeSpeed,easing:currentOpts.easingChange,step:_draw})}}}plugin.center(true)},center:function(){var view,align;if(busy){return}align=arguments[0]===true?1:0;view=_get_viewport();if(!align&&(wrap.width()>view[0]||wrap.height()>view[1])){return}wrap.stop().animate({top:parseInt(Math.max(view[3]-20,view[3]+(view[1]-content.height()-40)*.5-currentOpts.padding)),left:parseInt(Math.max(view[2]-20,view[2]+(view[0]-content.width()-40)*.5-currentOpts.padding))},typeof arguments[0]=="number"?arguments[0]:200)}});$.fn[Plugin.prototype.name]=function(){var args=arguments;var options=args[0]?args[0]:{};return this.each(function(){$(this).data(Plugin.prototype.name,options).unbind("click."+Plugin.prototype.name).bind("click."+Plugin.prototype.name,function(e){e.preventDefault();if(busy){return}busy=true;$(this).blur();selectedArray=[];selectedIndex=0;var data=$(this).attr("data-lightbox")||"";if(data&&(data=data.match(/group:([^;]+)/i))){selectedArray=$('a[data-lightbox*="'+data[0]+'"], area[data-lightbox*="'+data[0]+'"]');selectedIndex=selectedArray.index(this)}else{selectedArray.push(this)}_start()})})};$(document).ready(function(){plugin=new Plugin;plugin.init();$[Plugin.prototype.name]=plugin})})(jQuery);