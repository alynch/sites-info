<template>
   <div class="widget">
        <label>
           {{ label }} 
        </label>

        <select @change="update" v-model.number="currMonth" :name="'period[' +  id  + '][' + suffix + '_month]'" required>
            <option value="" selected>Select month</option>
            <option v-for="(item, index) in months" :value="index+1" :selected="index+1 == currMonth">
                {{ item }}
            </option>
        </select>

         <input @input="update" type="number" min="1" max="31" :name="'period[' + id + '][' + suffix + '_day]'"
                v-model.number="currDay" required/>
    </div>
</template>

<script>
    export default {

       data: function() {
            return {
                currMonth: this.month,
                currDay: Number(this.day)
            }
        },

        props: {
            id: {
                type: Number,
                default: -9
            },
            months: Array,
            suffix: String, 
            label: String, 
            month: {
                type: Number,
                default: 0
            },
            day: {
                type: Number,
                default: 1
            }
        },

        methods: {
            update(e) {
                let data = {
                    period: this.id,
                    suffix: this.suffix,
                    month: this.currMonth,
                    day: this.currDay,
                }
                console.log('starting update events');
                this.$emit('update', data);
            }
        }
    }
</script>

<style scoped>

.widget {
    display: flex;
    padding: 5px 10px;
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
.flex-item {
    margin: 0 5px;
}

@media (max-width: 750px) {
label {
    width: 5em;
    }
}
</style>
