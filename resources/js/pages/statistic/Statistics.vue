<script setup>
import axios from "axios";
import { computed, onMounted, ref } from "vue";
import {useStore} from "vuex";

const store = useStore();
const user = computed(() => store.getters.user);
const students = computed( () => store.getters.students);
const selectedStudentInfo = ref();
const courses = ref([]);
const payments = ref();

onMounted(async () => {
    await getCourses();
    await getPayments();
    await store.dispatch('fetchStudents');
});

const getCourses = async () => {
    try {
        const response = await axios.get('/api/courses/all');
        courses.value = response.data.data;
    } catch (error) {
        console.error('Error fetching courses:', error);
    }
}

const getPayments = async () => {
    try {
        const response = await axios.get('/api/students/payments');
        payments.value = response.data;
    } catch (error) {
        console.error('Error fetching payments:', error);
    }
}

const selectedStudent = async (student) => {
    selectedStudentInfo.value = student;
}
</script>

<template>
    <div v-if="user?.role.includes('super_admin')">
        <div class="container my-3">
            <h3>Courses</h3>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Course</th>
                    <th>Price</th>
                    <th>Number of group</th>
                    <th>Number of lesson</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="course in courses" :key="course.id">
                    <td>
                        <router-link :to="{ name: 'course_detail_page_url', params: { id: course.id } }">
                            {{ course.title }}
                        </router-link>
                    </td>
                    <td>{{ course.price }}</td>
                    <td>{{ course.groups ? course.groups.length : 0 }}</td>
                    <td>{{ course.lessons ? course.lessons.length : 0 }}</td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="container my-3">
            <h3>Payments</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Full name</th>
                        <th>Amount of payment</th>
                        <th>Sum</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="student in payments" :key="student.id">
                        <td>
                            <a class="link-primary text-decoration-none" href="#" data-bs-toggle="modal" @click="selectedStudent(student)" data-bs-target="#exampleModal">
                                {{student.first_name}} {{student.last_name}}
                            </a>
                        </td>
                        <td>{{student.payments.length}}</td>
                        <td>{{student.totalSum}}</td>
                    </tr>
                </tbody>
            </table>

            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">{{selectedStudentInfo?.first_name}} {{selectedStudentInfo?.last_name}}</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <h6>Payments</h6>
                            <div class="card my-2 p-2 bg-success-subtle" v-for="payment in selectedStudentInfo?.payments">
                                <p>Course: {{payment?.course?.title}}</p>
                                <p>Sum: {{payment.sum}}</p>
                                <p>Created at: {{payment.created_at}}</p>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container my-3" v-else>
        <h3>У вас недостаточно прав для просмотра!</h3>
    </div>
</template>

<style scoped>
</style>
