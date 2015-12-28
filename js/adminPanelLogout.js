function getLogoutContent() {
    var ajaxRequest = getXMLHTTPRequest();
    ajaxRequest.open("POST", "include/ajaxLogout.php", true);
    ajaxRequest.onreadystatechange = response;
    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajaxRequest.send();
    
    function response() {
        if(ajaxRequest.readyState == 4 && ajaxRequest.status == 200) {
            window.location = "index.php";
        }
    }
}