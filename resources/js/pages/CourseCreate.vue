<script setup>
import axios from "axios";
import {ref} from "vue";

const errors = ref({});
const successMessage = ref('');
const data = ref({
    title: '',
    description: '',
    price: '',
});

const saveCourse = async () => {
    try {
        errors.value = {};
        successMessage.value = '';

        await axios.post(`/api/courses/store`, data.value);
        successMessage.value = 'Course created successfully!';

        setTimeout(() => {
            data.value = {
                title: '',
                description: '',
                price: '',
            };
        }, 1000);
    } catch (error) {
        if (error.response && error.response.data && error.response.data.errors) {
            errors.value = error.response.data.errors;
        } else {
            console.error('Failed to create course');
        }
    }
};

</script>
<template>
    <div class="container my-3">
        <h3 class="mb-3">Create Course</h3>
        <div v-if="successMessage" class="alert alert-success">
            {{ successMessage }}
        </div>
        <form @submit.prevent="saveCourse">
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
                <label>Price</label>
                <input v-model="data.price" type="text" class="form-control">
            </div>
            <div v-if="errors.price" class="alert alert-danger my-1">
                {{ errors.price[0] }}
            </div>

            <div class="form-group my-3">
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
        </form>
    </div>

</template>

<style scoped>

</style>
