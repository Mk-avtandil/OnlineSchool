<script setup>
import axios from "axios";
import {onMounted, ref} from "vue";
import { useRoute } from 'vue-router';

const lessons = ref({});
const route = useRoute();

onMounted(async () => {
    lessons.value = (await axios.get(`/api/courses/${route.params.id}/lessons`)).data;
});
</script>

<template>
    <div class="container my-4">
        <h2>Уроки курса </h2>
        <div class="card-group" v-for="lesson in lessons?.data">
            <div class="card my-3">
                <div class="card-body text-secondary">
                    <h5 class="card-title">{{lesson.title}}</h5>
                    <p class="card-text">{{lesson.description}}</p>
                </div>
                <div class="card-footer">
                    <span>Materials: </span><br>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
