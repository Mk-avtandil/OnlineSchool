<script setup>
import axios from "axios";
import {onMounted, ref} from "vue";
import { useRoute } from 'vue-router';

const lessons = ref({});
const route = useRoute();

onMounted(async () => {
    await getLessons();
});

const getLessons = async (url = `/api/course/${route.params.id}/lessons`) => {
    try {
        const response = await axios.get(url);
        lessons.value = response.data;
    } catch (error) {
        console.error('Error fetching lessons:', error);
    }
}

const deleteLesson = async (lessonId) => {
    try {
        await axios.delete(`/api/lesson/${lessonId}`);
        await getLessons();
        successMessage.value = 'Lesson deleted successfully!';
    } catch (error) {
        console.error('Failed to delete lesson:', error);
    }
};
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
        <div class="card-group" v-for="lesson in lessons?.data" :key="lesson.id">
            <div class="card my-3">
                <div class="card-body text-secondary">
                    <div class="row">
                        <div class="col-8">
                            <h5 class="card-title text-dark">{{lesson.title}}</h5>
                        </div>
                        <div class="col-4 text-end align-top">
                            <div class="btn-group">
                                <router-link data-bs-toggle="dropdown" to="">
                                    <div id="nav-icon">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </div>
                                </router-link>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-sm-end">
                                    <li>
                                        <router-link :to="{name: 'lesson_edit_page_url', params: {id: lesson.id}}" class="dropdown-item">Edit</router-link>
                                    </li>
                                    <li>
                                        <button @click.prevent="deleteLesson(lesson.id)" class="dropdown-item" type="submit">Delete</button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <p class="card-text">{{lesson.description}}</p>
                </div>
                <div class="card-footer">
                    {{lessons.materials}}
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
#nav-icon {
    display: inline-block;
    cursor: pointer;
}

#nav-icon span {
    display: block;
    width: 18px;
    height: 2px;
    margin: 3px 0;
    background-color: #333;
    transition: 0.3s;
}
</style>
