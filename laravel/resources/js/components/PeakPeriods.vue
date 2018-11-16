<template>
    <div>
        <div class="range-box" style="display: flex">
            <span v-for="month in months" class="calendar">{{ month }}</span>
        </div>

        <div class="range-box">
            <div v-for="period in timeline" class="range"
                :style="'left:' + period.range.start + 'px; width:' + period.range.width + 'px;'">
            </div>
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
                let p = {
                    range: []
                };
                this.timeline.push(p);
            }
        }
    }
</script>

<style scoped>
.flex-row {
    display: flex;
    padding: 5px;
}

.range-box {
    margin: 1em auto;
}

.calendar {
    width: 8.333%;
    border-left: 1px solid #ccc;
    text-align: center
}
</style>
