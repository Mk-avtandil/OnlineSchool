<script setup>
import axios from "axios";
import {computed, onMounted, ref} from "vue";
import { useStore } from "vuex";

const store = useStore();
const user = computed(() => store.getters.user);
const teachers = computed( () => store.getters.teachers);

onMounted(async () => {
    await store.dispatch('fetchTeachers');
});

const deleteTeacher = async (teacherId) => {
    try {
        await axios.delete(`/api/teachers/${teacherId}`);
        await store.dispatch('fetchTeachers');
        successMessage.value = 'Teacher deleted successfully!';
    } catch (error) {
        console.error('Failed to delete teacher:', error);
    }
};
</script>

<template>
    <div class="container my-3" v-if="user?.role.includes('admin') || user?.role.includes('super_admin')">
        <div class="row">
            <div class="col-8">
                <span class="fs-3">Teachers</span>
            </div>
            <div class="col-4 text-end align-content-center" v-if="user?.role.includes('super_admin')">
                <router-link :to="{name: 'teacher_create_page_url'}" class="btn bg-body-tertiary px-2 py-1 border-dark">Add New Teacher</router-link>
            </div>
        </div>

        <table class="table table-hover my-3">
            <thead>
            <tr>
                <th scope="col">Full name</th>
                <th scope="col">Birthday</th>
                <th scope="col">Phone</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="teacher in teachers?.data" class="align-middle">
                <th>{{teacher.first_name}} {{teacher.last_name}}</th>
                <td>{{teacher.birthday}}</td>
                <td>{{teacher.phone}}</td>
                <td v-if="user?.role.includes('super_admin')">
                    <router-link :to="{name: 'teacher_edit_page_url', params: {id: teacher.id}}" class="btn btn-warning">Edit</router-link>
                    <button @click.prevent="deleteTeacher(teacher.id)" class="btn btn-danger m-1" type="submit">Delete</button>
                </td>
                <td v-else></td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="container my-3" v-else>
        <h3>У вас недостаточно прав для просмотра!</h3>
    </div>
</template>

<style scoped>

</style>
