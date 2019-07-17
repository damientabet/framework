"use strict";

function setActive() {
    var liObj = document.getElementById("accordionSidebar").getElementsByTagName("li");
    for(var i = 0; i < liObj.length; i++) {
        var aObj = liObj[parseInt(i, 10)].getElementsByTagName("a")[0];
        var linkObj = liObj[parseInt(i, 10)];
        if(document.location.href === aObj.href) {
            linkObj.classList.add("active");
        }
    }
}

function displayFilename() {
    var input = document.getElementById("file");

    if (input !== null) {
        input.addEventListener("change", function () {
            var filename = this.files[0].name;
            document.getElementById("text").innerText = "";
            document.getElementById("filename").appendChild(document.createTextNode(filename));
        });
    }
}

function displayImgSlideHome() {
    var img = document.getElementById("indexImg");
    if (document.location.pathname !== "/" && img !== null) {
        img.classList.add("d-none");
    }
}

function lengthCounter() {
    var desc = document.getElementById("articleDescription");
    if (desc !== null) {
        document.getElementById("length").append(desc.textLength);
        desc.addEventListener("keyup", function () {
            document.getElementById("length").innerHTML = "";
            document.getElementById("length").append(desc.textLength);
        });
    }
}

function displayAdminUserForm() {
    var test = document.getElementById("test");
    if (test !== null) {
        test.addEventListener("click", function(){
            var form = document.getElementById("formAdmin");
            form.classList.remove("d-none");
        });
    }
}

function displayAdminArticleForm() {
    var editArticleContent = document.getElementById("editArticleContent");
    if (editArticleContent !== null) {
        editArticleContent.addEventListener("click", function(){
            var formArticleContent = document.getElementById("formArticleContent");
            formArticleContent.classList.remove("d-none");
            var articleContent = document.getElementById("articleContent");
            articleContent.classList.add("d-none");
            var formArticleDesc = document.getElementById("formArticleDesc");
            formArticleDesc.classList.remove("d-none");
            var articleDesc = document.getElementById("articleDesc");
            articleDesc.classList.add("d-none");
            var formArticleTitle = document.getElementById("formArticleTitle");
            formArticleTitle.classList.remove("d-none");
            var articleTitle = document.getElementById("articleTitle");
            articleTitle.classList.add("d-none");
        });
    }
}

window.addEventListener("DOMContentLoaded", () => {
    setActive();
    displayFilename();
    displayImgSlideHome();
    lengthCounter();
    displayAdminUserForm();
    displayAdminArticleForm();
});