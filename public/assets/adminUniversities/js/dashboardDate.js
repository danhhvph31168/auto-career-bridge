document.addEventListener("DOMContentLoaded", function () {
    flatpickr(".dash-filter-picker", {
        dateFormat: "d/m/Y",
        defaultDate: new Date(),
        mode: "range",
        locale: "vn",
        onChange: function (selectedDates, dateStr, instance) {
            if (selectedDates.length === 2) {
                const startDate = selectedDates[0];
                const endDate = selectedDates[1];

                const startDateFormatted = instance.formatDate(
                    startDate,
                    "Y-m-d"
                );
                const endDateFormatted = instance.formatDate(endDate, "Y-m-d");

                console.log(startDateFormatted, "-", endDateFormatted);

                fetch("/enterprise/dateDashboard", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute("content"),
                    },
                    body: JSON.stringify({
                        startDateFormatted,
                        endDateFormatted,
                    }),
                })
                    .then((response) => response.json())
                    .then((data) => {
                        const elements = [
                            {
                                id: "#countJob",
                                key: "countJob",
                            },
                            {
                                id: "#countCooperate",
                                key: "countCooperate",
                            },
                            {
                                id: "#countApply",
                                key: "countApply",
                            },
                            {
                                id: "#countWorkshop",
                                key: "countWorkshop",
                            },
                        ];

                        elements.forEach(({ id, key }) => {
                            const element = document.querySelector(id);
                            if (element) {
                                element.setAttribute("data-target", data[key]);
                                element.textContent = data[key];
                            }
                        });
                    })
                    .catch((error) => {
                        console.error("Error:", error);
                    });
            }
        },
    });
});
