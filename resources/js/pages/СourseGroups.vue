<script setup>
import axios from "axios";
import {onMounted, ref} from "vue";
import { useRoute } from 'vue-router';

const groups = ref({});
const route = useRoute();

onMounted(async () => {
    groups.value = (await axios.get(`/api/groups/${route.params.id}`)).data;
});
</script>

<template>
    <div class="container my-4">
        <div class="row">
            <div class="col-8">
                <h3 class="mb-2">Course groups</h3>
            </div>
            <div class="col-4 text-end">
                <router-link :to="{name: 'group_create_page_url'}" class="btn bg-body-tertiary px-2 py-1 border-dark">Add New Group</router-link>
            </div>
        </div>
        <div class="card-group" v-for="group in groups?.data">
            <div class="card my-3">
                <div class="card-body text-secondary">
                    <h5 class="card-title">{{group.title}}</h5>
                    <p class="card-text">{{group.description}}</p>

                    <span>Менторы группы:</span>
                    <div>
                        <button v-for="teacher in group.teachers" type="button" class="bg-success rounded-4 text-light p-2">
                            {{teacher.first_name}} {{teacher.last_name}}
                        </button>
                    </div>

                    <span>Студенты группы:</span>
                    <div>
                        <button v-for="student in group.students" type="button" class="bg-success rounded-4 text-light p-2">
                            {{student.first_name}} {{student.last_name}}
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
