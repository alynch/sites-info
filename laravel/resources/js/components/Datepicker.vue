<template>
   <div class="group">
        <label>
           {{ label }} 
        </label>

        <select :name="'period[' +  id  + '][' + sufix + '_month]'" required>
            <option value="">Select month</option>
            <option v-for="(item, index) in months" :value="index+1" :selected="index+1 == month">
                {{ item }}
            </option>
        </select>

         <input type="number" min="1" max="31" :name="'period[' + id + '][' + sufix + '_day]'"
                :value="day" required/>
    </div>
</template>

<script>
    export default {

       data: function() {
            return {
            }
        },

        props: {
            id: {
                type: Number,
                default: -9
            },
            months: Array,
            sufix: String, 
            label: String, 
            month: Number,
            day: {
                type: Number,
                default: 1
            }
        }
    }
</script>

<style scoped>
.group {
    display: flex;
    width: 50%;
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

</style>
