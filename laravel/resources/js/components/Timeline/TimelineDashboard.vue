<template>
    <div>
        <timeline-legend/>
        <timeline :periods="timeline"></timeline>
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

        props: ['periods'],

        data: function() {
            return {
                timeline: this.periods
            }
        }
    }
</script>
