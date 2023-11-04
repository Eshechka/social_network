<template>
    <div class="p-4">
        <div class="flex justify-between w-96 mx-auto pb-2">
            <router-link class="mx-0" v-if="!token" to="login">Login</router-link>
            <router-link class="mx-2" v-if="!token" to="register">Register</router-link>
            <router-link class="mx-2" v-if="token" :to="{ name: 'feed' }">Feed</router-link>
            <router-link class="mx-2" v-if="token" :to="{ name: 'users' }">Users</router-link>
            <router-link class="mx-2" v-if="token" :to="{ name: 'personal' }">Personal</router-link>
            <a v-if="token" @click.prevent="logout" href="#">Logout</a>
        </div>
        <router-view></router-view>
    </div>
</template>
<script>

export default {
    name: "App",

    data() {
        return {
            token: null,
        }
    },

    mounted() {
        this.getToken();
    },
    // watch: {
    //    $route(to, from) {
    //         this.getToken();
    //     }
    // },

    methods: {
        getToken() {
            this.token = localStorage.getItem('X_XSRF_TOKEN');
        },
        logout() {
            axios.post('/logout')
                .then(r => {
                    localStorage.removeItem('X_XSRF_TOKEN');
                    this.$router.push({path: "/login"});
                })
        }
    },
}
</script>
