<script setup>
import { useStore } from "vuex";
import {computed} from "vue";
import {useRouter} from "vue-router";
import axios from "axios";

const store = useStore();
const router = useRouter();
const user = computed(() => store.getters.user);

const logout = async () => {
    try {
        await axios.post('/api/logout');

        await store.dispatch('logout');

        axios.defaults.headers.Authorization = null;

        await router.push({name: 'login_page_url'});
    } catch (error) {
        console.error("Logout failed: ", error);
    }
}
</script>

<template>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container">
            <a class="navbar-brand" href="#">School</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0" v-if="user">
                    <li class="nav-item">
                        <router-link :to="{name: 'courses_page_url'}" class="nav-link active" aria-current="page">Home</router-link>
                    </li>
                    <li class="nav-item" v-if="user?.data.role.includes('admin') || user?.data.role.includes('super_admin')">
                        <router-link :to="{name: 'student_list_page_url'}" class="nav-link active" aria-current="page">Students</router-link>
                    </li>
                    <li class="nav-item" v-if="user?.data.role.includes('admin') || user?.data.role.includes('super_admin')">
                        <router-link :to="{name: 'teacher_list_page_url'}" class="nav-link active" aria-current="page">Teachers</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link :to="{name: 'schedule_page_url'}" class="nav-link active" aria-current="page">Schedule</router-link>
                    </li>
                    <li class="nav-item" v-if="user?.data.role.includes('super_admin')">
                        <router-link :to="{name: 'statistics_page_url'}" class="nav-link active" aria-current="page">Statistics</router-link>
                    </li>
                </ul>
                <ul class="navbar-nav mb-2 mb-lg-0 ms-auto">
                    <li class="nav-item" v-if="user?.data.role.includes('student')">
                        <router-link :to="{name: 'student_detail_page_url', params: {id: user?.data.id}}" class="nav-link text-primary">
                            {{user?.data.email}}
                        </router-link>
                    </li>
                    <li class="nav-item"  v-if="user?.data.role.includes('teacher')">
                        <router-link :to="{name: 'teacher_detail_page_url', params: {id: user?.data.id}}" class="nav-link text-primary">
                            {{user?.data.email}}
                        </router-link>
                    </li>
                    <li class="nav-item" v-if="user?.data.role.includes('admin') || user?.data.role.includes('super_admin')">
                        <button type="button"  class="nav-link active">{{user?.data.email}}</button>
                    </li>
                    <li class="nav-item" v-if="!user">
                        <router-link :to="{name: 'login_page_url'}" class="nav-link active" aria-current="page">Login</router-link>
                    </li>
                    <li class="nav-item" v-if="user">
                        <button type="button" @click="logout" class="nav-link active">Logout</button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<style scoped>

</style>
