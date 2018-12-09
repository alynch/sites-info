<template>
    <div class="container">
        <div class="grid">
            <span class="label"></span>
            <timeline-legend :months="months"/>

            <span class="label"></span>
            <span class="label"></span>
            <svg height="100%" width="100%">
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

        <aside>
            <h4>Important dates</h4>

            <transition-group name="flip-list" tag="div">
            <div v-for="(line, index) in sortedLines" :key="line.id">
                <input type="text" v-model="line.label" v-bind:class="{active: index==lineSelected}" @click="selectLine(index)"/>
                <span class="date" v-text="getDate(line.x)"></span>
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
                first_new_item: -1,
                lines: [
                    {'id':1, 'label': 'Start winter session', 'x': 8.33},
                    {'id':2, 'label': 'middle', 'x': 45},
                    {'id':3, 'label': 'end', 'x': 83.33}
                ],
                lineSelected: null,
                timeline: this.periods,
                months: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                dayTic: 100 / 360,
                monthTic: 10 / 12
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
                let line = {'id': this.first_new_item--, 'label': 'new', 'x': 0};
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

                let line = this.lines[this.lineSelected];

                if (e.key === "ArrowLeft") {
                    line.x -= this.dayTic;
                } else if (e.key === "ArrowRight") {
                    line.x += this.dayTic;
                }

                // Wrap-around
                if (line.x < 0) {
                    line.x = 100;
                } else if (line.x >= 100) {
                    line.x = 0;
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
