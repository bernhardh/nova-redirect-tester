<template>
    <span class="inline-block rounded py-1 px-3 text-white" :class="getClass"><slot></slot></span>
</template>

<script>
export default {
    props: {
        color: {
            default: 'blue'
        }
    },
    computed: {
        getClass() {
            return 'bg-' + this.color;
        }
    }
}
</script>
