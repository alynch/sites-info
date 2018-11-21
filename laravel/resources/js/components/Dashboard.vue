<template>
<div>

<div class="filter">
    <select v-model.number="searchField" @change="change(searchField)">
        <option value="0">All</option>
        <option value="1">Academic</option>
        <option value="2">Administrative</option>
    </select>
</div>


    <div class="grid">
        <div v-for="item in filteredItems(searchField)" :key="item.id">
            <card-component
                :item="item">
            </card-component>
        </div>
    </div>
</div>
</template>

<script>
    import CardComponent from './Card'
    
    export default {
        components: {
            CardComponent
        },

       data: function() {
            return {
                searchField: 0,
                array: this.items
            }
        },

        props: ['items'],
        mounted() {
        },

        methods: {

            change(search) {
                this.search = search;
            },

            filteredItems(id) {
                if (!id) {
                    return this.array;
                }

                return this.array.filter(item => {
                    console.log(item);
                    return item.group_id == id;
                })
            }
        }
    }
</script>

<style>
.grid {
    margin-top: 1em;
    display: grid;
    grid-template-columns: repeat(auto-fill, 20em);
    grid-gap: 1rem;
    justify-content: space-around;

}

.filter {
    display: flex;
    justify-content: flex-end;
    margin-right: 4px;
}
</style>

