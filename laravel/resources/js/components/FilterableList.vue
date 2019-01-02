<template>

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h2><slot></slot></h2>

        <ul class="nav nav-pills">
            <li class="nav-item" v-for="filter in filters" :key="filter.id">
                <a class="nav-link" :class="{ selected: currentFilters.includes(filter.id) }" href="#" @click.prevent="filterItems(filter.id)">
                    {{ filter[filter_name] }}<span v-if="pluralize_filters">s</span>
                </a>
            </li>
        </ul>
    </div>

    <div class="text-right">
        {{ filteredItems.length | pluralize('unit') }}
    </div>

    <ul class="list-group list-group-flush">

        <li class="list-group-item" v-for="item in filteredItems" :key="item.id">

            <a :href="'/units/' + item.id">
                <span>{{ item[item_name] }}</span>
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
            filters: {
                type: Array,
                required: true
            },

            items: {
                type: Array,
                required: true
            },

            filter_id: {
                type: String,
                default: 'type_id'
            },

            filter_name: {
                type: String,
                default: 'name'
            },

            pluralize_filters: {
                type: Boolean,
                default: false
            },

            item_name: {
                type: String,
                default: 'name'
            }
        },

        computed: {
            filteredItems: function() {
                if (this.currentFilters.length === 0) {
                    //return this.validItems;
                }

                return this.validItems.filter(item => {
                    return this.currentFilters.includes(item[this.filter_id]);
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

        filters: {
            pluralize: function (number, word) {
                let w = number === 1 ? word: `${word}s`;
                return number + ' ' + w;
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

.text-right {
    padding-right: 1em;
padding: 0.5em 2.25em;
}
</style>padding: 0.75rem 1.25rem;
