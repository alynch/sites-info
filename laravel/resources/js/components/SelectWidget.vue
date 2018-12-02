<template>
<div>
    <ul>
        <li class="item" v-for="item in selectedItems">
            <span class="name">{{ item.short_name }}</span>
            <span class="delete" @click="unselectItem(item.id)" title="Delete"> x </span>
        </li>
    </ul>

    <select v-model.number="selected" @change="selectItem">
        <option value="0">Add unit</option>
        <option v-for="item in availableItems" :value="item.id">
            {{ item.short_name }}
        </option>
    </select>

    <button type="button" class="btn btn-sm btn-outline-secondary" @click="removeAll">Remove all</button>

    <div v-for="item in selectedItems">
        <input type="hidden" name="units[]" :value="item.id"/>
    </div>
</div>
</template>

<script>
    export default {

       data: function() {
            return {
                validItems: this.items,
                selected: 0
            }
        },

        props: {
            items: Array
        },

        computed: {
            selectedItems: function() {
                return this.validItems.filter(item => {
                    return item.selected;
                })
            },

            availableItems: function() {
                return this.validItems.filter(item => {
                    return !item.selected;
                })
            }
        },

        methods: {
            selectItem: function() {
                let item = this.validItems.find(item => item.id == this.selected);
                item.selected = true;
                this.selected = 0;
            },

            unselectItem: function(id) {
                let item = this.validItems.find(item => item.id == id);
                item.selected = false;
                console.log(id);
            },

            removeAll: function() {
                return this.validItems.map(item => {
                    item.selected = false;
                    return item;
                });
            }
        }
    }
</script>

<style scoped>

ul {
    list-style-type: none;
    display: flex;
    padding: 0;
    flex-wrap: wrap;
}

.item {
    border: 1px solid #ccc;
    border-radius: 5px;
    margin: 5px 5px 5px 0;
    background: #eee;
}

.name {
    line-height: 100%;
    padding-left: 3px;
    padding-right: 5px;
}

.delete {
    height: 100%;
    cursor: pointer;
    border: 1px solid #ccc;
    padding: 0 5px;
    border-radius: 5px;
    opacity: 0.2;
}

.delete:hover {
    opacity: 1;
}
</style>
status
