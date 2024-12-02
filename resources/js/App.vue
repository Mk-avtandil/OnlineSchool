<script setup>
import Navbar from './components/Navbar.vue';
import axios from "axios";
import {useStore} from "vuex";
import {onMounted} from "vue";

const store = useStore();

onMounted(async () => {
    const token = localStorage.getItem('access_token');
    if (token) {
        axios.get('/api/user', {
            headers: {
                Authorization: `Bearer ${token}`,
            },
        }).then(response => {
            store.commit('SET_USER', response.data.data);
        }).catch(error => {
            console.error('Failed to fetch user data:', error);
            store.commit('CLEAR_USER');
            localStorage.removeItem('access_token');
        });
    } else {
        store.commit('CLEAR_USER');
    }
});

</script>

<template>
    <div id="app">
        <Navbar />

        <router-view v-slot="{ Component, route }">
            <div :key="route.name">
                <Component :is="Component" />
            </div>
        </router-view>
    </div>
</template>

<style scoped>
</style>
