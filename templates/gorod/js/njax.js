var activregion;

jQuery(document).ready(function () {


    jQuery('.gorod').click(function () {
        document.getElementById('fcytinp').value = "";
        document.getElementById('cityloader').style.display = 'block';
        jQuery.ajax({
            url: 'index.php?option=com_content&format=ajax&lang=en&view=article&task=getCityes&tmpl=component',
            type: 'post',
            dataType: 'html',
            async: true,
            success: function (response) {


                data = jQuery.parseJSON(response);
                document.getElementById('regionlist').innerHTML = data.regions;
                document.getElementById('townlist').innerHTML = data.towns;
                document.getElementById('cityloader').style.display = 'none';
                document.getElementById('popupCitycnt').style.display = 'block';
                activregion = "";
                //jQuery(response).appendTo( jQuery('#regionlist') );
                //  $('#regionlist').html(response);

            }
        });

    });

    jQuery(document).mouseup(function ($) {
        $q('#resrch').hide();
        $q('#resrchfx').hide();
    });



});

function Citycntcls() {
    $q('#popupCitycnt').hide();
}

function swctex() {
    $q('#popupcatexM').show();
}

function swctexcls() {
    $q('#popupcatexM').hide();
}


function SetCity(f) {

    document.getElementById('loadref').style.display = 'block';
    // document.getElementById('townlist' ).innerHTML = "";


    jQuery.ajax({
        url: 'index.php?option=com_content&format=ajax&lang=en&view=article&task=SetCity&tmpl=component&fstid=' + f,
        type: 'post',
        dataType: 'html',
        async: true,
        success: function (response) {
            if (response == 'ok') {
                location.reload();
            } else {
                alert("Что то пошло не так :( Обновите страницу. ");
            }

            // document.getElementById('townlist' ).innerHTML = data.towns;
            //document.getElementById('cityloader2' ).style.display = 'none';
            //jQuery(response).appendTo( jQuery('#regionlist') );
            //  $('#regionlist').html(response);

        }
    });
}

function CitiesInRegion(f) {
    document.getElementById('ctityblock').classList.remove("tkmob");
    document.getElementById('cityloader2').style.display = 'block';
    document.getElementById('townlist').innerHTML = "";
    jQuery.ajax({
        url: 'index.php?option=com_content&format=ajax&lang=en&view=article&task=CityesInRegion&tmpl=component&region=' + f,
        type: 'post',
        dataType: 'html',
        async: true,
        success: function (response) {
            data = jQuery.parseJSON(response);
            document.getElementById('townlist').innerHTML = data.towns;
            document.getElementById('cityloader2').style.display = 'none';
            document.getElementById('ctityblock').style.display = 'block';
            //jQuery(response).appendTo( jQuery('#regionlist') );
            //  $('#regionlist').html(response);

        }
    });
}

function ajSearchcity(svart) {

    document.getElementById('cityloader2').style.display = 'block';
    document.getElementById('townlist').innerHTML = "";
    var stxt = encodeURI(svart);
    jQuery.ajax({
        url: 'index.php?option=com_content&format=ajax&lang=en&view=article&task=findCityes&tmpl=component&stext=' + stxt,
        type: 'post',
        dataType: 'html',
        async: true,
        success: function (response) {
            data = jQuery.parseJSON(response);
            document.getElementById('townlist').innerHTML = data.towns;
            document.getElementById('cityloader2').style.display = 'none';
            //jQuery(response).appendTo( jQuery('#regionlist') );
            //  $('#regionlist').html(response);

        }
    });
}

function visResultcf(el ) {
    if ($q(el).parent().children().first().val() != '') {
        $q(el).parent().children().last().show();
    }

}

function clearResultcf(el ) {
    $q('.forg-clear').hide();
    if ($q(el).parent().children().first().val() != '') {
        $q(el).parent().children().first().val('');
        $q(el).parent().children().last().html('');
    } else {
        $q(el).parent().children().last().html('');
    }
}

function showResultcf(el) {
    var inptxt = $q(el).parent().children().first().val();
    if (inptxt == '') {
        clearResultcf(el);
        return ;
    }
    $q('.forg-clear').show();
    var stxt = encodeURI(inptxt);
    jQuery.ajax({
        url: 'index.php?option=com_content&format=ajax&lang=en&view=article&task=findCompanys&tmpl=component&stext=' + stxt,
        type: 'post',
        dataType: 'html',
        async: true,
        success: function (response) {
            data = jQuery.parseJSON(response);
            $q(el).parent().children().last().html(data.finresult);
            $q(el).parent().children().last().show();
        }
    });
}


function searchTown(str = '') {
    if (str.length == 0) {
        document.getElementById('fcytinp').value = "";
        document.getElementById('federallist').classList.remove("tkmob");

        document.getElementById('ctityblock').classList.remove("tkmobn");
        document.getElementById('ctityblock').classList.add("tkmob");
        ajSearchcity("");
    }
    if (str.length > 1) {
        ajSearchcity(str);
        document.getElementById('ctityblock').classList.remove("tkmob");
        document.getElementById('ctityblock').classList.add("tkmobn");

        document.getElementById('federallist').classList.add("tkmob");
    }
}


function initslide_menu(tcontent) {
    var slider_cnt = document.getElementById(tcontent);
    slider_cnt.style.display = 'none';
}

function slidemenub(mcontnt) {
    var slider_cnt = document.getElementById(mcontnt);
    var $dnldmenu = jQuery(`.${mcontnt}`);
    var $dnldmenu = jQuery('.app-m-content');
    if (slider_cnt.style.display == 'none') {
        $dnldmenu.delay(1).slideDown('fast');
    } else {
        $dnldmenu.delay(1).slideUp('fast');
    }

}

