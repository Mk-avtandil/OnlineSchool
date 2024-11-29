<script setup>
import axios from "axios";
import {computed, watch, onMounted, ref} from "vue";
import { useRouter } from 'vue-router';
import { useStore } from "vuex";

const store = useStore();
const courses = ref();
const searchQuery = ref('');
const router = useRouter();
const role = computed(() => store.getters.role);

onMounted(async () => {
    await getCourses();
});

watch([searchQuery], () => {
    getCourses();
});

const getCourses = async (url = '/api/courses') => {
    try {
        const response = await axios.get(url, {
            params: {
                search: searchQuery.value
            }
        });
        courses.value = response.data;
    } catch (error) {
        console.error('Error fetching courses:', error);
    }
};

const deleteCourse = async (courseId) => {
    try {
        await axios.delete(`/api/courses/${courseId}`);
        await getCourses();
        successMessage.value = 'Course deleted successfully!';
    } catch (error) {
        console.error('Failed to delete course:', error);
    }
};
</script>

<template>
    <div class="container my-3">
        <div class="row mb-2">
            <div class="col-8">
                <span class="fs-3">Courses</span>
            </div>
            <div class="col-4 text-end  align-content-center" v-if="['admin', 'super_admin'].includes(role)">
                <router-link :to="{name: 'course_create_page_url'}" class="btn bg-body-tertiary px-2 py-1 border-dark">Add New Course</router-link>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <form class="d-flex" role="search">
                    <input v-model="searchQuery" class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                </form>
            </div>
        </div>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
            <div class="col" v-for="course in courses?.data" :key="course.id">
                <div class="card" >
                    <div class="card-body text-secondary">
                        <div class="row">
                            <div class="col-8">
                                <h5 class="card-title text-dark">{{course.title}}</h5>
                            </div>
                            <div class="col-4 text-end align-top" v-if="['admin', 'super_admin'].includes(role)">
                                <div class="btn-group">
                                    <button data-bs-toggle="dropdown" class="p-2">
                                        <div id="nav-icon">
                                            <span></span>
                                            <span></span>
                                            <span></span>
                                        </div>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-sm-end">
                                        <li>
                                            <router-link :to="{name: 'courses_edit_page_url', params: {id: course.id}}" class="dropdown-item">Edit</router-link>
                                        </li>
                                        <button @click.prevent="deleteCourse(course.id)" class="dropdown-item" type="submit">Delete</button>
                                    </ul>
                                </div>
                            </div>
                        </div>
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
