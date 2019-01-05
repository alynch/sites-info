<template>
    <div class="card">
        <div class="card-header">
            <span class="float-right">
                <img v-if="status === 'Working'" class="spin" src="images/working.png" alt="Working"/>
                <img v-else-if="status === 'OK'" src="images/ok.svg" width="25" alt="OK"/>                
                <img v-else src="images/down.svg" width="25" alt="Down"/>
            </span>

            <h5 class="card-title">
               {{ item.name }} 
            </h5>

            <div class="url">
                <a :href="url">{{ url }}</a>
            </div>
        </div>

        <div v-if="url" class="float-right">
            <button class="btn btn-link float-right" type="button" @click="isOpen = !isOpen">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="1em" viewBox="0 1 12 16" stroke="#ccc">
                    <rect v-if="isOpen" height="2" width="12" y="6" x="1" class="minus"/>
                    <path v-else d="M12 9H7v5H5V9H0V7h5V2h2v5h5z" class="plus"/>
                </svg>
          </button> 
        </div>
        <div v-else>
            <div style="padding: 0.375rem 0.75rem">No data</div>
        </div>

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
            </ul
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

.url {
    white-space: nowrap;
    overflow: hidden;
}

.spin {
  animation: spin 2s infinite linear;
}
@keyframes spin {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(359deg);
  }
}

.plus {
    fill: #ccc;
    stroke-width: 1;
}

.minus {
    fill: #ccc;
    stroke-width: 1;
}

</style>
status
