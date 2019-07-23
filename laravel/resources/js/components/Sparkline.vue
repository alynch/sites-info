<template>
    <div class="sparkline">
        <em>{{ title }}</em>

        <svg :viewBox="'0 0 ' + this.totalWidth + ' ' + this.totalHeight"width="100%" height="100%">
            <g stroke="#9099a2" fill="#fff">
                <rect width="100%" height="100%" stroke="#ddd"/>

                <template v-for="(month, index) in months">
                    <line :x1="index*monthWidth" :y1="0" :x2="index*monthWidth" y2="100%" stroke-width="1" stroke="#ddd"></line>
                    <text :x="index*monthWidth +  monthWidth / 2" y="60" class="small">{{ month }}</text>
                </template>

                <template v-for="(line, index) in lines">
                    <line :x1="line.x1" :y1="line.y1" :x2="line.x2" :y2="line.y2" stroke-width="1" stroke="#9099a2"></line>
                    <text :x="line.x1 - 1" y="line.y1" class="small">{{ index % 10 }}</text>
                </template>
            </g>
        </svg>
    </div>
</template>

<script>
    export default {

        props: ['data', 'title'],

        data: function() {
            return {
                months: ['J', 'F', 'M', 'A', 'M', 'J', 'J', 'A', 'S', 'O', 'N', 'D'],
                nweeks: 52,
                totalWidth: 400,
                totalHeight: 64,
            }
        },


        computed: {
            maxHeight: function() {
                return Math.max(...this.data.map(item => item.n))
            },

            yHeight: function() {
                return this.totalHeight * 0.75;
            },

            yScale: function() {
                return this.yHeight / this.maxHeight;
            },

            monthWidth: function() {
                return this.totalWidth / 12;
            },

            xScale: function() {
                return this.totalWidth / this.nweeks;
            },

            lines: function() {
                let all = [];

                for(var i = 0; i < this.nweeks; i++) {
                    if (this.data[i]) {
                        let y1 = this.yHeight - this.yScale * this.data[i].n;
                        let y2 = (this.data[i+1]) ? this.yHeight - this.yScale * this.data[i+1].n : this.yHeight;
                        all[i] = {'x1': i*this.xScale, 'x2': (i+1)*this.xScale, 'y1': y1, 'y2': y2};
                    } else {
                        all[i] = {'x1': i*this.xScale, 'x2': (i+1)*this.xScale, 'y1': this.yHeight, 'y2': this.yHeight};
                    }
                }
                return all;
            }
        }
    }
</script>

<style scoped>
    .sparkline {
        margin-bottom: 1em;
    }
    .small {
        font-size: 12px;
    }
</style>
