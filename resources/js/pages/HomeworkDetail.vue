<script setup>
import axios from "axios";
import {onMounted, ref} from "vue";
import { useRoute } from 'vue-router';

const homework = ref();
const solutions = ref();
const route = useRoute();
const errors = ref({});
const successMessage = ref('');

const data = ref({
    answer: '',
    files: [],
});

onMounted(async () => {
    await getHomework();
    await getSolutions();
});

const getHomework = async (url = `/api/homework/${route.params.id}`) => {
    try {
        const response = await axios.get(url);
        homework.value = response.data.data;

    } catch (error) {
        console.error('Error fetching homework:', error);
    }
};

const getSolutions = async (url = `/api/solutions`) => {
    try {
        const response = await axios.get(url);
        solutions.value = response.data.data;
    } catch (error) {
        console.error('Error fetching solutions');
    }
}

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
                <h3>Create solution</h3>
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

            <div class="row">
                <div class="col-12 my-2" v-for="group in student?.groups">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">{{group?.title}}</h4>
                        </div>
                        <div class="card-footer">
                            <span>Start time: {{group?.start_time}}</span><br>
                            <span>End time: {{group?.end_time}}</span>
                        </div>
                    </div>
                </div>
            </div>

            <h3>Students solution</h3>
            <div class="col-12 my-2" v-for="solution in solutions">
                <div class="card">
                    <div class="card-header">
                        <table class="table">
                            <tr>
                                <th>First name</th>
                                <th>Last name</th>
                                <th>email</th>
                                <th>phone</th>
                            </tr>
                            <tr>
                                <td class="w-25">{{solution.student.first_name}}</td>
                                <td class="w-25">{{solution.student.last_name}}</td>
                                <td class="w-25">{{solution.student.email}}</td>
                                <td class="w-25">{{solution.student.phone}}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="card-body">
                        <h5>Answer: </h5>
                        <p>{{solution.answer}}</p>
                    </div>
                    <div class="card-footer">
                        <div v-if="solution.materials.length" v-for="material in solution.materials" :key="material.id">
                            <a class="p-0 text-decoration-none text-info" :href="material.url" :download="material.name">
                                Download {{ material.name }}
                            </a>
                        </div>
                        <div v-else>No materials</div>
                        <button class="w-100 my-2 btn btn-outline-primary">Feedback</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
