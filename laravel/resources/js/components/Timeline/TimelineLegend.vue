<template>
    <div class="range-box">
        <span v-for="month in months" class="calendar">{{ month }}</span>
    </div>
</template>

<script>
    export default {
        props: ['months']
    }
</script>

<style scoped>
.range-box {
    display: flex;
    margin: 1em auto;
}

.calendar {
    width: 8.333%;
    border-left: 1px solid #ccc;
    text-align: center;
    line-height: 1.2em;
    overflow: hidden;
}
</style>
