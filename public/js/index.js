var input = document.getElementById('file');

if (input != null) {
    input.addEventListener('change', function () {
        document.getElementById('filename').innerHTML = '<i class="fas fa-upload"></i> ' + this.files[0].name;
    });
}

if (document.location.pathname != "/") {
    document.getElementById('indexImg').style.display = 'none';
}
