<script setup>
import axios from "axios";
import {ref} from "vue";

const errors = ref({});
const successMessage = ref('');
const data = ref({
        first_name: '',
        last_name: '',
        birthday: '',
        phone: '',
        email: '',
        password: '',
});

const saveStudent = async () => {
    try {
        errors.value = {};
        successMessage.value = '';

        await axios.post(`/api/student/store`, data.value);
        successMessage.value = 'Student created successfully!';

        setTimeout(() => {
            data.value = {
                first_name: '',
                last_name: '',
                birthday: '',
                phone: '',
                email: '',
                password: '',
            };
        }, 1000);
    } catch (error) {
        if (error.response && error.response.data && error.response.data.errors) {
            errors.value = error.response.data.errors;
        } else {
            console.error('Failed to create student');
        }
    }
};

</script>

<template>
    <div class="container my-3">
        <h3 class="mb-3">Create Student</h3>
        <div v-if="successMessage" class="alert alert-success">
            {{ successMessage }}
        </div>
        <form @submit.prevent="saveStudent()">
            <div class="form-group">
                <label>First name</label>
                <input v-model="data.first_name" type="text" class="form-control">
            </div>
            <div v-if="errors.first_name" class="alert alert-danger my-1">
                {{ errors.first_name[0] }}
            </div>

            <div class="form-group">
                <label>Last name</label>
                <input v-model="data.last_name" type="text" class="form-control">
            </div>
            <div v-if="errors.last_name" class="alert alert-danger my-1">
                {{ errors.last_name[0] }}
            </div>

            <div class="form-group">
                <label>Birthday</label>
                <input v-model="data.birthday" type="date" class="form-control">
            </div>
            <div v-if="errors.birthday" class="alert alert-danger my-1">
                {{ errors.birthday[0] }}
            </div>

            <div class="form-group">
                <label>Phone</label>
                <input v-model="data.phone" type="text" class="form-control">
            </div>
            <div v-if="errors.phone" class="alert alert-danger my-1">
                {{ errors.phone[0] }}
            </div>

            <div class="form-group">
                <label>Email</label>
                <input v-model="data.email" type="email" class="form-control">
            </div>
            <div v-if="errors.email" class="alert alert-danger my-1">
                {{ errors.email[0] }}
            </div>

            <div class="form-group">
                <label>Password</label>
                <input v-model="data.password" type="password" class="form-control">
            </div>
            <div v-if="errors.password" class="alert alert-danger my-1">
                {{ errors.password[0] }}
            </div>

            <div class="form-group my-3">
                <button type="submit" class="btn btn-primary">Создать</button>
            </div>
        </form>
    </div>

</template>

<style scoped>

</style>
