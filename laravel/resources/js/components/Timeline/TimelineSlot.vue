<template>
    <div class="range" v-bind:style="slotStyle"></div>
</template>

<script>
    export default {

        props: {
            period: Object,
            background: {
                type: String,
                default: '#3490dc'
            }
        },

       computed: {
            start: function() {
                return 100 * ((this.period.start_month - 1) *30 + (this.period.start_day - 1)) / 360 ;
            },
            width: function() {
                let end = 100 * ((this.period.end_month - 1) *30 + (this.period.end_day - 1)) / 360 ;
                return end - this.start;
            },
            slotStyle: function () {
                return {
                    left: this.start + '%',
                    width: this.width + '%',
                    background: this.background
                }
            }
        }
    }
</script>

<style scoped>
.range {
    position: absolute;
    height: 100%;
}
</style>
