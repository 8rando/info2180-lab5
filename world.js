document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('lookup_country').addEventListener('click', function(e) {
        e.preventDefault();
        makeRequest('country');
    });
    
    document.getElementById('lookup_cities').addEventListener('click', function(e) {
        e.preventDefault();
        makeRequest('cities');
    });
});

function makeRequest(type) {
    let country = document.getElementById('country').value;
    let query = 'country=' + encodeURIComponent(country);
    if (type === 'cities') {
        query += '&lookup=cities';
    }
    
    let xhr = new XMLHttpRequest();
    xhr.open('GET', 'world.php?' + query, true);
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
}
