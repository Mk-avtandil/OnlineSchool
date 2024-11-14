<script setup>
import axios from "axios";
import { ref, onMounted } from "vue";
import { useRoute } from "vue-router";

const errors = ref({});
const successMessage = ref('');
const route = useRoute();
const data = ref({
    first_name: '',
    last_name: '',
    birthday: '',
    address: '',
    phone: '',
    email: '',
});

onMounted(async () => {
    try {
        const response = await axios.get(`/api/student/${route.params.id}`);
        data.value = response.data.data;
        successMessage.value = '';
    } catch (error) {
        console.error("Failed to get student: ", error);
    }
});

const updateStudent = async (url = `/api/student/${route.params.id}`) => {
    try {
        errors.value = {};
        successMessage.value = '';

        await axios.put(url, {
            first_name: data.value.first_name,
            last_name: data.value.last_name,
            birthday: data.value.birthday,
            address: data.value.address,
            phone: data.value.phone,
            email: data.value.email,
        });

        successMessage.value = 'Student updated successfully!';
    } catch (error) {
        if (error.response && error.response.data && error.response.data.errors) {
            errors.value = error.response.data.errors;
        } else {
            console.error('Failed to update student');
        }
    }
};
</script>

<template>
    <div class="container my-3">
        <h3 class="mb-3">Update Student</h3>
        <div v-if="successMessage" class="alert alert-success">
            {{ successMessage }}
        </div>
        <form @submit.prevent="updateStudent()">
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
                <label>Address</label>
                <input v-model="data.address" type="text" class="form-control">
            </div>
            <div v-if="errors.address" class="alert alert-danger my-1">
                {{ errors.address[0] }}
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

            <div class="form-group my-3">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>

</template>

<style scoped>

</style>
