"use strict";

function setActive() {
    var liObj = document.getElementById("accordionSidebar").getElementsByTagName("li");
    for(var i = 0; i < liObj.length; i++) {
        var aObj = liObj[i].getElementsByTagName("a")[0];
        var linkObj = liObj[i];
        if(document.location.href === aObj.href) {
            linkObj.classList.add("active");
        }
    }
}

document.addEventListener("DOMContentLoaded", function() {
    setActive();
    var input = document.getElementById("file");

    if (input !== null) {
        input.addEventListener("change", function () {
            document.getElementById("filename").innerHTML = '<i class="fas fa-upload"></i> ' + this.files[0].name;
        });
    }

    var img = document.getElementById("indexImg");
    if (document.location.pathname !== "/" && img !== null) {
        img.classList.add("d-none");
    }

    var desc = document.getElementById("articleDescription");
    if (desc !== null) {
    document.getElementById("length").append(desc.textLength);
        desc.addEventListener("keyup", function () {
            document.getElementById("length").innerHTML = "";
            document.getElementById("length").append(desc.textLength);
        });
    }

    var test = document.getElementById("test");
    if (test !== null) {
        test.addEventListener("click", function(){
            var form = document.getElementById("formAdmin");
            form.classList.remove("d-none");
        });
    }

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
});