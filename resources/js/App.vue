<script setup>
import Navbar from './components/Navbar.vue';
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
