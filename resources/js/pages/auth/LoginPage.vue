<script setup>
import axios from "axios";
import {ref} from "vue";
import {useRouter} from "vue-router";
import {useStore} from "vuex";

const router = useRouter();
const store = useStore();
const isHowPass = ref(false);
const errors = ref({});

const data = ref({
    email: '',
    password: '',
});

const login = async () => {
    try {
        const response = await axios.post('/api/login', {
            email: data.value.email,
            password: data.value.password
        });

        localStorage.setItem('access_token', response.data.access_token)
        await store.dispatch('fetchUser');
        await router.push({name: 'courses_page_url'});
        errors.value = '';
    } catch (error) {
        if (error.response && error.response.data && error.response.data.errors) {
            errors.value = error.response.data.errors;
        } else {
            console.error("Something went wrong", error);
        }
    }
};
</script>

<template>
    <div class="container">
        <div class="login_page w-50 my-5 mx-auto">
            <h2 class=" text-center">Login</h2>
            <div v-if="errors.length > 0" class="alert alert-danger my-1">
                {{errors}}
            </div>

            <form @submit.prevent="login">
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input v-model="data.email" class="form-control" type="email" id="email" required/>
                </div>

                <label for="password" class="form-label">Password:</label><br>
                <div class="input-group mb-3">
                    <input v-model="data.password" :type="isHowPass ? 'text' : 'password'" class="form-control" type="password" id="password" required/>
                    <button class="input-group-text" id="basic-addon2" @click="isHowPass = !isHowPass">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>
                            <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
                        </svg>
                    </button>
                </div>
                <button class="btn btn-primary" type="submit">Login</button>
            </form>
        </div>
    </div>
</template>

<style scoped>

</style>
