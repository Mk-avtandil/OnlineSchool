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
});

onMounted(async () => {
    try {
        const response = await axios.get(`/api/lessons/${route.params.id}/detail`);
        data.value = response.data.data;
        successMessage.value = '';
    } catch (error) {
        console.error("Failed to get lesson: ", error);
    }
});

const updateLesson = async (url = `/api/lessons/${route.params.id}`) => {
    try {
        errors.value = {};
        successMessage.value = '';

        await axios.put(url, {
            title: data.value.title,
            description: data.value.description,
        });

        successMessage.value = 'Lesson updated successfully!';

    } catch (error) {
        if (error.response && error.response.data && error.response.data.errors) {
            errors.value = error.response.data.errors;
        } else {
            console.error('Failed to update lesson');
        }
    }
};
</script>

<template>
    <div class="container my-3">
        <h3 class="mb-3">Update Lesson</h3>
        <div v-if="successMessage" class="alert alert-success">
            {{ successMessage }}
        </div>
        <form @submit.prevent="updateLesson()">
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

            <div class="form-group my-3">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</template>

<style scoped>

</style>
