<script setup>
import axios from "axios";
import {onMounted, ref} from "vue";

const teachers = ref();

onMounted(async () => {
    await getTeachers();
});

const getTeachers = async () => {
    try {
        const response = await axios.get('/api/teacher');
        teachers.value = response.data;
    } catch (error) {
        console.error('Error fetching teachers:', error);
    }
};

const deleteTeacher = async (teacherId) => {
    try {
        await axios.delete(`/api/teacher/${teacherId}`);
        await getTeachers();
        successMessage.value = 'Teacher deleted successfully!';
    } catch (error) {
        console.error('Failed to delete teacher:', error);
    }
};
</script>

<template>
    <div class="container my-3">
        <div class="row">
            <div class="col-8">
                <h3 class="mb-2">Teachers</h3>
            </div>
            <div class="col-4 text-end">
                <router-link :to="{name: 'teacher_create_page_url'}" class="btn bg-body-tertiary px-2 py-1 border-dark">Add New Teacher</router-link>
            </div>
        </div>

        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col">Full name</th>
                <th scope="col">Birthday</th>
                <th scope="col">Phone</th>
                <th scope="col">Email</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="teacher in teachers?.data" class="align-middle">
                <th>{{teacher.first_name}} {{teacher.last_name}}</th>
                <td>{{teacher.phone}}</td>
                <td>{{teacher.phone}}</td>
                <td>{{teacher.email}}</td>
                <td>
                    <router-link :to="{name: 'teacher_edit_page_url', params: {id: teacher.id}}" class="btn btn-warning">Edit</router-link>
                    <button @click.prevent="deleteTeacher(teacher.id)" class="btn btn-danger m-1" type="submit">Delete</button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<style scoped>

</style>
