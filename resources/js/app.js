import './bootstrap'
import ApexCharts from 'apexcharts'
import Alpine from 'alpinejs'

window.Alpine = Alpine
window.ApexCharts = ApexCharts

window.chartComponent = function (type, labels, series) {
    return {
        chart: null,

        init () {
            if (this.chart) {
                this.chart.destroy()
            }

            let options = {
                chart: {
                    type: type,
                    height: 320,
                    toolbar: { show: false }
                },
                legend: {
                    position: 'bottom'
                },
                dataLabels: {
                    enabled: true
                }
            }

            // 👉 Pie & Donut
            if (type === 'pie' || type === 'donut') {
                options.labels = labels
                options.series = series
            }

            // 👉 Bar
            if (type === 'bar') {
                options.series = [
                    {
                        name: 'Total',
                        data: series
                    }
                ]

                options.xaxis = {
                    categories: labels
                }
            }

            this.chart = new ApexCharts(
                this.$el.querySelector('[x-ref="chart"]'),
                options
            )

            this.chart.render()
        }
    }
}

Alpine.start()
