<template>
    <div>
        <div style="display: flex">
            <span class="label"></span>
            <timeline-legend :months="months"/>
        </div>

        <div v-for="application in applications" style="display: flex">
            <span class="label"> {{ application.name }}</span>
            <div class="range-box">
                <timeline :periods="application.timeline"></timeline>
            </div>
        </div>
    </div>
</template>

<script>
    import TimelineLegend  from './TimelineLegend'
    import Timeline  from './Timeline'

    export default {
        components: {
            TimelineLegend,
            Timeline
        },

        props: ['applications'],

        data: function() {
            return {
                timeline: this.periods,
                months: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            }
        }
    }
</script>

<style scoped>
.label {
    width: 10em;
}
</style>
