<script setup>
import axios from "axios";
import {onMounted, ref} from "vue";
import {useRoute} from "vue-router";

const errors = ref({});
const students = ref([]);
const successMessage = ref('');
const route = useRoute();
const data = ref({
    title: '',
    description: '',
    start_time: '',
    end_time: '',
    students: [],
});

onMounted(async () => {
    await fetchStudents();
});

const fetchStudents = async () => {
    try {
        const response = await axios.get('/api/students');
        students.value = response.data;
    } catch (error) {
        console.error('Failed to fetch students', error);
    }
};

const saveGroup = async () => {
    try {
        errors.value = {};
        successMessage.value = '';

        await axios.post(`/api/groups/${route.params.id}/store`, data.value);
        successMessage.value = 'Group created successfully!';

        setTimeout(() => {
            data.value = {
                title: '',
                description: '',
                start_time: '',
                end_time: '',
                students: [],
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
        <form @submit.prevent="saveGroup">
            <div class="form-group">
                <label>Title</label>
                <input v-model="data.title" type="text" class="form-control">
            </div>
            <div v-if="errors.title" class="alert alert-danger my-1">
                {{ errors.title[0] }}
            </div>

            <div class="form-group">
                <label>Description</label>
                <input v-model="data.description" type="text" class="form-control">
            </div>
            <div v-if="errors.description" class="alert alert-danger my-1">
                {{ errors.description[0] }}
            </div>

            <div class="form-group">
                <label>Start time</label>
                <input v-model="data.start_time" type="time" class="form-control">
            </div>
            <div v-if="errors.start_time" class="alert alert-danger my-1">
                {{ errors.start_time[0] }}
            </div>

            <div class="form-group">
                <label>End time</label>
                <input v-model="data.end_time" type="time" class="form-control">
            </div>
            <div v-if="errors.end_time" class="alert alert-danger my-1">
                {{ errors.end_time[0] }}
            </div>

            <div class="form-group">
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

            <div class="form-group my-3">
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
        </form>
    </div>

</template>

<style scoped>

</style>
