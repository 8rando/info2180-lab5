document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('lookup').addEventListener('click', function(e) {
        e.preventDefault();

        let country = document.getElementById('country').value;

        let xhr = new XMLHttpRequest();
        xhr.open('GET', 'world.php?country=' + encodeURIComponent(country), true);
        xhr.onload = function() {
            if (xhr.status == 200) {
                document.getElementById('result').innerHTML = xhr.responseText;
            } else {
                console.error(xhr.statusText);
            }
        };
        xhr.onerror = function() {
            console.error(xhr.statusText);
        };
        xhr.send();
    });
});
