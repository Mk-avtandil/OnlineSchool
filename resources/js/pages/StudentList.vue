<script setup>
import axios from "axios";
import {onMounted, ref} from "vue";
import { useRouter } from 'vue-router';

const students = ref();
const router = useRouter();

onMounted(async () => {
    await getStudents();
});

const getStudents = async () => {
    try {
        const response = await axios.get('/api/students');
        students.value = response.data;
    } catch (error) {
        console.error('Error fetching students:', error);
    }
};
</script>

<template>
    <div class="container my-3">
        <div class="row">
            <div class="col-8">
                <h3 class="mb-2">Students</h3>
            </div>
            <div class="col-4 text-end">
                <router-link :to="{name: 'student_create_page_url'}" class="btn bg-body-tertiary px-2 py-1 border-dark">Add New Student</router-link>
            </div>
        </div>


        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col">Full name</th>
                <th scope="col">Birthday</th>
                <th scope="col">Address</th>
                <th scope="col">Phone</th>
                <th scope="col">Email</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="student in students?.data">
                <th>{{student.first_name}} {{student.last_name}}</th>
                <td>{{student.birthday}}</td>
                <td>{{student.address}}</td>
                <td>{{student.phone}}</td>
                <td>{{student.email}}</td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<style scoped>

</style>
