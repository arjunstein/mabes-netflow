import './bootstrap'
import ApexCharts from 'apexcharts'
import Alpine from 'alpinejs'

window.Alpine = Alpine
window.ApexCharts = ApexCharts

window.chartComponent = function (type, labels, series, endpoint = null) {
    return {
        chart: null,
        type: type,
        labels: labels,
        series: series,
        title: null,
        endpoint: endpoint,
        period: '1h',

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

                options.yaxis = {
                    labels: {
                        formatter: function (value) {
                            if (value >= 1000000000) {
                                return (
                                    (value / 1000000000)
                                        .toFixed(1)
                                        .replace(/\.0$/, '') + 'B'
                                )
                            }
                            if (value >= 1000000) {
                                return (
                                    (value / 1000000)
                                        .toFixed(1)
                                        .replace(/\.0$/, '') + 'M'
                                )
                            }
                            if (value >= 1000) {
                                return (
                                    (value / 1000)
                                        .toFixed(1)
                                        .replace(/\.0$/, '') + 'K'
                                )
                            }
                            return value
                        }
                    }
                }

                options.tooltip = {
                    y: {
                        formatter: function (value) {
                            return value.toLocaleString()
                        }
                    }
                }

                options.dataLabels = {
                    enabled: false
                }
            }

            // 👉 LINE (NEW 🔥)
            if (this.type === 'line') {
                options.series = this.series

                options.xaxis = {
                    categories: this.labels
                }

                options.stroke = {
                    curve: 'smooth',
                    width: 2
                }

                options.dataLabels = {
                    enabled: false
                }

                options.tooltip = {
                    shared: true,
                    intersect: false
                }

                options.yaxis = {
                    labels: {
                        formatter: function (value) {
                            if (value >= 1000000000) {
                                return (
                                    (value / 1000000000)
                                        .toFixed(1)
                                        .replace(/\.0$/, '') + 'B'
                                )
                            }
                            if (value >= 1000000) {
                                return (
                                    (value / 1000000)
                                        .toFixed(1)
                                        .replace(/\.0$/, '') + 'M'
                                )
                            }
                            if (value >= 10000) {
                                return (
                                    (value / 1000)
                                        .toFixed(1)
                                        .replace(/\.0$/, '') + 'K'
                                )
                            }
                            return value
                        }
                    }
                }
            }

            this.chart = new ApexCharts(
                this.$el.querySelector('[x-ref="chart"]'),
                options
            )

            this.chart.render()
        },

        async fetchData () {
            if (!this.endpoint) return

            const response = await fetch(
                `${this.endpoint}?period=${this.period}`
            )

            const data = await response.json()

            this.labels = data.categories
            this.series = data.series

            this.chart.updateOptions({
                xaxis: { categories: this.labels },
                series: this.series
            })
        },

        // ==============================
        // ✅ EXPORT CSV (BACKEND)
        // ==============================
        async downloadCSV () {
            const response = await fetch('/chart/export', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute('content')
                },
                body: JSON.stringify({
                    type: 'csv',
                    title: this.title,
                    labels: this.labels,
                    series: this.series
                })
            })

            const blob = await response.blob()
            this.downloadBlob(blob, this.slug(this.title) + '.csv')
        },

        // ==============================
        // ✅ EXPORT PNG (BACKEND)
        // ==============================
        async downloadPNG () {
            const { imgURI } = await this.chart.dataURI()

            const response = await fetch('/chart/export', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document
                        .querySelector('meta[name="csrf-token"]')
                        .getAttribute('content')
                },
                body: JSON.stringify({
                    type: 'png',
                    title: this.title,
                    image: imgURI
                })
            })

            const blob = await response.blob()
            this.downloadBlob(blob, this.slug(this.title) + '.png')
        },

        downloadBlob (blob, filename) {
            const url = window.URL.createObjectURL(blob)
            const link = document.createElement('a')
            link.href = url
            link.download = filename
            link.click()
            window.URL.revokeObjectURL(url)
        },

        slug (text) {
            return text
                ? text
                      .toLowerCase()
                      .replace(/\s+/g, '-')
                      .replace(/[^\w-]+/g, '')
                : 'chart'
        }
    }
}

Alpine.start()
