<script setup>
import axios from "axios";
import {onMounted, ref} from "vue";
import { useRoute } from 'vue-router';

const route = useRoute();
const errors = ref({});
const student = ref();
const studentCourses = ref();
const successMessage = ref('');

onMounted(async () => {
    await getStudent();
    await getStudentCourses();
});

const getStudent = async (url = `/api/students/${route.params.id}`) => {
    try {
        const response = await axios.get(url);
        student.value = response.data.data;

    } catch (error) {
        console.error('Error fetching student:', error);
    }
};

const getStudentCourses = async (url = '/api/courses') => {
    try {
        const response = await axios.get(url);
        studentCourses.value = response.data.data
    } catch (error) {
        console.error('Error fetching courses', error.response || error);
    }
}

const savePayment = async (url = `/api/payments/${route.params.id}`) => {
    try {
        errors.value = {};
        successMessage.value = '';

        await axios.post(url);
        successMessage.value = 'Payment created successfully!';
    } catch (error) {
        if (error.response && error.response.data) {
            if (error.response.data.errors) {
                errors.value = error.response.data.errors;
            } else if (error.response.data.error) {
                errors.value = {error: error.response.data.error};
            }
        } else {
            console.error('Failed to create payment');
        }
    }
}
</script>

<template>
    <div class="container my-4">
        <div class="row">
            <div class="col-12 mb-4">
                <h3 class="mb-2">Student</h3>
                <table class="table table-bordered fw-medium">
                    <tr>
                        <th>First name</th>
                        <td>{{student?.first_name}}</td>
                    </tr>
                    <tr>
                        <th>Last name</th>
                        <td>{{student?.last_name}}</td>
                    </tr>
                    <tr>
                        <th>Birthday</th>
                        <td>{{student?.birthday}}</td>
                    </tr>
                    <tr>
                        <th>Phone</th>
                        <td>{{student?.phone}}</td>
                    </tr>
                </table>
            </div>

            <div class="col-12">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-course-tab" data-bs-toggle="tab" data-bs-target="#nav-course" type="button" role="tab" aria-controls="nav-course" aria-selected="true">Student courses</button>
                        <button class="nav-link" id="nav-groups-tab" data-bs-toggle="tab" data-bs-target="#nav-groups" type="button" role="tab" aria-controls="nav-groups" aria-selected="false">Student groups</button>
                        <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Grades</button>
                        <button class="nav-link" id="nav-card-tab" data-bs-toggle="tab" data-bs-target="#nav-card" type="button" role="tab" aria-controls="nav-card" aria-selected="false">Credit card</button>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active my-3" id="nav-course" role="tabpanel" aria-labelledby="nav-course-tab" tabindex="0">
                        <div v-for="course in studentCourses">
                            <div class="card my-1">
                                <div class="row p-2">
                                    <div class="card-body col-9">
                                        <h5 class="card-title">{{course?.title}}</h5>
                                        <p class="card-text">{{course?.description}}</p>
                                        <p class="card-text">Price: {{course?.price}}</p>
                                    </div>
                                    <div class="card-body col-3">
                                        <h5 class="card-title">Pay for course</h5>
                                        <div v-if="successMessage" class="alert alert-success">
                                            {{ successMessage }}
                                        </div>
                                        <div v-if="errors.error" class="alert alert-danger my-1">
                                            {{ errors.error }}
                                        </div>
                                        <button @click.prevent="savePayment()" type="button" class="btn btn-primary w-100" v-if="student?.creditCard">
                                            Оплатить
                                        </button>
                                        <button class="btn btn-primary w-100" v-else>Добавить карту</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade my-3" id="nav-groups" role="tabpanel" aria-labelledby="nav-groups-tab" tabindex="1">
                        <div class="row">
                            <div class="col-12 my-2" v-for="group in student?.groups">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">{{group?.title}}</h4>
                                        <p class="card-text">{{group?.description}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-card" role="tabpanel" aria-labelledby="nav-card-tab" tabindex="2">
                        <div class="row">
                            <div class="col-12">
                                <div class="col-12 my-2">
                                    <div class="card">
                                        <div class="card-body" v-if="student?.creditCard">
                                            <h3 class="card-title">Card</h3>
                                            <p class="card-text">Card number: {{student?.creditCard.card_number}}</p>
                                            <p class="card-text">Card type: {{student?.creditCard.card_type}}</p>
                                            <p class="card-text">CVV: {{student?.creditCard.cvv}}</p>
                                            <p class="card-text">CASH: {{student?.creditCard.sum}}</p>
                                        </div>
                                        <button v-else> Добавить карту</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-disabled" role="tabpanel" aria-labelledby="nav-disabled-tab" tabindex="3">...</div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
