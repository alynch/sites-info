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
                this.$emit('update', item);
            }
        }
    }
</script>

<style scoped>
.group {
    display: flex;
    justify-content: space-around;
    width: 100%;
    padding: 5px;
    margin: 5px 0;
}

@media (max-width: 750px) {
    .group {
        display: block;
    }
}
</style>
