<script setup>
import axios from "axios";
import {computed, onMounted, ref} from "vue";
import { useRoute } from 'vue-router';
import { useStore } from "vuex";

const store = useStore();
const role = computed(() => store.getters.role);
const lessons = ref({});
const route = useRoute();

onMounted(async () => {
    await getLessons();
});

const getLessons = async (url = `/api/lessons/${route.params.id}`) => {
    try {
        const response = await axios.get(url);
        lessons.value = response.data;
    } catch (error) {
        console.error('Error fetching lessons:', error);
    }
}

const deleteLesson = async (lessonId) => {
    try {
        await axios.delete(`/api/lessons/${lessonId}`);
        await getLessons();
        successMessage.value = 'Lesson deleted successfully!';
    } catch (error) {
        console.error('Failed to delete lesson:', error);
    }
};
</script>

<template>
    <div class="container my-3">
        <div class="row">
            <div class="col-8">
                <span class="fs-6">
                    <button @click="$router.go(-1)" class="btn btn-outline-dark">Назад</button>
                </span>
                <span class="fs-3 mx-2 align-middle">Course lessons</span>
            </div>
            <div class="col-4 text-end" v-if="['admin', 'super_admin', 'teacher'].includes(role)">
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
                        <div class="col-4 text-end align-top"  v-if="['admin', 'super_admin', 'teacher'].includes(role)">
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
                    <div class="row">
                        <div class="col-6">
                            <div v-if="lesson.materials.length">
                                <span>Materials:</span>
                                <ul>
                                    <li v-for="file in lesson.materials" :key="file.id">
                                        <a :href="file.url" :download="file.name">
                                            Download {{ file.name }}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <p v-else>No materials found</p>
                        </div>
                        <div class="col-6">
                            <div v-if="lesson.homeworks.length">
                                <span>Homeworks:</span>
                                <ul class="list-group">
                                    <button v-for="homework in lesson.homeworks" class="btn p-0 rounded-0 homework-btn">
                                        <router-link :to="{name: 'homework_detail_page_url', params: {id: homework.id}}" class="list-group-item p-2">
                                            {{homework.title}}
                                        </router-link>
                                    </button>
                                </ul>
                            </div>
                            <p v-else>
                                No homeworks found <span v-if="role === 'teacher'">-></span>
                                <router-link
                                    :to="{name: 'homework_create_page_url', params: {id: lesson.id}}"
                                    class="btn btn-link p-0 text-decoration-none"
                                    v-if="role === 'teacher'">
                                    Add homework
                                </router-link>
                            </p>
                        </div>
                    </div>
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
