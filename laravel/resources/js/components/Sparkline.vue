<template>
    <div class="sparkline">
                <svg class="status" viewBox="0 0 400 64" width="100%" height="100%">
                    <g stroke="#9099a2" fill="#fff">
                        <rect width="100%" height="100%" stroke="#ddd"/>

                        <template v-for="(month, index) in months">
                            <line :x1="index*33" :y1="0" :x2="index*33" y2="100%" stroke-width="1" stroke="#ddd"></line>
                            <text :x="index*33 + 15" y="60" class="small">{{ month }}</text> 
                        </template>

                        <template v-for="(line, index) in lines">
                            <line :x1="line.x1" :y1="line.y1" :x2="line.x2" :y2="line.y2" stroke-width="1" stroke="#9099a2"></line>
                        </template>
                    </g>
                 </svg>
            </span>
        </div>
</template>

<script>
    export default {

        props: ['data'],

        data: function() {
            return {
                months: ['J', 'F', 'M', 'A', 'M', 'J', 'J', 'A', 'S', 'O', 'N', 'D'],
                nweeks: 52,
                xwidth: 10,
                yheight: 48
            }
        },


        computed: {
            maxHeight: function() {
                return Math.max(...this.data.map(item => item.n))
            },

            yscale: function() {
                return this.yheight / this.maxHeight;
            },

            lines: function() {
                let all = [];


                for(var i = 0; i < this.nweeks; i++) {
                    if (this.data[i]) {
                        let y1 = this.yheight - this.yscale * this.data[i].n;
                        let y2 = (this.data[i+1]) ? this.yheight - this.yscale * this.data[i+1].n : this.yheight;
                        all[i] = {'x1': i*this.xwidth, 'x2': (i+1)*this.xwidth, 'y1': y1, 'y2': y2};
                    } else {
                        all[i] = {'x1': i*this.xwidth, 'x2': (i+1)*this.xwidth, 'y1': this.yheight, 'y2': this.yheight};
                    }
                }
                return all;
            }
        }
    }
</script>

<style scoped>
</style>
