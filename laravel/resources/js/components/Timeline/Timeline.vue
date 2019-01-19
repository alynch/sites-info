<template>
<div class="timeline">
    <div v-if="throughout" class="throughout"></div>

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

        props: ['periods', 'throughout'],

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
    width: 100%;
}

.throughout {
    position: absolute;
    width: 100%;
    top: 7px;
    height: 3px;
    background: #6d7993;
}

</style>
