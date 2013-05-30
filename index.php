<?php
// Gestion de la userkey que nos viene de GEL
if (isset($_GET['userKey'])) {
    setcookie("user", $_GET['userKey'] , time()+3600);
    header('Location: http://baal.uc3m.es/genghis/');
}
if (!isset($_COOKIE['user']) & !isset($_GET['userKey'])) {
    header('Location: http://baal.uc3m.es/gel');
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<title>Genghis</title>

<!-- METAINFO -->
<meta name="author" content="jusanzm@it.uc3m.es"></meta>
<meta name="description" content="Genghis, la herramienta para crear ejercicios de Khan Academy"></meta>
<meta charset="utf-8" />
<link rel="icon" type="image/png" href="http://baal.uc3m.es/khan_exercises/images/favicon.ico">


<!-- CSS -->
<link rel="stylesheet" href="./libs/jqueryUI/css/custom-jqueryui-theme/jquery-ui-1.9.2.custom.min.css" type="text/css"></link>
<link rel="stylesheet" href="./libs/css/puvikhan.css" type="text/css"></link>
<link rel="stylesheet" href="./libs/css/fonts/stylesheet.css" type="text/css" media="screen"></link>

<!-- JS -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>
<script type="text/javascript" src="./libs/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="./libs/js/jquery.multi-accordion-1.5.3.js"></script>
<script type="text/javascript" src="./libs/autosave/javascript/jquery.autosave.js"></script>
<script type="text/javascript" src="./libs/tinymce/jscripts/tiny_mce/plugins/asciimath/js/ASCIIMathMLwFallback.js"></script>
<script type="text/javascript">
var AMTcgiloc = "http://www.imathas.com/cgi-bin/mimetex.cgi";  		//change me
</script>



<script>
$(function() {
    $( "#tabs" ).tabs();
});
</script>


<script type="text/javascript">
//Script encargado de guardar la altura a la que esta el usuario en la pagina y que pestañas tiene abiertas
cookieName="page_scroll";
cookieName2="open_tabs";
expdays=365;

// An adaptation of Dorcht's cookie functions.

function setCookie(name, value, expires, path, domain, secure){
    if (!expires){expires = new Date()}
        document.cookie = name + "=" + escape(value) + 
        ((expires == null) ? "" : "; expires=" + expires.toGMTString()) +
        ((path == null) ? "" : "; path=" + path) +
        ((domain == null) ? "" : "; domain=" + domain) +
        ((secure == null) ? "" : "; secure")
}

function getCookie(name) {
    var arg = name + "="
        var alen = arg.length
        var clen = document.cookie.length
        var i = 0
        while (i < clen) {
            var j = i + alen
                if (document.cookie.substring(i, j) == arg){
                    return getCookieVal(j)
                }
            i = document.cookie.indexOf(" ", i) + 1
                if (i == 0) break
        }
    return null
}

function getCookieVal(offset){
    var endstr = document.cookie.indexOf (";", offset);
    if (endstr == -1)
        endstr = document.cookie.length;
    return unescape(document.cookie.substring(offset, endstr));
}

function deleteCookie(name,path,domain){
    document.cookie = name + "=" +
        ((path == null) ? "" : "; path=" + path) +
        ((domain == null) ? "" : "; domain=" + domain) +
        "; expires=Thu, 01-Jan-00 00:00:01 GMT";
}

function saveScroll(){ // added function
    var expdate = new Date ();
    expdate.setTime (expdate.getTime() + (expdays*24*60*60*1000)); // expiry date

    var x = (document.pageXOffset?document.pageXOffset:document.body.scrollLeft);
    var y = (document.pageYOffset?document.pageYOffset:document.body.scrollTop);
    Data=x + "_" + y;
    setCookie(cookieName,Data,expdate);

    var varia = $("div.course")[0].className == "course active" ? 1 : 0;
    var title = $("div.course")[1].className == "course active" ? 1 : 0;
    var state = $("div.course")[2].className == "course active" ? 1 : 0;
    var solut = $("div.course")[3].className == "course active" ? 1 : 0;
    var hints = $("div.course")[4].className == "course active" ? 1 : 0;

    Data2= varia + "_" + title + "_" + state + "_" + solut + "_" + hints;
    // Data2= "0_0_1_0_0";
    setCookie(cookieName2,Data2,expdate);
}

function loadScroll(){ // added function
    if($('h1.typeOfPage').html()== "Fill in the blank"){
        inf2=getCookie(cookieName2);
        if(!inf2){return;}
        var ar2 = inf2.split("_");
        for (var i = 0; i < ar2.length; i++) {
            if(ar2[i]=="1"){
                $("div.course")[i].click();
        /*	if($("div.course")[i].className != "course active"){
            $("div.course")[i].className = 'course active';
            } else {
                $("div.course")[i].className = 'course';
        }*/
            }
        }
    }
    inf=getCookie(cookieName);
    if(!inf){return;}
    var ar = inf.split("_");
    if(ar.length == 2){
        window.scrollTo(parseInt(ar[0]), parseInt(ar[1]));
    }
}

// add onload="loadScroll()" onunload="saveScroll()" to the opening BODY tag

</script>

<script>
$(document).ready(function() {
/* $("div.elem").click(function() {			
    if ($(this).attr("id")) {
        location.href = 'http://163.117.152.240/khan_exercises/?class=admin&action=info&elem=' + $(this).attr("id");				
    }
});
 */
    $("div.course").click(function() {
        $(this).toggleClass("active");
        if ($("span.toggle", $(this)).length == 0) return;

        $(".elem", $(this).parent()).each(function() {
            $(this).slideToggle(100);

        });

        $("span.toggle", $(this)).toggleClass("more");

    });

});
</script>
</head>

<body onload="loadScroll()" onunload="saveScroll()">

    <div id="global-message">Cargando...</div>

    <div id="wrapper">
        <div class="spacer"></div>

        <div id="header"></div>

        <div id="content">

<?php 
include 'configs.php';


/*
 * ------- CONFIGS ---------
 */


$con = mysql_connect(DB_HOST, DB_USER, DB_PASS);

if (!$con)
{
    die('Could not connect: ' . mysql_error());
}
mysql_select_db("khan_exercises", $con);


try {
    require_once("./libs/sdic_api_client_elearning.class.php");
    $api = new SDICApiClientELearning();

    $api->assignKey("18908eee-90a1-11e2-a8a5-005056933b24");
} catch (Exception $e) {
    echo "Exception: ".$e->getMessage();
}
$user = $api->getUser($_COOKIE["user"]);
$logoutURL =$api->getLogoutURL();
$platforms = $api->getPlatforms();
$departments = $api->getDepartments();
$courses = $api->getCourses(NULL, $user->results->uid);


/* ----- END OF CONFIGS ------*/
include 'libs/header_sdic.php';
if (isset($_REQUEST['question_id'])) {
    $_SESSION['question_id'] = $_REQUEST['question_id'];

    //Page handling
    if ($_GET['page'] != '') {
        $currentActivePages = array('error', 'FillInTheBlank', 'list', 'admin');
        if (in_array($_GET['page'], $currentActivePages)) {
            include('controllers/' . $_GET['page'] . '.php');;
        } else {
            include('controllers/error.php');
        }
    } else {
        include("controllers/FillInTheBlank.php");
    }

} elseif ($_GET['iam'] == 'admin') {
    include('controllers/admin.php');
} else {
    include("controllers/list.php");
}
?>

        </div>
        <!-- End of content div -->

        <div id="footer"></div>

        <div class="spacer"></div>

        <div id="credits">
            <p>
                <span class="bold">Designed by:</span> <a href="http://it.uc3m.es">Departamento de Ingeniería Telemática</a> | <span class="bold">Version:</span>
                0.1 | <span class="bold">Support:</span> jusanzm@it.uc3m.es
            </p>
            <p>
                &copy; 2013 <a href="http://www.uc3m.es">Universidad Carlos III de Madrid</a>
            </p>
            <p></p>
        </div>
    </div>
<script type="text/javascript">
function remove_textbox() {
    var item = document.getElementById('new_var_type');

    var index = item.selectedIndex;
    if (item.options[index].text == 'entero' ) {
        document.getElementById('step_string').style.display="none";
    }
    if (item.options[index].text == 'racional' ) {
        document.getElementById('step_string').style.display="inline";
    }

}

</script>

</body>
</html>
