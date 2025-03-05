$(document).ready(function () {
    $('.like-form').on('submit', function (e) {
        e.preventDefault();
        let form = $(this);
        let url = form.attr('action');
        let button = form.find('.like-button');
        let likesCount = button.find('.likes-count');

        $.ajax({
            type: 'POST',
            url: url,
            data: form.serialize(),
            success: function (response) {
                if (response.status === 'liked') {
                    button.html('<i class="bi bi-heart-fill"></i> <span class="likes-count">' + response.likes_count + '</span>');
                } else {
                    button.html('<i class="bi bi-heart"></i> <span class="likes-count">' + response.likes_count + '</span>');
                }
            }
        });
    });

    $('.delete-form').on('submit', function (e) {
        let form = this;
        e.preventDefault();
        if (confirm('¿Estás seguro de que deseas eliminar este post?')) {
            form.submit();
        }
    });

    $('.reply-btn').on('click', function () {
        const commentId = $(this).data('comment-id');
        const username = $(this).data('username');

        $('#comentario_padre_id').val(commentId);
        $('#parent-username').text(username);
        $('#replying-to').show();

        $('html, body').animate({
            scrollTop: $("#comment-form").offset().top - 100
        }, 500);

        $('textarea[name="contenido"]').focus();
    });

    $('#cancel-reply').on('click', function () {
        $('#comentario_padre_id').val('');
        $('#replying-to').hide();
    });

    $('#comment-form').on('submit', function (e) {
        e.preventDefault();
        let form = $(this);
        let url = form.attr('action');

        $.ajax({
            type: 'POST',
            url: url,
            data: form.serialize(),
            success: function (response) {
                if (response.success) {
                    $('textarea[name="contenido"]').val('');
                    $('#comentario_padre_id').val('');
                    $('#replying-to').hide();

                    location.reload();
                }
            }
        });
    });

    $('.delete-comment-form').on('submit', function (e) {
        e.preventDefault();
        if (confirm('¿Estás seguro de que deseas eliminar este comentario?')) {
            this.submit();
        }
    });
});