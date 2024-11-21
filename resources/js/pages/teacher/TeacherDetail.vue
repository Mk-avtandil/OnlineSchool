<script setup>
import axios from "axios";
import {onMounted, ref} from "vue";
import { useRoute } from 'vue-router';

const route = useRoute();
const errors = ref({});
const teacher = ref();
const successMessage = ref('');


onMounted(async () => {
    await getTeacher();
});

const getTeacher = async (url = `/api/teacher/${route.params.id}`) => {
    try {
        const response = await axios.get(url);
        teacher.value = response.data.data;

    } catch (error) {
        console.error('Error fetching teacher:', error);
    }
};

</script>

<template>
    <div class="container my-4">
        <div class="row">
            <div class="col-12 mb-4">
                <h3 class="mb-2">Teacher</h3>
                <table class="table table-bordered fw-medium">
                    <tr>
                        <th>First name</th>
                        <td>{{teacher?.first_name}}</td>
                    </tr>
                    <tr>
                        <th>Last name</th>
                        <td>{{teacher?.last_name}}</td>
                    </tr>
                    <tr>
                        <th>Birthday</th>
                        <td>{{teacher?.birthday}}</td>
                    </tr>
                    <tr>
                        <th>Phone</th>
                        <td>{{teacher?.phone}}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
