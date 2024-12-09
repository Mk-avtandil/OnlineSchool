<script setup>
import axios from "axios";
import {ref, onMounted, computed} from "vue";
import {useRoute} from "vue-router";
import {useStore} from "vuex";

const store = useStore();
const user = computed(() => store.getters.user);
const errors = ref({});
const successMessage = ref('');
const route = useRoute();
const data = ref({
    title: '',
    description: '',
    price: '',
});

onMounted(async () => {
    try {
        data.value = (await axios.get( `/api/courses/${route.params.id}`)).data.data;
        successMessage.value = '';
    } catch (error) {
        console.error("Failed to get course: ", error);
    }
});

const updateCourse = async (url = `/api/courses/${route.params.id}`) => {
    try {
        errors.value = {};
        successMessage.value = '';

        await axios.put(url, {
            title: data.value.title,
            description: data.value.description,
            price: data.value.price,
        });

        successMessage.value = 'Course updated successfully!';
    } catch (error) {
        if (error.response && error.response.data && error.response.data.errors) {
            errors.value = error.response.data.errors;
        } else {
            console.error('Failed to update course');
        }
    }
};
</script>

<template>
    <div v-if="user?.role.includes('admin') || user?.role.includes('super_admin')">
        <div class="container my-3">
            <h3 class="mb-3">Update Course</h3>
            <div v-if="successMessage" class="alert alert-success">
                {{ successMessage }}
            </div>
            <form @submit.prevent="updateCourse()">
                <div class="form-group">
                    <label>Title</label>
                    <input v-model="data.title" type="text" class="form-control">
                </div>
                <div v-if="errors.title" class="alert alert-danger my-1">
                    {{ errors.title[0] }}
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea v-model="data.description" rows="5" class="form-control"></textarea>
                </div>
                <div v-if="errors.description" class="alert alert-danger my-1">
                    {{ errors.description[0] }}
                </div>

                <div class="form-group">
                    <label>Price</label>
                    <input v-model="data.price" type="text" class="form-control">
                </div>
                <div v-if="errors.price" class="alert alert-danger my-1">
                    {{ errors.price[0] }}
                </div>

                <div class="form-group my-3">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
    <div class="container my-3" v-else>
        <h3>У вас недостаточно прав для просмотра!</h3>
    </div>
</template>

<style scoped>

</style>
