//516.ru catalog engn
var citemisld = false;
var orgf1 = '0';
var orgf2 = '0';
var pstrt = 15;
var dtablecom;
jQuery(window).scroll(function () {
    if (jQuery(window).scrollTop() + jQuery(window).height() >= jQuery(document).height() - 1) {
        if (citemisld == false) {
            citemisld = true;
            companylist("", "");
        }
    }

});

function AjaxitemsForm() {
    if (citemisld == false) {
        citemisld = true;
        companylist("", "");
    }

}


function companylist(ftype, fval, isnew = 0) {
    switch (ftype) {
        case "colr": {
            if (isnew = 1)
                if (orgf1 == fval) return;
            orgf1 = fval;
            if (fval == 0) {
                $q('.foff.fa-star-o').show();
                $q('.fonn.fa-star').hide();
                document.getElementById('fsglc').innerHTML = "Все";
                document.getElementById('fsgl0').style.display = 'inline-block';
                document.getElementById('fsgl1').style.display = 'none';

            } else {
                $q('.foff.fa-star-o').hide();
                $q('.fonn.fa-star').show();
                document.getElementById('fsglc').innerHTML = "Проверенные";
                document.getElementById('fsgl1').style.display = 'inline-block';
                document.getElementById('fsgl0').style.display = 'none';
            }

            break;
        }

        case "city": {
            if (isnew = 1)
                if (orgf2 == fval) return;
            orgf2 = fval;
            if (fval == 0) {
                $q('.foff.fa-map-o').show();
                $q('.fonn.fa-map').hide();
                document.getElementById('fsclc').innerHTML = "В моём городе";
                document.getElementById('fscl0').style.display = 'inline-block';
                document.getElementById('fscl1').style.display = 'none';
            } else {
                $q('.foff.fa-map-o').hide();
                $q('.fonn.fa-map').show();
                document.getElementById('fsclc').innerHTML = "Все города";
                document.getElementById('fscl1').style.display = 'inline-block';
                document.getElementById('fscl0').style.display = 'none';
            }
            break;
        }
    }

    if (isnew == 1) {
        pstrt = 0;
        document.getElementById('itemlist').innerHTML = "";
        dtablecom.clear().draw();

    } else {
        pstrt += 15;
    }

    var itmloading = jQuery('<div class="cssload-container" id="citychnj" style="display: block;">\n' +
        '                <div class="cssload-loading"><i></i><i></i><i></i><i></i></div>\n' +
        '            </div>')
    document.getElementById('moreloadcn').style.display = 'none';
    jQuery("#itemlist").append(itmloading);

    var cobj = document.getElementById('cgl');
    var sgd = cobj.value;
    jQuery.ajax({
        url: 'index.php?option=com_content&format=ajax&lang=en&view=article&task=getorgftr&tmpl=component&f1=' + orgf1 +
            '&f2=' + orgf2 + "&isnew=" + isnew + "&pstrt=" + pstrt + "&sgd=" + sgd,
        type: 'post',
        dataType: 'html',
        async: true,
        success: function (response) {

            data = jQuery.parseJSON(response);
            pstrt += 15;
            itmloading.detach();
            jQuery("#itemlist").append(data.datahtml);
            dtablecom.rows.add(data.totable).draw();
            if (data.datahtml == "")
                document.getElementById('moreloadcn').innerHTML = "Конец списка";
            else
                document.getElementById('moreloadcn').innerHTML = "Загрузить ещё";
            document.getElementById('moreloadcn').style.display = 'block';
            if (data.datahtml != "") citemisld = false;


        },
        error: function (response) {
            citemisld = false;
            // alert(response.responseText);
        }
    });
}

