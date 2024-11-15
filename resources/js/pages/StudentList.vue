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
        const response = await axios.get('/api/student');
        students.value = response.data;
    } catch (error) {
        console.error('Error fetching students:', error);
    }
};

const deleteStudent = async (studentId) => {
    try {
        await axios.delete(`/api/student/${studentId}`);
        await getStudents();
        successMessage.value = 'Student deleted successfully!';
    } catch (error) {
        console.error('Failed to delete student:', error);
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
                <th scope="col">Phone</th>
                <th scope="col">Email</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="student in students?.data" class="align-middle">
                <th>
                    <router-link :to="{name: 'student_detail_page_url', params: {id: student.id}}" class="text-decoration-none">
                        {{student.first_name}} {{student.last_name}}
                    </router-link>
                </th>
                <td>{{student.birthday}}</td>
                <td>{{student.phone}}</td>
                <td>{{student.email}}</td>
                <td>
                    <router-link :to="{name: 'student_edit_page_url', params: {id: student.id}}" class="btn btn-warning">Edit</router-link>
                    <button @click.prevent="deleteStudent(student.id)" class="btn btn-danger m-1" type="submit">Delete</button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<style scoped>

</style>
