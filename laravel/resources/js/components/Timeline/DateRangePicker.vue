<template>
    <div class="group">
            <datepicker
                :id="period.id"
                :months="months"
                label="From"
                suffix="start"
                :month="period.start_month"
                :day="period.start_day"
                @update="update">
            </datepicker>

            <datepicker
                :id="period.id"
                :months="months"
                label="To"
                suffix="end"
                :month="period.end_month"
                :day="period.end_day"
                @update="update">
            </datepicker>

            <button class="btn btn-danger btn-sm" @click.prevent="deleteItem()">Delete</button>
        </div>
</template>

<script>
    import Datepicker  from './Datepicker'

    export default {
        components: {
            Datepicker
        },

        props: ['period', 'months'],

        methods: {
            deleteItem() {
                if (confirm('Delete this period?')) {
                    this.$emit('delete', this.period);
                    axios.delete('/timeline/' + this.period.id);
                }
            },

            update(item) {
                console.log(JSON.stringify(item));
                this.$emit('update', item);
            }
        }
    }
</script>

<style scoped>
.group {
    display: flex;
    width: 100%;
    justify-content: space-around;
}

input[type=number] {
    max-width: 4em;
}

label {
    margin-right: 2em;
}

select {
    margin: 0 10px;
}

button {
    margin: 5px 0;
}

</style>
