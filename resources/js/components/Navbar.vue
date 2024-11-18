<script setup>
import { useStore } from "vuex";
import {computed, onMounted} from "vue";
import {useRouter} from "vue-router";

const store = useStore();
const router = useRouter();
const token = computed(() => store.getters.token);
const user = computed(() => store.getters.user);
const role = computed(() => store.getters.role);
const isAuthenticated = computed(() => store.getters.isAuthenticated);

const logout = async () => {
    try {
        await store.dispatch('logout');

        localStorage.removeItem('auth_token');
        axios.defaults.headers.Authorization = null;

        await axios.post('/api/logout');
        router.push({name: 'courses_page_url'});
    } catch (error) {
        console.error("Logout failed: ", error);
    }
}

onMounted(() => {
    if (isAuthenticated.value && !user.value) {
        store.dispatch('fetchUser');
    }
});
</script>

<template>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container">
            <a class="navbar-brand" href="#">School</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <router-link :to="{name: 'courses_page_url'}" class="nav-link active" aria-current="page">Home</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link :to="{name: 'student_list_page_url'}" class="nav-link active" aria-current="page">Students</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link :to="{name: 'teacher_list_page_url'}" class="nav-link active" aria-current="page">Teachers</router-link>
                    </li>
                </ul>
                <ul class="navbar-nav mb-2 mb-lg-0 ms-auto" v-if="!isAuthenticated">
                    <li class="nav-item">
                        <router-link :to="{name: 'login_page_url'}" class="nav-link active" aria-current="page">Login</router-link>
                    </li>
                </ul>
                <ul class="navbar-nav mb-2 mb-lg-0 ms-auto" v-if="isAuthenticated">
                    <li class="nav-item">
                        <button type="button"  class="nav-link active">{{user.email}}</button>
                    </li>
                    <li class="nav-item" >
                        <button type="button" @click="logout" class="nav-link active">Logout</button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<style scoped>

</style>
