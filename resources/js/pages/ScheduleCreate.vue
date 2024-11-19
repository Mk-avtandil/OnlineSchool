<script setup>
import axios from "axios";
import {onMounted, watch, ref} from "vue";

const errors = ref({});
const successMessage = ref('');
const courses = ref([]);
const teachers = ref([]);
const groups = ref([]);
const data = ref({
    course: '',
    group: '',
    teacher: '',
    start_time: '',
    end_time: '',
});

onMounted(async () => {
    await getCourses();
});

const getCourses = async (url = `/api/courses`) => {
    try {
        const response = await axios.get(url);
        courses.value = response.data.data;

    } catch (error) {
        console.error('Error fetching courses:', error);
    }
};

const getGroupsForCourse = async (courseId) => {
    try {
        const response = await axios.get(`/api/course/${courseId}/groups`);
        groups.value = response.data.data;
    } catch (error) {
        console.error('Error fetching groups:', error);
    }
};

const getTeachersForGroup = async (groupId) => {
    try {
        const response = await axios.get(`/api/group/${groupId}/teachers`);
        teachers.value = response.data;
    } catch (error) {
        console.error('Error fetching teachers:', error);
        teachers.value = [];
    }
};

const saveSchedule = async () => {
    try {
        errors.value = {};
        successMessage.value = '';

        await axios.post(`/api/schedule/store`, data.value);
        console.log('data')
        successMessage.value = 'Schedule created successfully!';

        setTimeout(() => {
            data.value = {
                course: '',
                group: '',
                teacher: '',
                start_time: '',
                end_time: '',
            };
        }, 1000);
    } catch (error) {
        if (error.response && error.response.data && error.response.data.errors) {
            errors.value = error.response.data.errors;
        } else {
            console.error('Failed to create schedule');
        }
    }
};

watch(() => data.value.course, (newCourseId) => {
    if (newCourseId) {
        getGroupsForCourse(newCourseId);
    } else {
        groups.value = [];
        teachers.value = [];
    }
});

watch(() => data.value.group, (newGroupId) => {
    if (newGroupId) {
        getTeachersForGroup(newGroupId);
    } else {
        teachers.value = [];
    }
});

</script>

<template>
    <div class="container my-3">
        <h3 class="mb-3">Create Schedule</h3>

        <div v-if="successMessage" class="alert alert-success">
            {{ successMessage }}
        </div>

        <form @submit.prevent="saveSchedule()">
            <div class="form-group">
                <label for="course">Course</label>
                <select v-model="data.course" id="course" class="form-control">
                    <option value="" disabled selected>Select a course</option>
                    <option v-for="course in courses" :key="course.id" :value="course.id">
                        {{ course.title }}
                    </option>
                </select>
            </div>
            <div v-if="errors.course" class="alert alert-danger my-1">
                {{ errors.course[0] }}
            </div>

            <div class="form-group">
                <label for="group">Group</label>
                <select v-model="data.group" id="group" class="form-control">
                    <option value="" disabled selected>Select a group</option>
                    <option v-for="group in groups" :key="group.id" :value="group.id">
                        {{ group.title }}
                    </option>
                </select>
            </div>
            <div v-if="errors.group" class="alert alert-danger my-1">
                {{ errors.group[0] }}
            </div>

            <div class="form-group">
                <label for="teacher">Teacher</label>
                <select v-model="data.teacher" id="teacher" class="form-control">
                    <option value="" disabled selected>Select a teacher</option>
                    <option v-for="teacher in teachers" :key="teacher.id" :value="teacher.id">
                        {{ teacher.first_name }}
                    </option>
                </select>
            </div>
            <div v-if="errors.teacher" class="alert alert-danger my-1">
                {{ errors.teacher[0] }}
            </div>

            <div class="form-group">
                <label for="start_time">Start Time</label>
                <input v-model="data.start_time" type="time" class="form-control" id="start_time">
            </div>
            <div v-if="errors.start_time" class="alert alert-danger my-1">
                {{ errors.start_time[0] }}
            </div>

            <div class="form-group">
                <label for="end_time">End Time</label>
                <input v-model="data.end_time" type="time" class="form-control" id="end_time">
            </div>
            <div v-if="errors.end_time" class="alert alert-danger my-1">
                {{ errors.end_time[0] }}
            </div>

            <div class="form-group my-3">
                <button type="submit" class="btn btn-primary">Create Schedule</button>
            </div>
        </form>
    </div>
</template>

<style scoped>

</style>
