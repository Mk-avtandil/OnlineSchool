<script setup>
import axios from "axios";
import {onMounted, ref} from "vue";
import { useRoute } from 'vue-router';

const groups = ref({});
const route = useRoute();

onMounted(async () => {
    groups.value = (await axios.get(`/api/courses/${route.params.id}/groups`)).data;
});
</script>

<template>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container">
            <a class="navbar-brand" href="#">School</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Students</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-4">
        <h2>Группы курса </h2>
        <div class="card-group">
            <div class="card" v-for="group in groups?.data">
                <div class="card-body text-secondary">
                    <h5 class="card-title">{{group.title}}</h5>
                    <p class="card-text">{{group.description}}</p>

                    <div class="span">Студенты группы:</div>
                    <div>
                        <button v-for="student in group.students" type="button" class="btn btn-primary p-1 m-1">
                            {{student.first_name}} {{student.last_name}}
                        </button>
                    </div>

                    <div class="span">Менторы группы:</div>
                    <div>
                        <button v-for="teacher in group.teachers" type="button" class="btn btn-primary p-1 m-1">
                            {{teacher.first_name}} {{teacher.last_name}}
                        </button>
                    </div>
                </div>
                <div class="card-footer">
                    <span>Start time: {{group.start_time}}</span><br>
                    <span>End time: {{group.end_time}}</span>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
