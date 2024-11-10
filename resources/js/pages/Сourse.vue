<script setup>
import axios from "axios";
import {onMounted, ref} from "vue";
import { useRouter } from 'vue-router';

const courses = ref();
const router = useRouter();
const pagination = ref({});

onMounted(async () => {
    await getCourses();
});

const getCourses = async () => {
    try {
        const response = await axios.get('/api/courses');
        courses.value = response.data;

        pagination.value = {
            prev_page_url: response.data.links.prev,
            next_page_url: response.data.links.next
        };
    } catch (error) {
        console.error('Error fetching courses:', error);
    }
};

</script>

<template>
    <div class="container my-4">
        <h2>Курсы</h2>
        <div class="card-group">
            <div class="card" v-for="course in courses?.data">
                <div class="card-body text-secondary">
                    <h5 class="card-title">{{course.title}}</h5>
                    <p class="card-text">{{course.description}}</p>

                    <div class="btn-group">
                        <router-link :to="{name: 'course_groups_page_url', params: {id: course.id}}" class="btn btn-secondary">Группы</router-link>
                    </div>

                    <div class="btn-group mx-1">
                        <router-link :to="{name: 'course_lessons_page_url', params: {id: course.id}}" class="btn btn-secondary">Уроки</router-link>
                    </div>
                </div>
                <div class="card-footer">
                    <p>Price: {{course.price}}</p>
                </div>
            </div>
        </div>
        <div class="pagination my-2">
            <button class="btn btn-success text-light" @click.prevent="getCourses(pagination.prev_page_url)" :disabled="!pagination.prev_page_url">Предыдущая</button>
            <button class="btn btn-success mx-2" @click.prevent="getCourses(pagination.next_page_url)" :disabled="!pagination.next_page_url">Cледующая</button>
        </div>
    </div>
</template>

<style scoped>

</style>
