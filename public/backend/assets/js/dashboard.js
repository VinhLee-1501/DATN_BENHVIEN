$(function () {


    // =====================================
    // Profit
    // =====================================
    $(() => {
        if (typeof patientData === "undefined") {
            console.error('Không có dữ liệu nào')
            return;
        }
        const total_data = patientData.map((item) => item.total_patient);
        const total_months = patientData.map((item) => item.date_month);
        // console.log(typeof total_data);

        const max = Math.max(...total_data)
        console.log(max);

        function getNextNumber(num) {
            const nextNumber = Math.ceil(num / 10) * 10;
            return nextNumber % 20 === 0 ? nextNumber : nextNumber + 10;
        }
        const nextMax = getNextNumber(max);
        console.log(nextMax);
        var chart = {
            series: [
                { name: "Tổng số: ", data: total_data },
                { name: "Tháng: ", data: [] },
            ],

            chart: {
                type: "bar",
                height: 345,
                offsetX: -15,
                toolbar: { show: true },
                foreColor: "#adb0bb",
                fontFamily: 'inherit',
                sparkline: { enabled: false },
            },


            colors: ["#5D87FF", "#49BEFF"],


            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: "35%",
                    borderRadius: [6],
                    borderRadiusApplication: 'end',
                    borderRadiusWhenStacked: 'all'
                },
            },
            markers: { size: 0 },

            dataLabels: {
                enabled: false,
            },


            legend: {
                show: false,
            },


            grid: {
                borderColor: "rgba(0,0,0,0.1)",
                strokeDashArray: 3,
                xaxis: {
                    lines: {
                        show: false,
                    },
                },
            },

            xaxis: {
                type: "category",
                categories: total_months,
                labels: {
                    style: { cssClass: "grey--text lighten-2--text fill-color" },
                },
            },


            yaxis: {
                show: true,
                min: 0,
                max: nextMax,
                tickAmount: 4,
                labels: {
                    style: {
                        cssClass: "grey--text lighten-2--text fill-color",
                    },
                },
            },
            stroke: {
                show: true,
                width: 3,
                lineCap: "butt",
                colors: ["transparent"],
            },


            tooltip: { theme: "light" },

            responsive: [
                {
                    breakpoint: 600,
                    options: {
                        plotOptions: {
                            bar: {
                                borderRadius: 3,
                            }
                        },
                    }
                }
            ]


        };

        var chart = new ApexCharts(document.querySelector("#chart"), chart);
        chart.render();
    })


    // =====================================
    // Breakup
    // =====================================
    $(() => {
        if (typeof priceData === "undefined") {
            console.error('Không có dữ liệu nào')
            return;
        }
        const total_data = priceData.map((item) => item.total_price);
        const total_months = priceData.map((item) => item.data_months);
        console.log(...total_data);
        const currentMonthRevenue = total_data[2];
        const formattedRevenue = currentMonthRevenue.toLocaleString('vi-VN');
        document.querySelector('#price').innerText = formattedRevenue;

        const total_sum = total_data.reduce((acc, val) => acc + val, 0);
        const total_percentage = total_sum / 100;
        document.querySelector('#percentage').innerText = total_percentage.toLocaleString('vi-VN');
        document.querySelector('#month1').innerText = total_months[0]
        document.querySelector('#month2').innerText = total_months[1]
        var breakup = {
            color: "#adb5bd",
            series: total_data,
            labels: total_months,
            chart: {
                width: 180,
                type: "donut",
                fontFamily: "Plus Jakarta Sans', sans-serif",
                foreColor: "#adb0bb",
            },
            plotOptions: {
                pie: {
                    startAngle: 0,
                    endAngle: 360,
                    donut: {
                        size: '75%',
                    },
                },
            },
            stroke: {
                show: false,
            },

            dataLabels: {
                enabled: false,
            },

            legend: {
                show: false,
            },
            colors: ["#5D87FF", "#8DEEEE", "#9FB6CD"],

            responsive: [
                {
                    breakpoint: 991,
                    options: {
                        chart: {
                            width: 150,
                        },
                    },
                },
            ],
            tooltip: {
                theme: "dark",
                fillSeriesColor: false,
            },
        };

        var chart = new ApexCharts(document.querySelector("#breakup"), breakup);
        chart.render();
    })


    // =====================================
    // Earning
    // =====================================
    $(() => {
        if (typeof transactionsMonthData === "undefined") {
            console.error('Không có dữ liệu nào')
            return;
        }
        const total_data = transactionsMonthData.map((item) => item.total_price);
        const total_element = total_data.length;


        const total_price = total_data.reduce((acc, val) => acc + val, 0);
        document.querySelector('#totalPriceLineChart').innerText = total_price.toLocaleString('vi-VN');


        const totalPercentageMonth = total_price / total_element;
        const formatted_total_data = total_data.map(value => {
            const newValue = parseInt(value + '000');
            return newValue.toLocaleString();
        });
        document.querySelector('#percentagePriceMonthLineChart').innerText = `${totalPercentageMonth.toLocaleString('vi-VN')}%`;

        var earning = {
            chart: {
                id: "sparkline3",
                type: "area",
                height: 60,
                sparkline: {
                    enabled: true,
                },
                group: "sparklines",
                fontFamily: "Plus Jakarta Sans', sans-serif",
                foreColor: "#adb0bb",
            },
            series: [
                {
                    name: "Tổng",
                    color: "#49BEFF",
                    data: formatted_total_data,
                },
            ],
            stroke: {
                curve: "smooth",
                width: 2,
            },
            fill: {
                colors: ["#f3feff"],
                type: "solid",
                opacity: 0.05,
            },

            markers: {
                size: 0,
            },
            tooltip: {
                theme: "dark",
                fixed: {
                    enabled: true,
                    position: "right",
                },
                x: {
                    show: false,
                },
            },
        };
        new ApexCharts(document.querySelector("#earning"), earning).render();
    })
})
