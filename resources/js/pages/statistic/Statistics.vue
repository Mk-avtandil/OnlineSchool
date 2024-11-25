<script setup>
import axios from "axios";
import {computed, onMounted, ref} from "vue";
import { useStore } from "vuex";

const store = useStore();
const role = computed(() => store.getters.role);
const courses = ref();
const groups = ref();

onMounted(async () => {
    await getCourses();
});

const getCourses = async () => {
    try {
        const response = await axios.get('/api/courses');
        courses.value = response.data.data;
        groups.value = courses.value.flatMap(course => course.groups || []);
    } catch (error) {
        console.error('Error fetching courses:', error);
    }
}
</script>

<template>
    <div class="container my-3" v-if="role === 'super_admin'">
        <h3>Courses</h3>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Course</th>
                <th>Price</th>
                <th>Number of group</th>
                <th>Number of lesson</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="course in courses">
                <td>{{course.title}}</td>
                <td>{{course.price}}</td>
                <td>{{course.groups ? course.groups.length : 0}}</td>
                <td>{{course.lessons ? course.lessons.length : 0}}</td>
            </tr>
            </tbody>
        </table>
        <div class="download-block text-end">
            <button class="btn btn-primary">Download table</button>
        </div>

        <h3>Groups</h3>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Group</th>
                <th>Number of students</th>
                <th>Number of teachers</th>
            </tr>
            <tr v-for="group in groups">
                <td><router-link :to="{name: 'group_detail_page_url', params: {id: group.id}}">{{group.title}}</router-link></td>
                <td>{{group?.students ? group.students.length : 0}}</td>
                <td>{{group?.teachers ? group.teachers.length : 0}}</td>
            </tr>
            </thead>
        </table>
        <div class="download-block text-end">
            <button class="btn btn-primary">Download table</button>
        </div>
    </div>
    <div class="container my-3" v-else>
        <h3>У вас недостаточно прав для просмотра!</h3>
    </div>
</template>

<style scoped>

</style>
