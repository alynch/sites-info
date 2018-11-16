<template>
    <div>
        <div class="range-box" style="display: none">
            <span v-for="month in months" class="calendar">{{ month }}</span>
        </div>

        <div class="flex-row" v-for="period in timeline">
            <datepicker
                :id="period.id"
                :months="months"
                label="From"
                sufix="start"
                :month="period.start_month"
                :day="period.start_day">
            </datepicker>

            <datepicker
                :id="period.id"
                :months="months"
                label="To"
                sufix="end"
                :month="period.end_month"
                :day="period.end_day">
            </datepicker>
        </div>

        <a href="" @click.prevent="addPeriod">Add period</a>
    </div>
</template>

<script>
    export default {

        props: ['periods'],

        data: function() {
            return {
                timeline: this.periods,
                months: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            }
        },

        methods: {
            addPeriod() {
                this.timeline.push('');
            }
        }
    }
</script>

<style scoped>
.flex-row {
    display: flex;
    padding: 5px;
}

.viewport {
    width: 8.333%;
    border-left: 1px solid #ccc;
    text-align: center
}
</style>
