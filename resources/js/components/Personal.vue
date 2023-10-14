<template>
    <div></div>
</template>

<script>
export default {
    name: "Personal",

    mounted() {
        this.getAuth();
    },

    methods: {
        getAuth() {
            axios.get('/api/personal').then(response => {
                console.log('response = ', response)
            });
        }
    },
}
</script>

<style scoped>

</style>
