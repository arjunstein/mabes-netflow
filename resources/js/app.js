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
        refreshIntervalMs: 5000,
        autoRefreshTimer: null,
        isFetching: false,
        windowSize: 0,
        visibilityHandler: null,
        fastFollowTimer: null,

        init () {
            if (this.chart) {
                this.chart.destroy()
            }

            let options = {
                chart: {
                    type: type,
                    height: 320,
                    toolbar: { show: false },
                    animations: {
                        enabled: true,
                        easing: 'linear',
                        speed: 350,
                        dynamicAnimation: {
                            enabled: true,
                            speed: 350
                        }
                    }
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

            // 👉 LINE
            if (this.type === 'line') {
                options.series = this.sanitizeSeriesData(this.series, this.labels.length)

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

            this.windowSize = this.resolveWindowSize()
            this.setupWatchers()
            this.setupAutoRefresh()
        },

        setupWatchers () {
            this.$watch('period', () => {
                this.windowSize = this.resolveWindowSize()
                this.fetchData({ incremental: false })
                this.setupAutoRefresh()
            })

            this.visibilityHandler = () => {
                if (document.hidden) {
                    this.stopAutoRefresh()
                    return
                }

                this.setupAutoRefresh()
                this.fetchData({ incremental: true })
            }

            document.addEventListener('visibilitychange', this.visibilityHandler)
        },

        setupAutoRefresh () {
            this.stopAutoRefresh()

            if (!this.endpoint || this.period !== '1h') return

            this.autoRefreshTimer = window.setInterval(() => {
                this.fetchData({ incremental: true })
            }, this.refreshIntervalMs)
        },

        stopAutoRefresh () {
            if (!this.autoRefreshTimer) return
            window.clearInterval(this.autoRefreshTimer)
            this.autoRefreshTimer = null
        },

        stopFastFollowRefresh () {
            if (!this.fastFollowTimer) return
            window.clearTimeout(this.fastFollowTimer)
            this.fastFollowTimer = null
        },

        scheduleFastFollowRefresh () {
            if (this.fastFollowTimer || this.isFetching || this.period !== '1h') return

            this.fastFollowTimer = window.setTimeout(() => {
                this.fastFollowTimer = null
                this.fetchData({ incremental: true })
            }, 2000)
        },

        resolveWindowSize () {
            return this.labels.length > 0 ? this.labels.length : 60
        },

        toFiniteNumber (value, fallback = 0) {
            if (Number.isFinite(value)) return value

            if (typeof value === 'string') {
                const normalized = value.replace(/,/g, '').trim()
                const parsed = Number(normalized)
                return Number.isFinite(parsed) ? parsed : fallback
            }

            const parsed = Number(value)
            return Number.isFinite(parsed) ? parsed : fallback
        },

        sanitizeSeriesData (series = [], expectedLength = null) {
            return series.map((item) => {
                const data = Array.isArray(item?.data) ? item.data : []
                const normalizedData = data.map((value) => this.toFiniteNumber(value, 0))

                if (!Number.isInteger(expectedLength)) {
                    return {
                        ...item,
                        data: normalizedData
                    }
                }

                const filledData = Array.from({ length: expectedLength }, (_, index) =>
                    this.toFiniteNumber(normalizedData[index], 0)
                )

                return {
                    ...item,
                    data: filledData
                }
            })
        },

        normalizeOneHourData (payload) {
            const categories = payload?.categories ?? []
            const series = this.sanitizeSeriesData(payload?.series ?? [], categories.length)

            if (this.period !== '1h' || categories.length < 13) {
                return {
                    categories,
                    series
                }
            }

            // Show only stable slots: take 12 points before the newest slot.
            const stableEndIndex = categories.length - 1
            const stableStartIndex = Math.max(stableEndIndex - 12, 0)
            const normalizedCategories = categories.slice(stableStartIndex, stableEndIndex)

            const normalizedSeries = series.map((item) => ({
                ...item,
                data: (item?.data ?? []).slice(stableStartIndex, stableEndIndex)
            }))

            return {
                categories: normalizedCategories,
                series: normalizedSeries
            }
        },

        applyChartUpdate ({ animate = true } = {}) {
            if (!this.chart) return

            const sanitizedSeries = this.sanitizeSeriesData(this.series, this.labels.length)
            this.series = sanitizedSeries

            this.chart.updateOptions(
                {
                    xaxis: { categories: this.labels },
                    series: sanitizedSeries
                },
                false,
                animate,
                false
            )
        },

        applySlidingWindow (incoming) {
            let incomingLabels = incoming?.categories ?? []
            let incomingSeries = incoming?.series ?? []

            if (incomingLabels.length === 0 || incomingSeries.length === 0) return

            // Avoid rendering a brand-new trailing bucket when backend still returns all 0.
            const latestLabel = incomingLabels[incomingLabels.length - 1]
            const latestIsNew = !this.labels.includes(latestLabel)
            const latestAllZero = incomingSeries.every((item) => {
                const latestValue = item?.data?.[item.data.length - 1] ?? 0
                return Number(latestValue) === 0
            })

            if (latestIsNew && latestAllZero) {
                incomingLabels = incomingLabels.slice(0, -1)
                incomingSeries = incomingSeries.map((item) => ({
                    ...item,
                    data: (item.data ?? []).slice(0, -1)
                }))
                this.scheduleFastFollowRefresh()
            }

            if (incomingLabels.length === 0 || incomingSeries.length === 0) return

            const maxPoints = this.windowSize || this.resolveWindowSize()
            const startIndex = Math.max(incomingLabels.length - maxPoints, 0)
            const nextLabels = incomingLabels.slice(startIndex)

            const previousSeriesMap = new Map(this.series.map((item) => [item.name, item.data ?? []]))
            const previousLabelIndex = new Map(this.labels.map((label, index) => [label, index]))
            const unstableFromIndex = Math.max(nextLabels.length - 2, 0)

            const nextSeries = incomingSeries.map((item) => {
                const prevData = previousSeriesMap.get(item.name) ?? []
                const incomingData = (item.data ?? []).slice(startIndex, startIndex + nextLabels.length)
                const lastStableValue = Number(
                    [...prevData].reverse().find((val) => Number(val) > 0) ?? 0
                )

                const reconciled = incomingData.map((value, index) => {
                    if (index < unstableFromIndex) return this.toFiniteNumber(value, 0)

                    const label = nextLabels[index]
                    const prevIndex = previousLabelIndex.get(label)
                    const nextValue = Number(value ?? 0)

                    if (prevIndex === undefined) {
                        // For a brand-new bucket, avoid flashing zero before ingest completes.
                        if (nextValue === 0 && lastStableValue > 0) {
                            this.scheduleFastFollowRefresh()
                            return lastStableValue
                        }

                        return this.toFiniteNumber(value, 0)
                    }

                    const prevValue = Number(prevData[prevIndex] ?? 0)

                    // Hold previous non-zero value on tail buckets to hide ingest lag.
                    if (prevValue > 0 && nextValue === 0) {
                        this.scheduleFastFollowRefresh()
                        return prevValue
                    }

                    return this.toFiniteNumber(value, 0)
                })

                return {
                    ...item,
                    data: reconciled.map((value) => this.toFiniteNumber(value, 0))
                }
            })

            this.labels = nextLabels
            this.series = nextSeries
            this.applyChartUpdate({ animate: true })
        },

        async fetchData ({ incremental = false } = {}) {
            if (!this.endpoint) return
            if (this.isFetching) return

            this.isFetching = true

            try {
                const response = await fetch(
                    `${this.endpoint}?period=${this.period}&_=${Date.now()}`,
                    {
                        cache: 'no-store',
                        headers: {
                            Accept: 'application/json'
                        }
                    }
                )

                if (!response.ok) {
                    throw new Error(`Chart refresh failed (${response.status})`)
                }

                const data = await response.json()
                const normalizedData = this.normalizeOneHourData(data)

                if (incremental && this.period === '1h' && this.type === 'line') {
                    this.applySlidingWindow(normalizedData)
                    return
                }

                this.labels = normalizedData.categories ?? []
                this.series = normalizedData.series ?? []
                this.windowSize = this.resolveWindowSize()
                this.applyChartUpdate({ animate: true })
            } catch (error) {
                console.error(error)
            } finally {
                this.isFetching = false
            }
        },

        destroy () {
            this.stopAutoRefresh()
            this.stopFastFollowRefresh()

            if (this.visibilityHandler) {
                document.removeEventListener('visibilitychange', this.visibilityHandler)
            }
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
