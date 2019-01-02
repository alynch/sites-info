<template>

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h2>Academic units</h2>

       <ul class="nav nav-pills">
            <li class="nav-item" v-for="filter in filters" :key="filter.id">
                <a class="nav-link" :class="{ selected: currentFilters.includes(filter.id) }" href="#" @click.prevent="filterItems(filter.id)">
                    {{ filter.code }}s
                </a>
            </li>
        </ul>
    </div>

    <ul class="list-group list-group-flush">

        <li class="list-group-item" v-for="item in filteredItems" :key="item.id">

            <a :href="'/units/' + item.id">
                <span>{{ item.short_name }}</span>
            </a>

            <span class="badge badge-pill badge-secondary">{{ item.applications.length }}</span>
        </li>
    </ul>
</div>
</template>

<script>
    export default {

       data: function() {
            return {
                validItems: this.items,
                currentFilters: []
            }
        },

        props: {
            filters: Array,
            items: Array
        },

        computed: {
            filteredItems: function() {
                if (this.currentFilters.length === 0) {
                    //return this.validItems;
                }

                return this.validItems.filter(item => {
                    return this.currentFilters.includes(item.type_id);
                })
            }
        },

        methods: {
            filterItems: function(id) {

                let index = this.currentFilters.findIndex(item => item.id == id);

                if (this.currentFilters.includes(id)) {
                    this.currentFilters = this.currentFilters.filter(item => item  != id);
                } else {
                    this.currentFilters.push(id);
                }
            }
        },

        mounted: function() {
            this.currentFilters = this.filters.map(item => {
                return item.id;
            });
        }
    }
</script>

<style scoped>

.nav-link {
    margin: 0 5px;
    padding: 3px 6px;

}

.selected {
    background: #3490dc;
    color: #fff;
}


.selected:hover {
  color: #fff;
  background-color: #227dc7;
  border-color: #2176bd;
}

</style>
