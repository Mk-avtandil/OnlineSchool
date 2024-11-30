<script setup>
import axios from "axios";
import {ref} from "vue";
import {useRoute} from "vue-router";

const errors = ref({});
const successMessage = ref('');
const route = useRoute();
const data = ref({
    title: '',
    description: '',
    files: [],
});

const handleFileChange = (event) => {
    data.value.files = Array.from(event.target.files);
};

const saveLesson = async () => {
    try {
        errors.value = {};
        successMessage.value = '';

        const formData = new FormData();

        formData.append('title', data.value.title);
        formData.append('description', data.value.description);

        data.value.files.forEach(file => {
            formData.append('files[]', file);
        });

        await axios.post(`/api/lessons/${route.params.id}`, formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
            },
        });

        successMessage.value = 'Lesson created successfully!';

        setTimeout(() => {
            data.value = {
                title: '',
                description: '',
                files: [],
            };
        }, 1000);
    } catch (error) {
        if (error.response && error.response.data && error.response.data.errors) {
            errors.value = error.response.data.errors;
        } else {
            console.error('Failed to create lesson');
        }
    }
};
</script>

<template>
    <div class="container my-3">
        <h3 class="mb-3">Create Lesson</h3>

        <div v-if="successMessage" class="alert alert-success">
            {{ successMessage }}
        </div>

        <form @submit.prevent="saveLesson()">

            <div class="form-group my-2">
                <label for="title">Title</label>
                <input v-model="data.title" type="text" id="title" class="form-control" required>
            </div>
            <div v-if="errors.title" class="alert alert-danger my-1">
                {{ errors.title[0] }}
            </div>

            <div class="form-group my-2">
                <label for="description">Description</label>
                <textarea v-model="data.description" rows="5" class="form-control"></textarea>
            </div>
            <div v-if="errors.description" class="alert alert-danger my-1">
                {{ errors.description[0] }}
            </div>

            <div class="form-group my-2">
                <label for="files">Upload Files</label>
                <input type="file" @change="handleFileChange" id="files" class="form-control" multiple>
            </div>
            <div v-if="errors.files" class="alert alert-danger my-1">
                {{ errors.files[0] }}
            </div>

            <div class="form-group my-3">
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
        </form>
    </div>
</template>

<style scoped>
</style>
