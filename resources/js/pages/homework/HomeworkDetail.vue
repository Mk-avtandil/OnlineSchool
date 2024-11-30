<script setup>
import axios from "axios";
import {computed, onMounted, ref, reactive} from "vue";
import AssignGrade from "../../components/AssignGrade.vue";
import { useRoute } from 'vue-router';
import { useStore } from "vuex";

const store = useStore();
const user = computed( () => store.getters.user);
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

const getHomework = async (url = `/api/homeworks/${route.params.id}/detail`) => {
    try {
        const response = await axios.get(url);
        homework.value = response.data.data;

    } catch (error) {
        console.error('Error fetching homework:', error);
    }
};

const getSolutions = async (url = `/api/solutions/${route.params.id}`) => {
    try {
        const response = await axios.get(url);
        solutions.value = response.data.data;
        console.log(solutions);
    } catch (error) {
        console.error('Error fetching solutions');
    }
}

const handleFileChange = (event) => {
    data.value.files = Array.from(event.target.files);
};

const saveSolution = async (url = `/api/solutions/${route.params.id}`) => {
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
            <span class="fs-6">
                <button @click="$router.go(-1)" class="btn btn-outline-dark">Назад</button>
            </span>
            <span class="fs-3 mx-2 align-middle">Homework</span>
            <div class="card-group mt-3">
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

        <div class="col-12" v-if="user?.data.role.includes('student')">
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

        <div class="col-12 my-2" v-if="user?.data.role.includes('teacher')">
            <h3>Students solution</h3>
            <div v-for="solution in solutions" :key="solution.id" class="card my-3">
                <div class="card-header">
                    <span>Student: </span>
                    <router-link :to="{name: 'student_detail_page_url', params: {id: solution.student.id}}" class="text-decoration-none">
                        {{solution.student.first_name}} {{solution.student.last_name}}
                    </router-link>
                </div>
                <div class="card-body">
                    <h6>Answer: </h6>
                    <p>{{solution.answer}}</p>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-6">
                            <div v-if="solution.materials.length" v-for="material in solution.materials" :key="material.id">
                                <a class="p-0 text-decoration-none text-info" :href="material.url" :download="material.name">
                                    Download {{ material.name }}
                                </a>
                            </div>
                            <div v-else>No materials</div>
                        </div>
                        <div class="col-6">
                            <AssignGrade
                                :solution="solution"
                                :errors="errors"
                                @grade-saved="getSolutions" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<style scoped>

</style>
