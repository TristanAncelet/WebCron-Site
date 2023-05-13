function setDatabaseVersion() {
    url = 'http://localhost:8000/api/database_version.php';
    response = makeRequest(url);
    setInfoSection(response);
}


function makeRequest(url){
    var request = new XMLHttpRequest();
    request.open("GET", url, false);
    request.send(null);
    return request.responseText;
}

function setCrontabStats(){
    url = "http://localhost:8000/api/crontab_stats.php";
    response = makeRequest(url);
    setInfoSection(response);
}

function setInfoSection (string) {
    var info_section = document.getElementById("content");
    info_section.innerHTML = string;
}

function getTable(name){
    url = "http://localhost:8000/api/table.php?name=" + name;
    response = makeRequest(url);
    setInfoSection(response);
}
