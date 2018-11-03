<template>
<div class="grid">
    <div v-for="item in items">
        <card-component
            :item="item">
        </card-component>
    </div>
</div>
</template>

<script>
    import CardComponent from './Card'
    
    export default {
        components: {
            CardComponent
        },

        props: ['items'],
        mounted() {
        }
    }
</script>

<style>
.grid {
    margin-top: 2em;
    display: grid;
    grid-template-columns: repeat(auto-fill, 20em);
    grid-gap: 1rem;
    justify-content: space-around;

}
</style>

