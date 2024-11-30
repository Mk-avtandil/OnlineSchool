<script setup>
import axios from "axios";
import {onMounted, ref} from "vue";
import {useRoute} from 'vue-router';

const route = useRoute();
const errors = ref({});
const teacher = ref();
const teacherCourses = ref();
const successMessage = ref('');

onMounted(async () => {
    await getTeacher();
    await getTeacherCourses();
});

const getTeacher = async (url = `/api/teachers/${route.params.id}/detail`) => {
    try {
        const response = await axios.get(url);
        teacher.value = response.data.data;

    } catch (error) {
        console.error('Error fetching teacher:', error);
    }
};

const getTeacherCourses = async (url = '/api/courses') => {
    try {
        const response = await axios.get(url);
        teacherCourses.value = response.data.data
    } catch (error) {
        console.error('Error fetching courses', error.response || error);
    }
}
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

            <div class="col-12">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-course-tab" data-bs-toggle="tab" data-bs-target="#nav-course" type="button" role="tab" aria-controls="nav-course" aria-selected="true">Teacher courses</button>
                        <button class="nav-link" id="nav-groups-tab" data-bs-toggle="tab" data-bs-target="#nav-groups" type="button" role="tab" aria-controls="nav-groups" aria-selected="false">Teacher groups</button>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active my-3" id="nav-course" role="tabpanel" aria-labelledby="nav-course-tab" tabindex="0">
                        <div class="row">
                            <div class="col-12" v-for="course in teacherCourses">
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
                            <div class="col-12 my-2" v-for="group in teacher?.groups">
                                <div class="card">

                                    <div class="card-body">
                                        <h4 class="card-title">{{group?.title}}</h4>
                                        <p class="card-text">{{group?.description}}</p>
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
