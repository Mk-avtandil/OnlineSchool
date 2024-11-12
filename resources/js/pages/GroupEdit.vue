<script setup>
import axios from "axios";
import { ref, onMounted } from "vue";
import { useRoute } from "vue-router";

const errors = ref({});
const successMessage = ref('');
const route = useRoute();
const data = ref({
    title: '',
    description: '',
    start_time: '',
    end_time: '',
});

onMounted(async () => {
    try {
        const response = await axios.get(`/api/group/${route.params.id}`);
        data.value = response.data.data;
        successMessage.value = '';
    } catch (error) {
        console.error("Failed to get group: ", error);
    }
});

const updateGroup = async (url = `/api/group/${route.params.id}`) => {
    try {
        errors.value = {};
        successMessage.value = '';

        await axios.put(url, {
            title: data.value.title,
            description: data.value.description,
            start_time: data.value.start_time,
            end_time: data.value.end_time,
        });

        successMessage.value = 'Group updated successfully!';

        setTimeout(() => {
            data.value = {
                title: '',
                description: '',
                start_time: '',
                end_time: '',
            };
        }, 1000);
    } catch (error) {
        if (error.response && error.response.data && error.response.data.errors) {
            errors.value = error.response.data.errors;
        } else {
            console.error('Failed to update group');
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

            <div class="form-group my-3">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>

</template>

<style scoped>

</style>
