<template>
    <div class="card">
        <div class="card-header">
            <span class="float-right">
                <svg class="status" viewBox="0 0 32 32" width="28" height="28">
                    <g v-if="status === 'Working'" style="fill:#333;" class="spin">
                        <circle cx="4" cy="16" r="1"/>
                        <circle cx="8" cy="8" r="1.25"/>
                        <circle cx="16" cy="4" r="1.5"/>
                        <circle cx="24" cy="8" r="1.75"/>
                        <circle cx="28" cy="16" r="2"/>
                        <circle cx="24" cy="24" r="2.5"/>
                        <circle cx="16" cy="28" r="3"/>
                        <circle cx="8" cy="24" r="3.5"/>
                    </g>
                    <g v-else-if="status === 'OK'">
                        <circle style="fill:#6AC259;" cx="16" cy="16" r="16"/>
                        <path style="fill:none; stroke:#fff; stroke-width:3.5" d="M7 16 L13 22 L 25 10"/>
                    </g>
                    <g v-else>
                        <circle style="fill:#F05228;" cx="16" cy="16" r="16"/>
                        <path style="stroke:#fff; stroke-width:5" d="M9 9 L 23 23 M 9 23 L 23 9"/>
                    </g>
                 </svg>
            </span>

            <h5 class="card-title">
               {{ item.name }} 
            </h5>

            <div class="url">
                <a :href="url">{{ url }}</a>
            </div>
        </div>

        <div v-if="url">
           <button class="btn btn-link float-right" type="button"
                :title="isOpen ? 'Hide details' : 'Show details'" @click="isOpen = !isOpen">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" class="icons">
                    <path v-if="isOpen" d="M2 5 L 8 11 L 14 5"/>
                    <path v-else d="M 5 2 L 11 8 L 5 14"/>
                 </svg>
           </button> 
        </div>
        <div v-else>
            <div style="padding: 0.375rem 0.75rem">No data</div>
        </div>

            <transition name="slide">
            <ul class="list-group list-group-flush" v-if="isOpen">
                <li class="list-group-item" v-for="env in cardData">
                    <strong>{{ env.name }}:</strong>
                    <span class="float-right">
                    <span v-if="env.status.running">OK</span>
                    <span v-else>Down</span>
                    </span>

                    <div class="url">
                        <a :href="env.pivot.url">{{ env.pivot.url }}</a>
                    </div>

                    <div>{{ env.status.ip }}</div>

                    <div v-for="header in env.status.headers">
                        {{ header.name }}: {{ header.value }}
                    </div>
                </li>
            </ul>
            </transition>
    </div>
</div>
</template>

<script>
    export default {

       data: function() {
            return {
                cardData: null,
                status: 'Working',
                ip: null,
                url: null,
                headers: null,
                isOpen: false
            }
        },

        props: ['item'],

        mounted() {
        },

        created() {
            this.setupStream();
        },

        methods: {
            setupStream() {

                let es = new EventSource('/applications/' + this.item.id + '/status');

                let card = this;

                es.addEventListener('message', function(event) {
                    card.cardData = JSON.parse(event.data);

                    if (card.cardData[0]) {
                        card.status = (card.cardData[0].status.running) ? 'OK' : 'Down';
                        card.ip = card.cardData[0].status.ip;
                        card.url = card.cardData[0].pivot.url;
                        card.headers = card.cardData[0].status.headers;
                    } else {
                        card.status = 'Down';
                        card.url = '';
                        console.log('No data... ');
                    }
                    es.close();

                }, false);

                es.addEventListener('error', function(event) {
                    if (event.readyState == EventSource.CLOSED) {
                        console.log(EventSource);
                        card.status = 'Down';
                    }
                }, false);
            }
        }
    }
</script>

<style scoped>

.card {
    transition: box-shadow 150ms;
}

.card:hover {
    box-shadow: 0px 0px 0px 3px #ccc;
}

.card-title {
    font-size: 1rem;
    font-weight: 400;
}

.url {
    white-space: nowrap;
    overflow: hidden;
}

.spin {
  animation: spin 2s infinite linear;
    transform-origin: center;
}

@keyframes spin {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(359deg);
  }
}

.fade-enter-active, .fade-leave-active {
  transition: opacity .5s;
}

.fade-enter, .fade-leave-to {
  opacity: 0;
}

.slide-enter-active {
   transition-duration: 0.2s;
   transition-timing-function: ease-in;
}

.slide-leave-active {
   transition-duration: 0.2s;
   transition-timing-function: ease-out;
}

.slide-enter-to, .slide-leave {
   max-height: 100px;
   overflow: hidden;
}

.slide-enter, .slide-leave-to {
   overflow: hidden;
   max-height: 0;
}

.status {
    margin-left: 2px;
}

.icons {
    fill: none;
    stroke: #ccc;
    stroke-width: 3;
}
</style>
