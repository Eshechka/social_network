<template>
    <div class="w-96 mx-auto">
        <div class="mb-4">
            <div class=" mb-3">
                <input v-model="title" class="w-96 rounded-3xl border p-2 border-slate-300" type="text"
                       placeholder="title">
<!--                <div v-if="errors.title">-->
<!--                    <p v-for="error in errors.title" class="text-sm mt-2 text-red-500">{{ error }}</p>-->
<!--                </div>-->
            </div>
            <div class=" mb-3">
                <textarea v-model="content" class="w-96 rounded-3xl border p-2 border-slate-300"
                          placeholder="content"></textarea>
<!--                <div v-if="errors.content">-->
<!--                    <p v-for="error in errors.content" class="text-sm mb-2 text-red-500">{{ error }}</p>-->
<!--                </div>-->
            </div>
            <div class="flex mb-3 items-center">
                <div>
                    <input @change="storeImage" ref="file" type="file" class="hidden">
                    <a href="#" class="block p-2 w-16 text-center text-sm rounded-3xl bg-sky-500 text-white"
                       @click.prevent="selectFile()">Image</a>
                </div>
                <div>
                    <a v-if="image" @click.prevent="image = null" class="ml-3" href="#">Cancel</a>
                </div>
            </div>
            <div v-if="image">
                <img :src="image.url" alt="preview">
            </div>
            <div>
                <a @click.prevent="store" href="#" class="block p-2 w-32 text-center rounded-3xl bg-green-600 text-white
                hover:bg-white hover:border hover:border-green-600 hover:text-green-600 box-border ml-auto">Publish</a>
            </div>
        </div>

<!--        <div v-if="posts">-->
<!--            <h1 class="mb-8 pb-8 border-b border-gray-400">Posts</h1>-->
<!--            <Post v-for="post in posts" :post="post"></Post>-->
<!--        </div>-->

    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "Personal",

    data() {
        return {
            title: '',
            content: '',
            fileInput: '',
            image: '',
        }
    },

    mounted() {
        this.getAuth();
    },

    methods: {
        getAuth() {
            axios.get('/api/personal').then(response => {
                console.log('response = ', response)
            });
        },
        selectFile() {
            this.fileInput = this.$refs.file;
            this.fileInput.click();
        },
        storeImage(e) {
            const file = e.target.files[0];
            const formData = new FormData();
            formData.append('image', file);

            axios.post('/api/post_image', formData)
                .then(res => {
                    this.image = res.data.data;
                });
        },
    },
}
</script>

<style scoped>

</style>
