document.addEventListener('DOMContentLoaded', function () {
    const postsContainer = document.getElementById('posts-container');

    
    fetch('/proxy/giveaways')
        .then(response => response.json())
        .then(data => {
            console.log("Datos recibidos de la API:", data); 

            
            function insertarRegalos() {
                const postItems = postsContainer.querySelectorAll('.post-item');
                console.log("Contenedores de posts encontrados:", postItems.length);

                postItems.forEach((post, index) => {
            
                    const giftId = `gift-${index + 1}`;

                    if ((index + 1) % 5 === 0 && !document.getElementById(giftId)) { 
                        const giveaway = data[index % data.length]; 
                        const giftContent = document.createElement('div');
                        giftContent.classList.add('gift-card');
                        giftContent.id = giftId;  
                        giftContent.innerHTML = `
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">¡Regalo Especial!</h5>
                                    <img src="${giveaway.image}" class="card-img-top" alt="${giveaway.title}">
                                    <p>${giveaway.title}</p>
                                    <a href="${giveaway.open_giveaway_url}" target="_blank" class="btn btn-success">Participar</a>
                                </div>
                            </div>
                        `;
                        post.insertAdjacentElement('afterend', giftContent); 
                    }
                });
            }
            insertarRegalos();

            document.addEventListener('nuevos-posts-cargados', function () {
                insertarRegalos();
            });
        })
        .catch(error => {
            console.error('Error al obtener giveaways:', error);
        });
});
