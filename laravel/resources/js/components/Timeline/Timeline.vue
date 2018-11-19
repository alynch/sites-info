<template>
<div class="timeline">
    <div v-for="period in currperiods" :key="period.id">
        <timeline-slot
            :period="period">
        </timeline-slot>
    </div>
</div>
</template>

<script>
    import TimelineSlot  from './TimelineSlot'

    export default {
        components: {
            TimelineSlot
        },

        props: ['periods'],

        data: function() {
            return {
                currperiods: this.periods
            }
        }
    }
</script>

<style scoped>
.timeline {
    position: relative;
    height: 20px;
    margin: 0 auto;
    border-radius: 3px;
    width: 600px;
}
</style>
