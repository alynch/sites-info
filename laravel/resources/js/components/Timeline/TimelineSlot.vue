<template>
    <div class="range"
        :style="'left:' + start + 'px; width:' + width + 'px;'">
    </div>
</template>

<script>
    export default {

        props: {
            period: Object
        },

       computed: {
            start: function() {
                return ((this.period.start_month - 1) + ((this.period.start_day - 1) / 30)) *50 ;
            },
            end: function() {
                return ((this.period.end_month - 1) + ((this.period.end_day - 1) / 30)) *50 ;
            },
            width: function() {
                return this.end - this.start;
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
