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
        .then(response => {
            if (!response.ok) {
                throw new Error('Erreur réseau : ' + response.statusText);
            }
            return response.json();
        })
        .then(data => {
            loadingDiv.style.display = 'none';
            if (data.status === 'success') {
                responseDiv.innerHTML = data.data;
                console.log('Résultat de la prédiction :', data.data);
            } else {
                responseDiv.innerHTML = `<p>Erreur : ${data.message}</p>`;
                console.error('Erreur du serveur :', data.message);
            }
        })
        .catch(error => {
            loadingDiv.style.display = 'none';
            responseDiv.innerHTML = `<p>Erreur lors de la requête.</p>`;
            console.error('Erreur lors de la requête AJAX :', error);
        });
});
