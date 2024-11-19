<script setup>
import axios from "axios";
import {computed, onMounted, ref} from "vue";
import { useRouter } from 'vue-router';

const schedules = ref();
const router = useRouter();

onMounted(async () => {
    await getSchedule();
});

const getSchedule = async (url = '/api/schedule') => {
    try {
        const response = await axios.get(url);
        schedules.value = response.data;

    } catch (error) {
        console.error('Error fetching schedule:', error);
    }
};
</script>

<template>
    <div class="container my-3">
        <div class="row">
            <div class="col-8">
                <span class="fs-3">Schedule</span>
            </div>
            <div class="col-4 text-end align-content-center">
                <router-link :to="{name: 'schedule_create_page_url'}" class="btn bg-body-tertiary px-2 py-1 border-dark">Create Schedule</router-link>
            </div>
        </div>

        <table class="table table-bordered my-3">
            <thead>
                <tr>
                    <th>№</th>
                    <th scope="col">Course</th>
                    <th scope="col">Group</th>
                    <th scope="col">Teacher</th>
                    <th scope="col">Start time</th>
                    <th scope="col">End time</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(schedule, index) in schedules?.data">
                    <td>{{index+1}}</td>
                    <td>{{schedule.course}}</td>
                    <td>{{schedule.group}}</td>
                    <td>{{schedule.teacher}}</td>
                    <td>{{schedule.start_time}}</td>
                    <td>{{schedule.end_time}}</td>
                </tr>
            </tbody>
        </table>
    </div>

</template>

<style scoped>

</style>
