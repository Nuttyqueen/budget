import "./bootstrap";
import Chart from "chart.js/auto";

var ctx = document.getElementById("ageChart").getContext("2d");
var ageChart = new Chart(ctx, {
    type: "bar",
    data: {
        labels: [
            /* Labels for different age groups */
        ],
        datasets: [
            {
                label: "# of Members",
                data: [
                    /* Data for each age group */
                ],
                backgroundColor: [
                    /* Colors for each bar */
                ],
            },
        ],
    },
    options: {
        // options here
    },
});
