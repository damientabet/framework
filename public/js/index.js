'use script';

document.addEventListener('DOMContentLoaded', function() {
    var input = document.getElementById('file');

    if (input != null) {
        input.addEventListener('change', function () {
            document.getElementById('filename').innerHTML = '<i class="fas fa-upload"></i> ' + this.files[0].name;
        });
    }

    if (document.location.pathname != "/") {
        document.getElementById('indexImg').style.display = 'none';
    }

    var desc = document.getElementById('articleDescription');
    if (desc != null) {
    document.getElementById('length').append(desc.textLength);
        desc.addEventListener('keyup', function () {
            document.getElementById('length').innerHTML = '';
            document.getElementById('length').append(desc.textLength);
        });
    }
});