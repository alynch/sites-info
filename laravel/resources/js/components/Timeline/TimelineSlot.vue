<template>
    <div class="range"
        :style="'left:' + start + '%; width:' + width + '%;'">
    </div>
</template>

<script>
    export default {

        props: {
            period: Object
        },


       computed: {
            start: function() {
                return 100 * ((this.period.start_month - 1) *30 + (this.period.start_day - 1)) / 360 ;
            },
            width: function() {
                let end = 100 * ((this.period.end_month - 1) *30 + (this.period.end_day - 1)) / 360 ;
                return end - this.start;
            }
        },
    }
</script>

<style scoped>
.range {
    position: absolute;
    background: #3490dc;
    height: 100%;
}
</style>
