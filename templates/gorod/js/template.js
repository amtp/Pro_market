var $q = jQuery.noConflict();
var activregion = "";
var didScroll;
var lastScrollTop = 0;
var delta = 5;
var navbarHeight = jQuery('.top_panel').outerHeight();
var mf;
var ishup=0;
var istopup=0;
var fact;
var ishfixreal_1 = false;
var ishfixreal_2 = false;
if (typeof jQuery != "undefined") jQuery(function ($) {

    $('html.no-js').removeClass('no-js').addClass('js-ready');
});

function copyTextToClipboard(text) {
    if (!navigator.clipboard) {
        fallbackCopyTextToClipboard(text);
        return;
    }
    navigator.clipboard.writeText(text).then(function () {
        alert('Ссылка скопирована');
    }, function (err) {
        alert('Ошибка копирования ссылки: ', err);
    });
}

function thank_close() {
    var thankpopup = document.getElementById("rsfp_thankyou_popup_outer");
    document.body.removeChild(thankpopup);
    // var thankpopup = document.getElementById("rsfp_thankyou_popup_outer");
    //   thankpopup.outerHTML="";
}


var obshfx = new IntersectionObserver(howshrhfix, {
    threshold: [0, 1]
});

function howshrhfix(entries) {
    if (entries[0].intersectionRatio < 1) {
        // $q('.hfixblock-srch').addClass('hfix-srch');
        if (ishfixreal_1 == true) addFixCls();


    } else if (entries[0].intersectionRatio >= 1) {
        if (ishfixreal_1 == true) remFixCls();

    }

}


function srchshow() {
    $q(".m-srch-panel").addClass("in");



    $q(".fa-search.fag").hide();
  $q(".hide-dm").show();


}

function srchhide() {
    $q(".m-srch-panel").removeClass("in");
    $q(".fa-search.fag").show();


    $q(".hide-dm").hide();
}

function chnjregion(mt, regid) {

    if (activregion == "") document.getElementById('regonnum1').className = "";
    else document.getElementById(activregion).className = "";
    activregion = mt.parentElement.id;
    // mt.style.display = 'none';
    mt.parentElement.className = 'selected';
    document.getElementById('fcytinp').value = "";
    CitiesInRegion(regid);
}

jQuery(document).ready(function ($) {
    if (typeof (addFixCls) === "function") ishfixreal_1 = true;
    if (typeof (remFixCls) === "function") ishfixreal_2 = true;

    const d = document.querySelectorAll('[data-pop]');
    d.forEach(dot => dot.addEventListener('click', handleClick));
    if (typeof Joomla !== 'undefined') {
        const glrlist = Joomla.getOptions('glrys_id');
        if (glrlist != null) {
            glrlist.forEach(elment => {
                isload[`${elment}`] = false;
                var fopn = jQuery(`#uplnk_${elment}`);
                var finp = $(`input[glrdat="${elment}"]`);
                var chtf = $(`#stkim_${elment}`).children();

                const dspr = document.querySelector(`[data-identy="${elment}"]`)
                const tchild = dspr.children;
                for (var i = 0, len = tchild.length; i < len; i++) {
                    const imgn = tchild[i].getElementsByClassName("b-image__image")
                    const img = imgn[0];
                    if (stackfiles[`${elment}`] == null) stackfiles[`${elment}`] = [];
                    if (basefiles[`${elment}`] == null) basefiles[`${elment}`] = [];
                    //data-src
                    var filename = img.dataset.src.split('/').pop().split('#')[0].split('?')[0];
                    var file = new File(["foo"], filename, {
                        type: "image/png",
                    });
                    basefiles[`${elment}`].push(file);
                }

                const fp = $(`*[data-customerID="22"]`);
                tinput[`${elment}`] = finp;
                fopn[0].addEventListener("click", function (e) {
                    e.preventDefault();
                    if (isload[`${elment}`] == true) return;
                    finp.trigger('click');
                }, false);
                finp[0].addEventListener('change', function (e) {
                    fgopen(this, elment);
                }, false);
            });
        }
    }

    // mf= $q('#breadcrumb');
    // mf = document.getElementById("main_block");
    mf = document.querySelector('.breadcrumb');
    // mf = document.querySelector('.pre-hfix');
    if (mf != undefined) obshfx.observe(mf);
    fact = jQuery(".sub-filter");
});
var tinput = [];
var stackfiles = [];
var basefiles = [];
var isload = [];

function delimg(ujid, ij) {
    if (basefiles[`${ujid}`] != null) {
        const damrr = basefiles[`${ujid}`];
        const m = damrr.find((el) => el.name == ij);
        if (m != null) {
            stackfiles[`${ujid}`].push(m);
            document.getElementById(`imgl${ujid}${ij}`).style.display = 'none';
            tinput[`${ujid}`][0].files = FileListItem(stackfiles[`${ujid}`]);
            return;
        }
    }
    if (stackfiles[`${ujid}`] != null) {
        const darr = stackfiles[`${ujid}`];
        const t = darr.find((el) => el.name == ij);
        darr.splice(t, 1);
        if (t != null) {
            document.getElementById(`imgl${ujid}${ij}`).style.display = 'none';
            tinput[`${ujid}`][0].files = FileListItem(stackfiles[`${ujid}`]);
        }
    }
}

function fgopen(input, uid) {

    if (input.files && input.files[0]) {
        //if(input.files[0].size<=3072){
        if (stackfiles[`${uid}`] == null) stackfiles[`${uid}`] = [];
        if (iscont(input.files[0], stackfiles[`${uid}`])) {
            alert('Файл с таким именем уже существует!');
            isload[`${uid}`] = false;
            document.getElementById(`ldr_${uid}`).style.display = 'none';
            return;
        }
        var reader = new FileReader();
        document.getElementById(`ldr_${uid}`).style.display = 'block';

        reader.onload = function (e) {
            var dname = input.files[0].name;
            stackfiles[`${uid}`].push(input.files[0]);
            var t = input.files[0].name;
            var data = `<span class="bm-scroll__item" id="imgl${uid}${t}">
           <div class="glry-image">
                <div class="b-image">
                <img class="b-image__image" alt="" src="${e.target.result}" id="imglpst${uid}${t}"></div>
            <div class="plupload_file_action" onclick="delimg('${uid}','${dname}')" title="Удалить изоброжение">
                <div class="fa fa-window-close plupload_action_icon ui-icon ui-icon-circle-minus"  > </div></div></div></span>`;

            document.getElementById(`stkim_${uid}`).innerHTML += data;
            document.getElementById(`ldr_${uid}`).style.display = 'none';
            isload[`${uid}`] = false;
            input.files = FileListItem(stackfiles[`${uid}`]);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function FileListItem(a) {
    a = [].slice.call(Array.isArray(a) ? a : arguments)
    for (var c, b = c = a.length, d = !0; b-- && d;) d = a[b] instanceof File
    if (!d) throw new TypeError("expected argument to FileList is File or array of File objects")
    for (b = (new ClipboardEvent("")).clipboardData || new DataTransfer; c--;) b.items.add(a[c])
    return b.files
}

function iscont(val, arr) {
    return false;
    const t = arr.find((el) => el.name == val.name);
    if (t == undefined) return false;
    if (t.size == val.size) {
        return true;
    } else {
        return false;
    }
    return false;
}

function handleClick(e) {
    var img = e.target;
    var src = img.currentSrc;
    jQuery("body").append("<div class='popupg'>" +
        "<img src='" + src + "' class='popupg_img' />" +
        "</div>");
    jQuery(".popupg").fadeIn(100);
    jQuery(".popupg").click(function () {
        jQuery(".popupg").fadeOut(100);
        setTimeout(function () {
            jQuery(".popupg").remove();
        }, 10);
    });
}

jQuery(document).scroll(function (event) {
    didScroll = true;
});


setInterval(function () {
    if (didScroll) {
        hasScrolled();
        didScroll = false;
    }
}, 250);
jQuery(document).click(function (e) {
    if (jQuery(e.target).closest(fact).length)
        return;
    if (jQuery(e.target).closest('.filteritm').length)
        return;
    if (jQuery(e.target).closest('.filter-main').length)
        return;
    if (jQuery(e.target).closest('.filter-main').length)
        return;
    fact.fadeOut(100);
});

function filterclic(elm) {
    var sublistd = elm.querySelectorAll('ul')[0];
    var sublist = jQuery(elm);
    var sublists = jQuery(sublist.children("ul.sub-filter"));
    if (sublists.css("display") == "none") {
        fact.hide();
        sublists.fadeIn(100);
    } else {
        sublists.fadeOut(100);
    }
}

function hidetop_menu() {

}
function showtop_menu() {

}
var prevScrollpos = window.pageYOffset;
window.onscroll = function () {
    var currentScrollPos = window.pageYOffset;
    if (prevScrollpos > currentScrollPos) {
    //    document.getElementById("navbar").style.top = "0";
    } else {
    //    document.getElementById("navbar").style.top = "-50px";
    }
    prevScrollpos = currentScrollPos;
}


function hasScrolled() {
    var st = jQuery(this).scrollTop();
    if (Math.abs(lastScrollTop - st) <= delta)
        return;
    if (st > lastScrollTop && st > navbarHeight) {
        if (ishup==1) {
            $q(".h-fix").removeClass('mxhfix');
            $q(".top_panel").css('top', '-50px');
            istopup=1
        }
    } else {
        if (st + $q(window).height() < $q(document).height()) {
            if (istopup==1){
                $q(".top_panel").css('top', '0px');
                istopup=0;
            }

            if (ishup==1) {
                $q(".h-fix").addClass('mxhfix');
            } else {
                $q(".h-fix").removeClass('mxhfix');
            }
        }
    }
    lastScrollTop = st;
}












