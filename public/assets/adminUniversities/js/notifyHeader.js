document.addEventListener("DOMContentLoaded", function () {
    function loadNotifications() {
        fetch("/admin/notifications/header", {
            method: "GET",
            headers: {
                "X-Requested-With": "XMLHttpRequest",
            },
        })
            .then((response) => response.json())
            .then((data) => {
                const badgeElement = document.getElementById("unread-badge");
                badgeElement.innerHTML = `${data.countUnreadHeader} <span class="visually-hidden">unread messages</span>`;

                const spanElement = document.querySelector(
                    ".badge.bg-light.text-body.fs-13"
                );
                spanElement.innerHTML = `${data.countUnreadHeader} New`;

                const linkElement =
                    document.getElementById("all-noti-tab-link");
                linkElement.innerHTML = `All (${data.countUnreadHeader})`;

                const container = document.getElementById("all-noti-tab");

                container.innerHTML = data.listNotify;
            })
            .catch((error) =>
                console.error("Error loading notifications:", error)
            );
    }

    loadNotifications();

    setInterval(loadNotifications, 30000);
});

/**
 * process delete but notice when checkbox is selected
 * @return [type]
 */
function del() {
    const checkboxes = document.querySelectorAll(".form-check-input:checked");

    const checkedValues = Array.from(checkboxes).map(
        (checkbox) => checkbox.value
    );

    const result = checkedValues.map((value) => {
        return !isNaN(value) ? Number(value) : value;
    });

    const ids = result.filter((value) => typeof value === "number");

    const queryString = new URLSearchParams({ ids: ids.join(",") }).toString();

    fetch(`/admin/notifications/delete-notifications?${queryString}`, {
        method: "GET",
    })
        .then((response) => response.json())
        .then((data) => {

            if (data.success) {
                checkboxes.forEach((checkbox) => {
                    const notificationItem =
                        checkbox.closest(".notification-item");
                    if (notificationItem) {
                        notificationItem.remove();
                    }
                });
            }

            console.log("Success:", data);
        })
        .catch((error) => {
            console.log("Error:", error);
        });
}
// del();
