<script setup>
import axios from "axios";
import { ref, onMounted } from "vue";
import { useRoute } from "vue-router";

const errors = ref({});
const successMessage = ref('');
const availableStudents = ref([]);
const selectedStudents = ref([]);
const route = useRoute();
const data = ref({
    title: '',
    description: '',
    start_time: '',
    end_time: '',
    students: [],
});

onMounted(async () => {
    await getGroup();
    await getStudents();
});

const getGroup = async (url = `/api/group/${route.params.id}`) => {
    try {
        const response = await axios.get(url);
        data.value = response.data.data;
    } catch (error) {
        console.error("Failed to get groups: ", error);
    }
};

const getStudents = async (url = '/api/student') => {
    try {
        const response = await axios.get(url);
        availableStudents.value = response.data.data.filter(student =>
            !data.value.students.some(groupStudent => groupStudent.id === student.id)
        );
    } catch (error) {
        console.error("Failed to get students: ", error);
    }
};

const updateGroup = async (url = `/api/group/${route.params.id}`) => {
    try {
        errors.value = {};
        successMessage.value = '';

        const response = await axios.put(url, {
            title: data.value.title,
            description: data.value.description,
            start_time: data.value.start_time,
            end_time: data.value.end_time,
            students: [data.value.students, selectedStudents.value],
        });

        successMessage.value = 'Group updated successfully!';

        await getGroup();
        await getStudents();

    } catch (error) {
        console.error('Failed to update group:', error);
        if (error.response && error.response.data && error.response.data.errors) {
            errors.value = error.response.data.errors;
        }
    }
};
</script>

<template>
    <div class="container my-3">
        <h3 class="mb-3">Update Group</h3>
        <div v-if="successMessage" class="alert alert-success">
            {{ successMessage }}
        </div>
        <form @submit.prevent="updateGroup()">
            <div class="form-group my-2">
                <label>Title</label>
                <input v-model="data.title" type="text" class="form-control">
            </div>
            <div v-if="errors.title" class="alert alert-danger my-1">
                {{ errors.title[0] }}
            </div>

            <div class="form-group my-2">
                <label>Description</label>
                <textarea v-model="data.description" rows="5" class="form-control"></textarea>
            </div>
            <div v-if="errors.description" class="alert alert-danger my-1">
                {{ errors.description[0] }}
            </div>

            <div class="form-group my-2">
                <label>Start time</label>
                <input v-model="data.start_time" type="time" class="form-control">
            </div>
            <div v-if="errors.start_time" class="alert alert-danger my-1">
                {{ errors.start_time[0] }}
            </div>

            <div class="form-group my-2">
                <label>End time</label>
                <input v-model="data.end_time" type="time" class="form-control">
            </div>
            <div v-if="errors.end_time" class="alert alert-danger my-1">
                {{ errors.end_time[0] }}
            </div>

            <div class="form-group my-2">
                <div class="row">
                    <div class="col-6">
                        <label>Students in Group</label>
                        <div>
                            <a v-for="student in data.students" :key="student.id" class="btn btn-warning my-1"
                               style="margin-right: 3px;">
                                {{ student.first_name }} {{ student.last_name }}
                            </a>
                        </div>
                    </div>
                    <div class="col-6">
                        <label>Add Students to Group</label>
                        <ul class="scrollable-list list-group">
                            <li class="list-group-item" v-for="student in availableStudents" :key="student.id">
                                <input class="form-check-input me-1" type="checkbox" :id="'checkbox-' + student.id"
                                       :value="student.id" v-model="selectedStudents">
                                <label class="form-check-label" :for="'checkbox-' + student.id">
                                    {{ student.first_name }} {{ student.last_name }}
                                </label>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="form-group my-3">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</template>

<style scoped>
.scrollable-list {
    max-height: 200px;
    overflow-y: auto;
    padding: 5px;
}
</style>
