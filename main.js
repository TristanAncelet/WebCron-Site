function request_sqlite_version () {
    var request = new XMLHttpRequest();
    request.open("GET", 'http://localhost:8000/database_version.php', false);
    request.send(null);
    return request.responseText;
}

function setInfoSection (string) {
    var info_section = document.getElementById("content");
    info_section.innerHTML = request_sqlite_version();
}


