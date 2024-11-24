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
    deadline: '',
});

const saveHomework = async () => {
    try {
        errors.value = {};
        successMessage.value = '';
        await axios.post(`/api/homeworks/${route.params.id}`, data.value);
        successMessage.value = 'Homework created successfully!';

        setTimeout(() => {
            data.value = {
                title: '',
                description: '',
                deadline: '',
            };
        }, 1000);
    } catch (error) {
        if (error.response && error.response.data && error.response.data.errors) {
            errors.value = error.response.data.errors;
        } else {
            console.error('Failed to create homework');
        }
    }
};
</script>
<template>
    <div class="container my-3">
        <h3 class="mb-3">Create Homework</h3>
        <div v-if="successMessage" class="alert alert-success">
            {{ successMessage }}
        </div>
        <form @submit.prevent="saveHomework()">
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
                <label>Deadline</label>
                <input v-model="data.deadline" type="date" class="form-control">
            </div>
            <div v-if="errors.deadline" class="alert alert-danger my-1">
                {{ errors.deadline[0] }}
            </div>

            <div class="form-group my-3">
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
        </form>
    </div>
</template>

<style scoped>

</style>
