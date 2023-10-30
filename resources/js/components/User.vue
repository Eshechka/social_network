<template>
    <div class="w-96 mx-auto">
        <div v-if="user" class="flex justify-between items-center mb-6 pb-6 border-b border-gray-400">
            <p>{{ user.name }}</p>
        </div>
        <div v-if="userPosts">
            <h1 class="mb-8 pb-8 border-b border-gray-400">Posts</h1>
            <Post v-for="post in userPosts" :post="post"></Post>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import Post from "./Post.vue";

export default {
    name: "User",
    components: {Post},
    data() {
        return {
            user: null,
            userPosts: null,
        }
    },

    mounted() {
        this.getUser();
        this.getUserPosts();
    },

    methods: {
        getUser() {
            axios.get(`/api/user/${this.$route.params.id}`)
                .then(r => {
                    this.user = r.data.data;
                })
        },
        getUserPosts() {
            axios.get(`/api/users/${this.$route.params.id}/posts`)
                .then(r => {
                    this.userPosts = r.data.data;
                })
        },
    },
}
</script>

<style scoped>

</style>
