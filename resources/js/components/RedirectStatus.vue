<template>
    <span>
        <svg v-if="status == 'error'" fill="red" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path class="heroicon-ui" d="M4.93 19.07A10 10 0 1 1 19.07 4.93 10 10 0 0 1 4.93 19.07zm1.41-1.41A8 8 0 1 0 17.66 6.34 8 8 0 0 0 6.34 17.66zM13.41 12l1.42 1.41a1 1 0 1 1-1.42 1.42L12 13.4l-1.41 1.42a1 1 0 1 1-1.42-1.42L10.6 12l-1.42-1.41a1 1 0 1 1 1.42-1.42L12 10.6l1.41-1.42a1 1 0 1 1 1.42 1.42L13.4 12z"/></svg>
<svg v-else-if="status == 'success'" fill="green" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path class="heroicon-ui" d="M17.62 10H20a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H8.5c-1.2 0-2.3-.72-2.74-1.79l-3.5-7-.03-.06A3 3 0 0 1 5 9h5V4c0-1.1.9-2 2-2h1.62l4 8zM16 11.24L12.38 4H12v7H5a1 1 0 0 0-.93 1.36l3.5 7.02a1 1 0 0 0 .93.62H16v-8.76zm2 .76v8h2v-8h-2z"/></svg>
<div v-else class="loaderIcon"></div>
    </span>
</template>

<script>
export default {
    props: {
        status: {
            default: 'loading'
        }
    }
}
</script>


<style scoped>
    .loaderIcon {
        border: 5px solid #f3f3f3;
        border-radius: 50%;
        border-top: 5px solid #3498db;
        width: 30px;
        height: 30px;
        -webkit-animation: spin 2s linear infinite;
        animation: spin 2s linear infinite;
        display: inline-block;
    }
    @-webkit-keyframes spin {
        0% { -webkit-transform: rotate(0deg); }
        100% { -webkit-transform: rotate(360deg); }
    }
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
