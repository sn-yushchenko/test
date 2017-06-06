function getAjaxRequest(adress, params, callback) {
    xmlhttp.open('POST', adress, true);
    xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == 4) {
            if (xmlhttp.status == 200) {
                callback(xmlhttp.responseText);
            }
        }
    }

    xmlhttp.send(params);
}
/*Создаем объект для работы аснхронными запросами*/
function getXmlHttp() {

    var xmlhttp;
    try {
        xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
    } catch (e) {
        try {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        } catch (E) {
            xmlhttp = false;
        }
    }
    if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
        xmlhttp = new XMLHttpRequest();
    }
    return xmlhttp;
}

var xmlhttp = getXmlHttp();
// Отлавливаем нажатие клавиш и обрабатываем ответы сервера
document.addEventListener('click', function (event) {
    event = event || window.event;
    if (event.target.className == "buttonComment") {
        var load = document.getElementById("load");
        load.style.display = "block";
        load.innerHTML = "loading...";
        var id = event.target.getAttribute("id");
        if (id == "newBut") {
            var comment = document.getElementById(id.substring(0, id.indexOf("But"))).value;
            var str = document.getElementsByClassName("username")[0].getAttribute("id");
            var user_id = str.substring(0, str.indexOf("user"));
            var parent_id = 0;
            var adress = '/test/add';
            var params = 'comment=' + comment + "&user_id=" + user_id + "&parent_id=" + parent_id;
            getAjaxRequest(adress, params, function (response) {
                load.style.display = "none";
                var li = document.createElement('li');
                li.innerHTML = response;
                var block = document.getElementsByTagName('ul')[0];
                block.appendChild(li);
                document.getElementById(id.substring(0, id.indexOf("But"))).value = "";
                getWidthField("bodycomment");
                getWidthField("entryField");
            })
        } else {
            var comment = document.getElementById("f" + id.substring(0, id.indexOf("But"))).value;
            var str = document.getElementsByClassName("username")[0].getAttribute("id");
            var user_id = str.substring(0, str.indexOf("user"));
            var parent_id = id.substring(0, id.indexOf("But"));
            var adress = '/test/add';
            var params = 'comment=' + comment + "&user_id=" + user_id + "&parent_id=" + parent_id;
            getAjaxRequest(adress, params, function (response) {
                load.style.display = "none";
                var ul = document.createElement("ul");
                ul.innerHTML = response;
                var block = document.getElementById(parent_id + "li");
                block.appendChild(ul);
                document.getElementById(id.substring(0, id.indexOf("But"))).value = "";
                getWidthField("bodycomment");
                getWidthField("entryField");
            })
        }
    } else if (event.target.className == "like") {
        var idlike = event.target.getAttribute("id");
        var str = document.getElementsByClassName("username")[0].getAttribute("id");
        var user_id = str.substring(0, str.indexOf("user"));
        var id = event.target.getAttribute("id").substring(1, idlike.length);
        var span = document.getElementById("cl" + id);
        var count = span.innerHTML;
        var adress = '/test/like';
        var params = 'countLike=' + count + "&comment_id=" + id + "&user_id=" + user_id;
        getAjaxRequest(adress, params, function (response) {
            span.innerHTML = response;

        })
    } else if (event.target.className == "dislike") {
        var idlike = event.target.getAttribute("id");
        var str = document.getElementsByClassName("username")[0].getAttribute("id");
        var user_id = str.substring(0, str.indexOf("user"));
        var id = event.target.getAttribute("id").substring(1, idlike.length);
        var span = document.getElementById("cd" + id);
        var count = span.innerHTML;
        var adress = '/test/dislike';
        var params = 'countDislike=' + count + "&comment_id=" + id + "&user_id=" + user_id;;
        getAjaxRequest(adress, params, function (response) {
            span.innerHTML = response;
        })
    } else if (event.target.getAttribute("id") == "buttonEntry") {
        var email = document.getElementById("email").value;
        var password = document.getElementById("password").value;
        var adress = '/test/autorization';
        var params = 'email=' + email + "&password=" + password;
        getAjaxRequest(adress, params, function (response) {
            var user = document.getElementsByClassName("username")[0];
            if (response == 1) {
                user.innerHTML = "Вы ввели не правильный email или пароль!";
            } else {
                var arr = JSON.parse(response);
                user.innerHTML = arr["name"];
                user.setAttribute("id", arr["user_id"] + "user");
                document.getElementById("newBut").style.display = "block";
            }
            document.getElementById("email").value = "";
            document.getElementById("password").value = "";

        })
    } else if (event.target.className == "delete") {
        var idelete = event.target.getAttribute("id");
        var str = document.getElementsByClassName("username")[0].getAttribute("id");
        var user_id = str.substring(0, str.indexOf("user"));
        var comment_id = event.target.getAttribute("id").substring(3, idelete.length);
        var adress = '/test/delete';
        var params = "comment_id=" + comment_id + "&user_id=" + user_id;;
        getAjaxRequest(adress, params, function (response) {
            if (response == 1) {
                var block = document.getElementById(comment_id + "li");
                block.parentNode.removeChild(block);
            }
        })
    }
});