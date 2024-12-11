document.getElementById('upload-button').addEventListener('click', function () {
    const loadingDiv = document.getElementById('loading');
    const responseDiv = document.getElementById('response');
    loadingDiv.style.display = 'block';
    responseDiv.innerHTML = '';

    const form = document.getElementById('upload-form');
    const formData = new FormData(form);

    fetch('/ajax/upload', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            loadingDiv.style.display = 'none';
            if (data.status === 'success') {
                responseDiv.innerHTML = `<p>Upload réussi !</p>`;
            } else {
                responseDiv.innerHTML = `<p>Erreur</p>`;
            }
        })
        .catch(error => {
            loadingDiv.style.display = 'none';
            console.error('Erreur lors de la requête AJAX :', error);
        });
});
