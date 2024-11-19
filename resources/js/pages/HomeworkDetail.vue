<script setup>
import axios from "axios";
import {computed, onMounted, ref} from "vue";
import { useRoute } from 'vue-router';
import { useStore } from "vuex";

const store = useStore();
const role = computed(() => store.getters.role);
const homework = ref();
const solutions = ref();
const grades = ref();
const route = useRoute();
const errors = ref({});
const successMessage = ref('');

const data = ref({
    answer: '',
    files: [],
});

const gradeData = ref( {
    grade: '',
    feedback: '',
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

const getSolutions = async (url = `/api/homework/${route.params.id}/solutions`) => {
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

const saveGrade = async (solutionId, studentId) => {
    try {
        errors.value = {};

        await axios.post(`/api/grade/${solutionId}/${studentId}`, gradeData.value);
        await getSolutions();

    } catch (error) {
        if (error.response && error.response.data && error.response.data.errors) {
            errors.value = error.response.data.errors;
        } else {
            console.error('Failed to create grade');
        }
    }
};
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
            <div class="col-12" v-if="role === 'student'">
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

            <h3 v-if="role === 'teacher'">Students solution</h3>
            <div class="col-12 my-2" v-for="solution in solutions" v-if="role === 'teacher'">
                <div class="card">
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
                                <div v-if="solution.grade" class="text-success align-content-center">
                                    <h6>Grade: {{solution.grade.grade}}</h6>
                                    <h6>Feedback: {{solution.grade.feedback}}</h6>
                                </div>
                                <div v-else>
                                    <form @submit.prevent="saveGrade(solution.id, solution.student.id)">
                                        <div class="form-group">
                                            <label>Grade</label>
                                            <input v-model="gradeData.grade" class="form-control" type="text">
                                        </div>
                                        <div v-if="errors.grade" class="alert alert-danger my-1">
                                            {{ errors.grade[0] }}
                                        </div>

                                        <div class="form-group">
                                            <label>Feedback</label>
                                            <textarea v-model="gradeData.feedback" class="form-control" required></textarea>
                                        </div>
                                        <div v-if="errors.feedback" class="alert alert-danger my-1">
                                            {{ errors.feedback[0] }}
                                        </div>

                                        <div class="form-group my-3">
                                            <button type="submit" class="btn btn-primary">Send</button>
                                        </div>
                                    </form>
                                </div>
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
