<script setup>
import axios from "axios";
import {onMounted, ref} from "vue";
import { useRoute } from 'vue-router';
import PaymentForCourse from '../../components/PaymentForCourse.vue';

const route = useRoute();
const errors = ref({});
const student = ref();
const studentCourses = ref();
const successMessage = ref('');
const data = ref({
    'card_number': '',
    'card_type': '',
    'cvv': '',
    'sum': '',
});

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

const saveCreditCard = async (url = '/api/cards/store') => {
    try {
        errors.value = {};
        successMessage.value = '';

        await axios.post(url, data.value);
        await getStudent();
        successMessage.value = 'Credit Card created successfully!';

        setTimeout(() => {
            data.value = {
                card_number: '',
                card_type: '',
                cvv: '',
                sum: '',
            };
        }, 1000);
    } catch (error) {
        if (error.response && error.response.data && error.response.data.errors) {
            errors.value = error.response.data.errors;
        } else {
            console.error('Failed to create credit card');
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
                        <div v-for="course in studentCourses" :key="course.id">
                            <PaymentForCourse
                                :course="course"
                                :student="student"
                                :errors="errors"
                                @payment-created="handlePaymentCreated" />
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
                                        <button v-else type="submit" class="btn btn-primary mx-1" data-bs-toggle="modal" data-bs-target="#staticBackdropStudent">
                                            Add Credit Card
                                        </button>
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

    <div class="modal fade" id="staticBackdropStudent" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Credit Card</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form row">
                            <div class="form-group col-md-12 mb-2">
                                <label for="card_number" class="my-1">Card number</label>
                                <input v-model="data.card_number" type="text" class="form-control" id="card_number" placeholder="Credit number">
                            </div>
                            <div v-if="errors.card_number" class="alert alert-danger my-1">
                                {{ errors.card_number[0] }}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="my-1">Card type</label>
                            <div class="form-group col-md-12 mb-1">
                                <input v-model="data.card_type" class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="visa">
                                <label class="form-check-label mx-1" for="inlineRadio1">visa</label>
                            </div>
                            <div class="form-group col-md-12 mb-2">
                                <input v-model="data.card_type" class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="mastercard">
                                <label class="form-check-label mx-1" for="inlineRadio2">mastercard</label>
                            </div>
                            <div v-if="errors.card_type" class="alert alert-danger my-1">
                                {{ errors.card_type[0] }}
                            </div>
                        </div>

                        <div class="form-group col-md-12 mb-2">
                            <label for="card_cvv" class="my-1">CVV</label>
                            <input v-model="data.cvv" type="text" class="form-control" id="card_cvv" placeholder="CVV">
                        </div>
                        <div v-if="errors.cvv" class="alert alert-danger my-1">
                            {{ errors.cvv[0] }}
                        </div>

                        <div class="form-group col-md-12 mb-2">
                            <label for="card_sum" class="my-1">SUM</label>
                            <input v-model="data.sum" type="text" class="form-control" id="card_sum" placeholder="SUM">
                        </div>
                        <div v-if="errors.sum" class="alert alert-danger my-1">
                            {{ errors.sum[0] }}
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <div v-if="successMessage" class="alert alert-success mt-2 w-100">
                        {{ successMessage }}
                    </div>

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <div class="form-group my-3">
                        <button type="submit" class="btn btn-primary" @click="saveCreditCard()">Add</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
