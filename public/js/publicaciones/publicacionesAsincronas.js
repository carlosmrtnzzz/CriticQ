document.addEventListener('DOMContentLoaded', function () {
    let currentPage = 1;
    let isLoading = false;
    let hasMorePages = true;

    function loadMorePosts() {
        if (isLoading || !hasMorePages) return;

        isLoading = true;
        const loadingElement = document.getElementById('loading');
        loadingElement.classList.remove('d-none');

        fetch(`${window.location.pathname}?page=${currentPage + 1}&ajax=true`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.html && data.html.trim() !== '') {
                    const postsContainer = document.getElementById('posts-container');
                    postsContainer.insertAdjacentHTML('beforeend', data.html);
                    currentPage = data.current_page;
                    hasMorePages = currentPage < data.last_page;
                    const event = new CustomEvent('nuevos-posts-cargados');
                    document.dispatchEvent(event);
                } else {
                    hasMorePages = false;
                }

                if (!hasMorePages) {
                    loadingElement.innerHTML = '<p class="text-center">No hay más publicaciones</p>';
                }
            })
            .catch(error => {
                hasMorePages = false;
                console.error('Error loading posts:', error);
            })
            .finally(() => {
                isLoading = false;
                loadingElement.classList.add('d-none');
            });
    }

    window.addEventListener('scroll', function () {
        if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight - 100) {
            loadMorePosts();
        }
    });

    if (window.innerHeight >= document.body.offsetHeight) {
        loadMorePosts();
    }

    document.addEventListener('submit', function (e) {
        if (e.target.classList.contains('like-form')) {
            e.preventDefault();
            const form = e.target;
            const url = form.action;
            const button = form.querySelector('.like-button');
            const likesCount = button.querySelector('.likes-count');
            const postElement = form.closest('.post-item');
            const vistasElement = postElement.querySelector('.vistas-count');

            fetch(url, {
                method: 'POST',
                body: new FormData(form),
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'liked') {
                        likesCount.textContent = data.likes_count;
                        button.innerHTML = `<i class="bi bi-heart-fill"></i> <span class="likes-count">${data.likes_count}</span>`;
                    } else {
                        likesCount.textContent = data.likes_count;
                        button.innerHTML = `<i class="bi bi-heart"></i> <span class="likes-count">${data.likes_count}</span>`;
                    }
                    vistasElement.innerHTML = `<i class="bi bi-graph-up"></i> ${data.vistas}`;
                })
                .catch(error => {
                    console.error('Error liking post:', error);
                });
        }
    });
});
