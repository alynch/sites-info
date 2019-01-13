<template>
    <div class="container">
        <div class="grid">
            <span class="label"></span>
            <timeline-legend :months="months"/>

            <span class="label"></span>
            <span class="label"></span>
            <svg height="100%" width="100%">
                <template v-for="(line, index) in lines">
                    <g @click="selectLine(index)">
                        <text class="txt" text-anchor="middle" :x="line.x+'%'" y="100%">&nbsp;{{ line.label }}</text>
                        <line :x1="line.x +'%'" y1="5%" :x2="line.x+'%'" y2="97.5%" stroke-width="2" stroke="green" stroke-dasharray="1%"></line>
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

        <aside>
            <h4>Important dates</h4>

            <transition-group name="flip-list" tag="div">
            <div v-for="(line, index) in sortedLines" :key="line.id">
                <input type="text" v-model="line.label" v-bind:class="{active: index==lineSelected}" @click="selectLine(index)"/>
                <span class="date" v-text="getDate(line.x)"></span>
                <span> {{ line.description }}</span>
                <button class="destroy" title="Remove line" @click="deleteLine(line)">X</button>
            </div>
            </transition-group>

            <button @click="addLine" class="btn btn-sm">Add line</button>
        </aside>
    </div>
</template>

<script>
    import TimelineLegend  from './TimelineLegend'
    import Timeline  from './Timeline'

    export default {

        mounted: function () {
            window.addEventListener('keydown', this.moveLine, false);
        },
        components: {
            TimelineLegend,
            Timeline
        },

        props: ['applications'],

        data: function() {
            return {
                first_new_item: -1,
                lines: [
                    {'id':1, 'label': 'Winter S/Y', 'description': 'Winter S courses begin, Y courses resume', 'x': 2.0},
                    {'id':2, 'label': 'Summer F/Y', 'description': 'Summer F & Y courses begin', 'x': 37.5},
                    {'id':3, 'label': 'Summer S/Y', 'description': 'Summer S courses begin, Y courses resume', 'x': 52.5},
                    {'id':4, 'label': 'Fall F/Y', 'description': 'Fall F & Y courses begin', 'x': 68.33}
                ],
                lineSelected: null,
                timeline: this.periods,
                months: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                dayTic: 100 / 360,
                monthTic: 100 / 12
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
            },

        },

        methods: {
            addLine() {
                let index = this.first_new_item--;
                let line = {'id': index, 'label': 'new', 'x': 0};
                this.lines.push(line);
                this.lineSelected = this.lines.length - 1;
            },

            deleteLine(line) {
                this.lines.splice(this.lines.indexOf(line), 1)
            },

            selectLine(line) {
                this.lineSelected = line;
            },

            moveLine(e) {
                if (this.lineSelected == null) {
                    return;
                }

                let tic = (e.shiftKey) ? this.monthTic : this.dayTic;

                let line = this.lines[this.lineSelected];

                if (e.key === "ArrowLeft") {
                    line.x -= tic;
                } else if (e.key === "ArrowRight") {
                    line.x += tic;
                }

                // Wrap-around
                if (line.x <= 0) {
                    line.x += 100;
                } else if (line.x >= 100) {
                    line.x -= 100;
                }

                this.getDate(line.x);
            },

            getDate(x) {

                let date = Math.round(x * 3.6);
                let month = Math.floor(date / 30);
                let day = date % 30 + 1;

                return day + ' ' + this.months[month];
            }
        }
    }
</script>

<style scoped>

.txt {
    fill: green;
}

.grid {
    position: relative;
    display: grid;
    padding: 0 0 2em 0;
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

aside {
    margin: 2em 0;
}

.destroy {
    border: none;
    color: #cc9a9a;
}

.active {
    color: green;
}

.flip-list-move {
  transition: transform 1s;
}

.date {
    width: 6em;
    display: inline-block;
}

input {
    margin: 5px;
    border: 1px solid #e9ecef;
    border-radius: 2px;
}
</style>
