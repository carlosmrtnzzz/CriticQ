document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchInput');
    const resultList = document.getElementById('resultList');

    searchInput.addEventListener('keyup', function () {
        let query = this.value;
        if (query.length > 1) {
            fetch(`/buscar?query=${query}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
                .then(response => response.json())
                .then(data => {
                    resultList.innerHTML = '';
                    if (data.length > 0) {
                        data.forEach(user => {
                            let li = document.createElement('li');
                            li.classList.add('list-group-item');
                            let link = document.createElement('a');
                            link.href = `/usuario/${user.username}`;
                            link.textContent = user.username;
                            link.classList.add('text-decoration-none', 'text-dark');

                            li.appendChild(link);
                            resultList.appendChild(li);
                        });
                    } else {
                        resultList.innerHTML = '<li class="list-group-item">No se encontraron usuarios.</li>';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    resultList.innerHTML = '<li class="list-group-item">Error al buscar usuarios.</li>';
                });
        } else {
            resultList.innerHTML = '';
        }
    });
});