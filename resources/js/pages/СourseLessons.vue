<script setup>
import axios from "axios";
import {onMounted, ref} from "vue";
import { useRoute } from 'vue-router';

const lessons = ref({});
const route = useRoute();

onMounted(async () => {
    lessons.value = (await axios.get(`/api/lessons/${route.params.id}`)).data;
});
</script>

<template>
    <div class="container my-4">
        <div class="row">
            <div class="col-8">
                <h3 class="mb-2">Course lessons</h3>
            </div>
            <div class="col-4 text-end">
                <router-link :to="{name: 'lesson_create_page_url'}" class="btn bg-body-tertiary px-2 py-1 border-dark">Add New Lesson</router-link>
            </div>
        </div>
        <div class="card-group" v-for="lesson in lessons?.data">
            <div class="card my-3">
                <div class="card-body text-secondary">
                    <h5 class="card-title">{{lesson.title}}</h5>
                    <p class="card-text">{{lesson.description}}</p>
                </div>
                <div class="card-footer">
                    <span>Materials:</span>
                    <ul v-for="material in lesson.materials">
                        <li v-for="file in material.files" :key="file.id">
                            <a :href="`/storage/${file.file_path}`" download >
                                Download file
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
