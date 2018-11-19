<template>
    <div class="dashboard">
        <timeline-legend
            :months="months"/>

        <div class="range-box">
            <timeline :periods="timeline"></timeline>
        </div>

        <div class="flex-row" v-for="period in timeline" :key="period.id">
            <date-range-picker
                :period="period"
                :months="months"
                @delete="removePeriod(period)"
                @update="updatePeriod"
                >
            </date-range-picker>
        </div>

        <a href="" @click.prevent="addPeriod">Add period</a>
    </div>
</template>

<script>
    import TimelineLegend  from './TimelineLegend'
    import Timeline  from './Timeline'
    import DateRangePicker  from './DateRangePicker'

    export default {
        components: {
            TimelineLegend,
            Timeline,
            DateRangePicker,
        },

        props: ['periods'],

        data: function() {
            return {
                timeline: this.periods,
                months: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            }
        },

        methods: {
            addPeriod() {
                let p = {
                    range: []
                };
                this.timeline.push(p);
            },
            removePeriod: function (period) {
                this.periods.splice(this.periods.indexOf(period), 1)
            },
            updatePeriod: function (item) {
                let period = this.periods.find(period => period.id == item.period);

                if (item.suffix == 'start') { 
                    period.start_day = item.day;
                    period.start_month = item.month;
                }
                if (item.suffix == 'end') { 
                    period.end_day = item.day;
                    period.end_month = item.month;
                }
            }
        }
    }
</script>

<style scoped>
.dashboard {
    margin: 20px auto;
    width: 600px;
}
</style>
