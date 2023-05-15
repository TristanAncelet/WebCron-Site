function setDatabaseVersion() {
    url = '/api/database_version.php';
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
    url = "/api/crontab_stats.php";
    response = makeRequest(url);
    setInfoSection(response);
}

function setInfoSection (string) {
    var info_section = document.getElementById("content");
    info_section.innerHTML = string;
}

function getTable(name){
    url = "/api/table.php?name=" + name;
    response = makeRequest(url);
    setInfoSection(response);
}

function getCrontabs (){
    url = "/api/table.php?name='crontabs'&columns=crontab_path,crontab_created_timestamp,crontab_modified_timestamp";
    response = makeRequest(url);
    setInfoSection(response);
}

function test (){
    url = "/api/crontab_view.php?name=0hourly";
    response = makeRequest(url);
    setInfoSection(response);
}

function triggerPopup(info_to_get){
    const modal = document.querySelector('dialog');

    document.querySelector("#popup_button").addEventListener("click", () => {modal.showModal();});
}
