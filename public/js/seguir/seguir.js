window.onload = async function () {
    const btn = document.getElementById("followButton");

    if (!btn) {
        console.error("No se encontró el botón de seguir.");
        return;
    }

    let username = btn.getAttribute("data-username");

    try {
        let response = await fetch(`/verificar-seguimiento/${username}`);
        let data = await response.json();

        if (data.following) {
            btn.innerText = "Siguiendo";
            btn.classList.remove("btn-primary");
            btn.classList.add("btn-success");
        }
    } catch (error) {
        console.error("Error al verificar estado de seguimiento:", error);
    }

    btn.addEventListener("click", async function () {
        if (btn.innerText === "Seguir") {
            await toggleFollow(btn, username);
        } else {
            showConfirmationModal(username);
        }
    });
};

async function toggleFollow(btn, username) {
    try {
        let response = await fetch("/seguir", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
            },
            body: JSON.stringify({ username }),
        });

        let data = await response.json();

        if (data.following) {
            btn.innerText = "Siguiendo";
            btn.classList.remove("btn-primary");
            btn.classList.add("btn-success");
            showNotification(`Has comenzado a seguir a ${username}`, "success");

        } else {
            btn.innerText = "Seguir";
            btn.classList.remove("btn-success");
            btn.classList.add("btn-primary");
            showNotification(`Has dejado de seguir a ${username}`, "info");
        }

        document.getElementById("seguidoresCount").innerText = data.seguidores;
    } catch (error) {
        console.error("Error al seguir/deseguir:", error);
        showNotification("Hubo un error, intenta nuevamente", "error");
    }
}

function showConfirmationModal(username) {
    const modal = document.getElementById("confirmationModal");
    const confirmButton = document.getElementById("confirmUnfollow");

    $(modal).modal('show');

    confirmButton.onclick = async function () {
        await toggleFollow(document.getElementById("followButton"), username);
        $(modal).modal('hide');
    };
}

function showNotification(message, type) {
    let notificationContainer = document.getElementById("notification-container");

    let notification = document.createElement("div");
    notification.classList.add("notification", type);
    notification.innerHTML = `
        <div class="notification-content">
            <strong>${message}</strong>
            <span class="close-btn" onclick="this.parentElement.parentElement.remove()">×</span>
        </div>
    `;

    notificationContainer.appendChild(notification);

    setTimeout(() => {
        notification.remove();
    }, 1000);
}
