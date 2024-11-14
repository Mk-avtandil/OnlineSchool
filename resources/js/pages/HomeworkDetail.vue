<script setup>
import axios from "axios";
import {onMounted, ref} from "vue";
import { useRoute } from 'vue-router';

const homework = ref();
const route = useRoute();
const errors = ref({});
const successMessage = ref('');

const data = ref({
    answer: '',
    files: [],
});

onMounted(async () => {
    await getHomework();
});

const getHomework = async (url = `/api/homework/${route.params.id}`) => {
    try {
        const response = await axios.get(url);
        homework.value = response.data.data;

    } catch (error) {
        console.error('Error fetching homework:', error);
    }
};

const handleFileChange = (event) => {
    data.value.files = Array.from(event.target.files);
};

const saveSolution = async (url = `/api/homework/${route.params.id}/solution/store`) => {
    try {
        errors.value = {};
        successMessage.value = '';

        const formData = new FormData();

        formData.append('answer', data.value.answer);

        data.value.files.forEach(file => {
            formData.append('files[]', file);
        });

        await axios.post(url, formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
            },
        });

        successMessage.value = 'Solution created successfully!';

        setTimeout(() => {
            data.value = {
                answer: '',
                files: [],
            }}, 1000);
    } catch (error) {
        if (error.response && error.response.data && error.response.data.errors) {
            errors.value = error.response.data.errors;
        } else {
            console.error('Failed to create solution');
        }
    }
}
</script>

<template>
    <div class="container my-4">
        <div class="row">
            <div class="col-12 mb-4">
                <h3 class="mb-2">Homework</h3>
                <div class="card-group">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title text-dark">{{homework?.title}}</h5>
                        </div>
                        <div class="card-body text-secondary">
                            <p class="card-text">{{homework?.description}}</p>
                        </div>
                        <div class="card-footer">
                            <p class="card-text">Deadline: {{homework?.deadline}}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <h3 class="">Solution</h3>
                <div v-if="successMessage" class="alert alert-success">
                    {{ successMessage }}
                </div>

                <form @submit.prevent="saveSolution()">
                    <div class="form-group">
                        <label>Answer</label>
                        <textarea v-model="data.answer" id="answer" class="form-control" required></textarea>
                    </div>
                    <div v-if="errors.answer" class="alert alert-danger my-1">
                        {{ errors.answer[0] }}
                    </div>

                    <div class="form-group my-2">
                        <label for="files">Upload Files</label>
                        <input type="file" @change="handleFileChange" id="files" class="form-control" multiple>
                    </div>
                    <div v-if="errors.files" class="alert alert-danger my-1">
                        {{ errors.files[0] }}
                    </div>

                    <div class="form-group my-3">
                        <button type="submit" class="btn btn-primary">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
