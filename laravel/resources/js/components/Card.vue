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
            <div>
                {{ ip }}
            </div>
        </div>

        <span v-if="status === 'OK'" class="float-right">
        <button class="btn btn-link float-right" type="button" data-toggle="collapse" 
                :data-target="'#env' + item.id" aria-expanded="false" 
                aria-controls="collapseExample"> 
                Environments details
          </button> 
        </span>

        <div class="collapse" :id="'env' + item.id">
            <div class="card-body">
                <strong>Production:</strong>
                <div v-for="(item, index) in headers">
                    {{ index }}: {{ item }}
                </div>
            </div>
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

                    console.log(card.cardData);
                    console.log(event.data);
                    if (event.data) {
                        card.status = (card.cardData.status.running) ? 'OK' : 'Down';
                        card.ip = card.cardData.status.ip;
                        card.url = card.cardData.pivot.url;
                        card.headers = card.cardData.status.headers;
                        event.target.close();
                    } else {
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
