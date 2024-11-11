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

const getCourses = async (url = '/api/courses') => {
    try {
        const response = await axios.get(url);
        courses.value = response.data;

        pagination.value = {
            prev_page_url: response.data.links.prev,
            next_page_url: response.data.links.next
        };
    } catch (error) {
        console.error('Error fetching courses:', error);
    }
};

console.log(pagination);

</script>

<template>
    <div class="container my-4">
        <div class="row">
            <div class="col-8">
                <h3 class="mb-2">Courses</h3>
            </div>
            <div class="col-4 text-end">
                <router-link :to="{name: 'course_create_page_url'}" class="btn bg-body-tertiary px-2 py-1 border-dark">Add New Course</router-link>
            </div>
        </div>
        <div class="card-group">
            <div class="card" v-for="course in courses?.data">
                <div class="card-body text-secondary">
                    <h5 class="card-title text-dark">{{course.title}}</h5>
                    <p class="card-text">{{course.description}}</p>

                    <div class="btn-group">
                        <router-link :to="{name: 'course_groups_page_url', params: {id: course.id}}" class="btn btn-outline-success">Groups</router-link>
                    </div>

                    <div class="btn-group mx-1">
                        <router-link :to="{name: 'course_lessons_page_url', params: {id: course.id}}" class="btn btn-outline-success">Lessons</router-link>
                    </div>
                </div>
                <div class="card-footer">
                    Price: {{course.price}}
                </div>
            </div>
        </div>
        <div class="pagination my-2">
            <button class="btn btn-success text-light" @click.prevent="getCourses(pagination.prev_page_url)" :disabled="!pagination.prev_page_url">Prev</button>
            <button class="btn btn-success mx-2" @click.prevent="getCourses(pagination.next_page_url)" :disabled="!pagination.next_page_url">Next</button>
        </div>
    </div>
</template>

<style scoped>

</style>
