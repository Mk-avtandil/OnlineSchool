<script setup>
import { ref } from 'vue';
import axios from 'axios';

const props = defineProps({
    course: Object,
    student: Object,
    errors: Object,
});

const emit = defineEmits(['payment-created']);

const successMessage = ref('');
const localErrors = ref({});

const savePayment = async (courseId) => {
    try {
        localErrors.value = {};
        successMessage.value = '';

        await axios.post(`/api/payments/${courseId}`);

        emit('payment-created');

        successMessage.value = 'Payment created successfully!';
    } catch (error) {
        if (error.response && error.response.data) {
            if (error.response.data.errors) {
                localErrors.value = error.response.data.errors;
            } else if (error.response.data.error) {
                localErrors.value = { error: error.response.data.error };
            }
        } else {
            console.error('Failed to create payment');
        }
    }
}
</script>

<template>
    <div class="card my-1">
        <div class="row p-2">
            <div class="card-body col-9">
                <h5 class="card-title">{{course?.course.title}}</h5>
                <p class="card-text">{{course?.course.description}}</p>
                <p class="card-text">Price: {{course?.course.price}}</p>
            </div>
            <div class="card-body col-3">
                <h5 class="card-title">Pay for course</h5>

                <div v-if="successMessage" class="alert alert-success">
                    {{ successMessage }}
                </div>

                <div v-if="localErrors.error" class="alert alert-danger my-1">
                    {{ localErrors.error }}
                </div>

                <button @click.prevent="savePayment(course.course.id)" type="button" class="btn btn-primary w-100" v-if="student?.creditCard">
                    Оплатить
                </button>
                <button v-else type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#staticBackdropStudent">
                    Add Credit Card
                </button>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
