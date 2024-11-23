<script setup>
import axios from "axios";
import {onMounted, ref} from "vue";
import {useRoute} from "vue-router";

const errors = ref({});
const students = ref([]);
const teachers = ref([]);
const successMessage = ref('');
const route = useRoute();
const data = ref({
    title: '',
    description: '',
    students: [],
    teachers: [],
});

onMounted(async () => {
    await fetchStudents();
    await fetchTeachers();
});

const fetchStudents = async () => {
    try {
        const response = await axios.get('/api/student');
        students.value = response.data;
    } catch (error) {
        console.error('Failed to fetch students', error);
    }
};

const fetchTeachers = async () => {
    try {
        const response = await axios.get('/api/teacher');
        teachers.value = response.data;
    } catch (error) {
        console.error('Failed to fetch teachers', error);
    }
};

const saveGroup = async () => {
    try {
        errors.value = {};
        successMessage.value = '';
        await axios.post(`/api/groups/${route.params.id}`, data.value);
        successMessage.value = 'Group created successfully!';

        setTimeout(() => {
            data.value = {
                title: '',
                description: '',
                students: [],
                teachers: [],
            };
        }, 1000);
    } catch (error) {
        if (error.response && error.response.data && error.response.data.errors) {
            errors.value = error.response.data.errors;
        } else {
            console.error('Failed to create group');
        }
    }
};

</script>
<template>
    <div class="container my-3">
        <h3 class="mb-3">Create Group</h3>
        <div v-if="successMessage" class="alert alert-success">
            {{ successMessage }}
        </div>
        <form @submit.prevent="saveGroup()">
            <div class="form-group my-2">
                <label>Title</label>
                <input v-model="data.title" type="text" class="form-control">
            </div>
            <div v-if="errors.title" class="alert alert-danger my-1">
                {{ errors.title[0] }}
            </div>

            <div class="form-group my-2">
                <label>Description</label>
                <input v-model="data.description" type="text" class="form-control">
            </div>
            <div v-if="errors.description" class="alert alert-danger my-1">
                {{ errors.description[0] }}
            </div>

            <div class="form-group my-2">
                <label for="students">Select Students</label>
                <select v-model="data.students" id="students" class="form-select" multiple>
                    <option v-for="student in students?.data" :key="student.id" :value="student.id">
                        {{ student.first_name }} {{ student.last_name }}
                    </option>
                </select>
            </div>
            <div v-if="errors.students" class="alert alert-danger my-1">
                {{ errors.students[0] }}
            </div>

            <div class="form-group my-2">
                <label for="students">Select Mentors</label>
                <select v-model="data.teachers" id="teachers" class="form-select" multiple>
                    <option v-for="teacher in teachers?.data" :key="teacher.id" :value="teacher.id">
                        {{ teacher.first_name }} {{ teacher.last_name }}
                    </option>
                </select>
            </div>
            <div v-if="errors.teachers" class="alert alert-danger my-1">
                {{ errors.teachers[0] }}
            </div>

            <div class="form-group my-3">
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
        </form>
    </div>

</template>

<style scoped>

</style>
