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
    height: 100%;
}
</style>
