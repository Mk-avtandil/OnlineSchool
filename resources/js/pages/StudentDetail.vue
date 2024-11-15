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
    await getStudentCourses()
});

const getStudent = async (url = `/api/student/${route.params.id}`) => {
    try {
        const response = await axios.get(url);
        student.value = response.data.data;

    } catch (error) {
        console.error('Error fetching student:', error);
    }
};

const getStudentCourses = async (url = `/api/student/${route.params.id}/courses`) => {
    try {
        const response = await axios.get(url);
        console.log(response.data)
        studentCourses.value = response.data
    } catch (error) {
        console.error('Error fetching courses', error.response || error);
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
                        <td>{{student?.id}}</td>
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
                    <tr>
                        <th>Address</th>
                        <td>{{student?.address}}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{student?.email}}</td>
                    </tr>
                </table>
            </div>

            <div class="col-12">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-course-tab" data-bs-toggle="tab" data-bs-target="#nav-course" type="button" role="tab" aria-controls="nav-course" aria-selected="true">Student courses</button>
                        <button class="nav-link" id="nav-groups-tab" data-bs-toggle="tab" data-bs-target="#nav-groups" type="button" role="tab" aria-controls="nav-groups" aria-selected="false">Student groups</button>
                        <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Grades</button>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active my-3" id="nav-course" role="tabpanel" aria-labelledby="nav-course-tab" tabindex="0">
                        <div class="row">
                            <div class="col-12" v-for="course in studentCourses">
                                <div class="card my-1">
                                    <div class="card-body">
                                        <h5 class="card-title">{{course?.title}}</h5>
                                        <p class="card-text">{{course?.description}}</p>
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
                                    </div>
                                    <div class="card-footer">
                                        <span>Start time: {{group?.start_time}}</span><br>
                                        <span>End time: {{group?.end_time}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab" tabindex="2">...</div>
                    <div class="tab-pane fade" id="nav-disabled" role="tabpanel" aria-labelledby="nav-disabled-tab" tabindex="3">...</div>
                </div>
            </div>

        </div>



    </div>
</template>

<style scoped>

</style>
