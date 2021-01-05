function JSVRvote(id, i, total, total_count, counter,con_type=0) {
    var currentURL = window.location;
    var live_site = currentURL.protocol + '//' + currentURL.host;
    var lsXmlHttp = '';
    var div = document.getElementById('vrvote_' + id+"_"+con_type);
    if (div.className != 'vrvote-count voted') {
        div.innerHTML = '<img src="' + live_site + '/plugins/content/vrvote/images/loading.gif" border="0" align="absmiddle" />';
        try {
            lsXmlHttp = new XMLHttpRequest();
        } catch (e) {
            try {
                lsXmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
            } catch (e) {
                try {
                    lsXmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
                } catch (e) {
                    alert(extravote_text[0]);
                    return false;
                }
            }
        }
    }
    div.className = 'vrvote-count voted';
    if (lsXmlHttp != '') {
        lsXmlHttp.onreadystatechange = function() {
            var response;
            if (lsXmlHttp.readyState == 4) {
                setTimeout(function() {
                    response = lsXmlHttp.responseText;
                    if (response == 'thanks') div.innerHTML = '<small>(Спасибо за Оставленный рейтинг)</small>';
                    if (response == 'login');
                    if (response == 'voted');
                }, 500);
                setTimeout(function() {
                    if (response == 'thanks') {
                        var newtotal = total_count + 1;
                        var percentage = ((total + i) / (newtotal));
                        document.getElementById('rating_' + id+"_"+con_type).style.width = parseInt(percentage * 20) + '%';
                    }
                    if (counter != 0) {
                        if (response == 'thanks') {
                            if (newtotal != 1) var newvotes = extravote_text[5].replace('%s', newtotal);
                            else
                                var newvotes = extravote_text[6].replace('%s', newtotal);
                        } else {
                            if (total_count != 0 || counter != -1) {
                                if (total_count != 1) var votes = extravote_text[5].replace('%s', total_count);
                                else
                                    var votes = extravote_text[6].replace('%s', total_count);
                            } else {
                                div.innerHTML = '';
                            }
                        }
                    } else {
                        div.innerHTML = '';
                    }
                }, 2000);
            }
        }
        lsXmlHttp.open("GET", live_site + "/plugins/content/vrvote/assets/ajax.php?task=vote&user_rating=" + i + "&cid=" + id+"&con_type="+con_type, true);
        lsXmlHttp.send(null);
    }
}