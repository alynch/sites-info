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
            <button class="btn btn-link float-right" type="button" data-toggle="collapse"
                :data-target="'#env' + item.id" aria-expanded="false" 
                aria-controls="collapseExample"> 
                Details
          </button> 
        </div>
        <div v-else>
            <div style="padding: 0.375rem 0.75rem">No data</div>
        </div>

        <div class="collapse" :id="'env' + item.id">
            <ul class="list-group list-group-flush">
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

                    <div v-for="(item, index) in env.status.headers">
                        {{ index }}: {{ item }}
                    </div>
                </li>
            </ul
        </div>
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
                headers: null
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
</style>
status
