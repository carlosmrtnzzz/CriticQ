document.addEventListener("DOMContentLoaded", () => {
    const apiKey = "d1f1b062f5634e4fa62ab053ed6f6373";
    const url = `https://newsapi.org/v2/everything?q=videojuegos&language=es&pageSize=9&apiKey=${apiKey}`;

    fetch(url)
        .then(response => response.json())
        .then(data => {
            const newsContainer = document.getElementById("newsContainer");

            if (data.articles && data.articles.length > 0) {
                data.articles.forEach(news => {
                    const card = `
                        <div class="col">
                            <div class="card news-card">
                                <img src="${news.urlToImage || 'https://via.placeholder.com/400'}" class="card-img-top" alt="${news.title}">
                                <div class="card-body">
                                    <h5 class="card-title">${news.title}</h5>
                                    <p class="card-text">${news.description || "No hay descripción disponible."}</p>
                                    <p class="text-muted">Fuente: ${news.source.name} | ${new Date(news.publishedAt).toLocaleDateString()}</p>
                                    <a href="${news.url}" target="_blank" class="btn btn-primary">Leer más</a>
                                </div>
                            </div>
                        </div>
                    `;
                    newsContainer.innerHTML += card;
                });
            } else {
                newsContainer.innerHTML = `<div class="col-12"><p class="text-center text-danger">No se encontraron noticias.</p></div>`;
            }
        })
        .catch(error => {
            console.error("Error al obtener noticias:", error);
            const newsContainer = document.getElementById("newsContainer");
            newsContainer.innerHTML = `<div class="col-12"><p class="text-center text-danger">Error al cargar las noticias. Inténtalo de nuevo más tarde.</p></div>`;
        });
});