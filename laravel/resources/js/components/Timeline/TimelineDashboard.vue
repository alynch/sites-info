<template>
    <div class="container">
        <div class="grid">
            <span class="label"></span>
            <timeline-legend :months="months"/>

            <span class="label"></span>
            <span class="label"></span>
            <svg height="30px" width="100%" viewBox="0 0 100% 100%">
                <template v-for="(line, index) in lines">
                    <g stroke="green" @click="selectLine(index)">
                    <text :x="line.x+'%'" y="10">&nbsp;{{ line.label }}</text>
                    <line :x1="line.x+'%'" y1="0" :x2="line.x+'%'" y2="100%" stroke-width="2" stroke-dasharray="1%"></line>
                    </g>
                </template>
            </svg>

            <template v-for="application in applications">
                <span class="label">{{ application.name }}</span>
                <div class="range-box">
                    <timeline :throughout="application.all_year" :periods="application.timeline"></timeline>
                </div>
            </template>
        </div>

        <div>
            <h2>Important dates</h2>

            <div v-for="(line, index) in sortedLines" :key="line.x">
                <input type="text" v-model="line.label" v-bind:class="{active: index==lineSelected}" @click="selectLine(index)"/>

                <button @click="deleteLine(line)">Delete</button>
            </div>
            <button @click="addLine" class="btn btn-sm">Add line</button>
        </div>
    </div>
</template>

<script>
    import TimelineLegend  from './TimelineLegend'
    import Timeline  from './Timeline'

    export default {

        created: function () {
            window.addEventListener('keypress', this.moveLine)
        },
        components: {
            TimelineLegend,
            Timeline
        },

        props: ['applications'],

        data: function() {
            return {
                lines: [
                    {'label': 'start', 'x': 8.33},
                    {'label': 'middle', 'x': 45},
                    {'label': 'end', 'x': 83.33}
                ],
                lineSelected: null,
                timeline: this.periods,
                months: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            }
        },

        computed: {
            sortedLines() {
                let curr = this.lines[this.lineSelected];
                this.lines.sort(function(a, b) {
                    return a.x > b.x;
                });
                this.lineSelected = this.lines.indexOf(curr);
                return this.lines;
            }
        },

        methods: {
            addLine() {
                let line = {'label': 'new', 'x': 0};
                this.lines.push(line);
                this.lineSelected = this.lines.length - 1;
            },

            deleteLine(line) {
                this.lines.splice(this.lines.indexOf(line), 1)
            },

            selectLine(line) {
                console.log(line);
                this.lineSelected = line;
            },

            moveLine(e) {
                if (this.lineSelected == null) {
                    return;
                }

                let line = this.lines[this.lineSelected];

                if (e.key === "ArrowLeft") {
                    line.x -= 1;
                } else if (e.key === "ArrowRight") {
                    line.x += 1;
                }

                // Wrap-around
                if (line.x < 0) {
                    line.x = 100;
                }
                if (line.x > 100) {
                    line.x = 0;
                }
            }
        }
    }
</script>

<style scoped>
.grid {
    position: relative;
    display: grid;
    grid-template-columns: 10em 1fr;
}

.range-box {
}

svg {
    position: absolute;
    z-index: 1;
    width: calc(100% - 10em);
    margin-left: 10em;
    height: 100%;
}

.label {
    font-size: 0.95em;
    padding-right: 5px;
}

.active {
    color: green;
}
</style>
