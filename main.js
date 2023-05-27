function setAreaByUrl(url){
    response = makeRequest(url);
    setInfoSection(response);
}
function setDatabaseVersion() {
    url = '/api/database_version.php';
    setAreaByUrl(url);
}

function makeRequest(url){
    var request = new XMLHttpRequest();
    request.open("GET", url, false);
    request.send(null);
    return request.responseText;
}

function setCrontabStats(){
    url = "/api/crontab_stats.php";
    setAreaByUrl(url);
}

function setInfoSection (string) {
    var info_section = document.getElementById("content");
    info_section.innerHTML = string;
}

function getTable(name){
    url = "/api/table.php?name="+name;
    setAreaByUrl(url);
}

function listTables(){
    url="/api/table.php?action=list";
    setAreaByUrl(url);
}

function getCrontabs (){
    url = "/api/table.php?name='crontabs'&columns=crontab_path,crontab_created_timestamp,crontab_modified_timestamp";
    setAreaByUrl(url);
}

function listCrontabs(){
    url = "/api/crontab.php?action=list";
    setAreaByUrl(url);
}

function loadCrontab (id){
    url = "/api/crontab_view.php?id="+id;
    setAreaByUrl(url);
}

function test (){
    url = "/api/test.php";
    setAreaByUrl(url);
}

function update_crons () {
    url = "/api/update.php?target=crontabs";
    setAreaByUrl(url);
}

function triggerPopup(info_to_get){
    const modal = document.querySelector('dialog');

    document.querySelector("#popup_button").addEventListener("click", () => {modal.showModal();});
}
