<template>
    <div class="w-96 mx-auto">
        <div v-if="posts">
            <h1 class="mb-8 pb-8 border-b border-gray-400">Following Posts</h1>
            <Post v-for="post in posts" :post="post"></Post>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import Post from "./Post.vue";

export default {
    name: "Personal",
    components: {Post},
    data() {
        return {
            posts: [],
        }
    },

    mounted() {
        this.getPosts();
    },

    methods: {
        getPosts() {
            axios.get('/api/users/following_posts').then(response => {
                this.posts = response.data.data;
            });
        },
    },
}
</script>

<style scoped>

</style>
