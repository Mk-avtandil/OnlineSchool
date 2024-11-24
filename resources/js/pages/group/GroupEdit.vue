<script setup>
import axios from "axios";
import { ref, onMounted } from "vue";
import { useRoute } from "vue-router";

const errors = ref({});
const successMessage = ref('');
const availableStudents = ref([]);
const selectedStudents = ref([]);
const availableTeachers = ref([]);
const selectedTeachers = ref([]);
const route = useRoute();
const data = ref({
    title: '',
    description: '',
    students: [],
    teachers: [],
});

onMounted(async () => {
    await getGroup();
    await getTeachers();
    await getStudents();
});

const getGroup = async (url = `/api/groups/${route.params.id}/detail`) => {
    try {
        const response = await axios.get(url);
        data.value = response.data.data;
    } catch (error) {
        console.error("Failed to get groups: ", error);
    }
};

const getStudents = async (url = '/api/students') => {
    try {
        const response = await axios.get(url);
        availableStudents.value = response.data.data.filter(student =>
            !data.value.students.some(groupStudent => groupStudent.id === student.id)
        );
    } catch (error) {
        console.error("Failed to get students: ", error);
    }
};

const getTeachers = async (url = '/api/teachers') => {
    try {
        const response = await axios.get(url);
        availableTeachers.value = response.data.data.filter(teacher =>
            !data.value.teachers.some(groupTeacher => groupTeacher.id === teacher.id)
        );
    } catch (error) {
        console.error("Failed to get teachers: ", error);
    }
}

const updateGroup = async (url = `/api/groups/${route.params.id}`) => {
    try {
        errors.value = {};
        successMessage.value = '';

        const response = await axios.put(url, {
            title: data.value.title,
            description: data.value.description,
            students: [data.value.students, selectedStudents.value],
            teachers: [data.value.teachers, selectedTeachers.value],
        });

        successMessage.value = 'Group updated successfully!';

        await getGroup();
        await getStudents();
        await getTeachers();

    } catch (error) {
        console.error('Failed to update group:', error);
        if (error.response && error.response.data && error.response.data.errors) {
            errors.value = error.response.data.errors;
        }
    }
};

const removeStudent = async (studentId) => {
    try {
        const response = await axios.put(`/api/groups/${route.params.id}/remove-student`, {
            student_id: studentId,
        });

        successMessage.value = 'Student removed successfully!';
        await getGroup();
        await getStudents();
    } catch (error) {
        console.error('Failed to remove student:', error);
        if (error.response && error.response.data && error.response.data.errors) {
            errors.value = error.response.data.errors;
        }
    }
};

const removeTeacher = async (teacherId) => {
    try {
        const response = await axios.put(`/api/groups/${route.params.id}/remove-teacher`, {
            teacher_id: teacherId,
        });

        successMessage.value = 'Teacher removed successfully!';
        await getGroup();
        await getTeachers();
    } catch (error) {
        console.error('Failed to remove teacher:', error);
        if (error.response && error.response.data && error.response.data.errors) {
            errors.value = error.response.data.errors;
        }
    }
};
</script>

<template>
    <div class="container my-3">
        <h3 class="mb-3">Update Group</h3>
        <div v-if="successMessage" class="alert alert-success">
            {{ successMessage }}
        </div>
        <form @submit.prevent="updateGroup()">
            <div class="form-group my-2">
                <label>Title</label>
                <input v-model="data.title" type="text" class="form-control">
            </div>
            <div v-if="errors.title" class="alert alert-danger my-1">
                {{ errors.title[0] }}
            </div>

            <div class="form-group my-2">
                <label>Description</label>
                <textarea v-model="data.description" rows="5" class="form-control"></textarea>
            </div>
            <div v-if="errors.description" class="alert alert-danger my-1">
                {{ errors.description[0] }}
            </div>

            <div class="form-group my-2">
                <div class="row">
                    <div class="col-12">
                        <div>
                            <label>Students in Group</label>
                        </div>
                        <div class="btn-group dropend my-1" v-for="student in data.students" :key="student.id" style="margin-right: 4px;">
                            <button type="button" class="btn btn-warning">
                                {{ student.first_name }} {{ student.last_name }}
                            </button>
                            <button @click="removeStudent(student.id)" type="button" class="btn btn-outline-warning" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="btn-close"></span>
                            </button>
                        </div>
                    </div>
                    <div class="col-12 my-2">
                        <div>
                            <label>Teachers in Group</label>
                        </div>
                        <div class="btn-group dropend my-1" v-for="teacher in data.teachers" :key="teacher.id" style="margin-right: 4px;">
                            <button type="button" class="btn btn-warning">
                                {{ teacher.first_name }} {{ teacher.last_name }}
                            </button>
                            <button @click="removeTeacher(teacher.id)" type="button" class="btn btn-outline-warning" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="btn-close"></span>
                            </button>
                        </div>
                    </div>
                </div>

                <!--Modal Students-->
                <div class="modal fade" id="staticBackdropStudent" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Students</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <ul class="scrollable-list list-group">
                                    <li class="list-group-item" v-for="student in availableStudents" :key="student.id">
                                        <input class="form-check-input me-1" type="checkbox" :id="'checkbox-' + student.id"
                                               :value="student.id" v-model="selectedStudents">
                                        <label class="form-check-label" :for="'checkbox-' + student.id">
                                            {{ student.first_name }} {{ student.last_name }}
                                        </label>
                                    </li>
                                </ul>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <div class="form-group my-3">
                                    <button type="submit" class="btn btn-primary">Add</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--Modal Teachers-->
            <div class="modal fade" id="staticBackdropTeacher" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Teachers</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <ul class="scrollable-list list-group">
                                <li class="list-group-item" v-for="teacher in availableTeachers" :key="teacher.id">
                                    <input class="form-check-input me-1" type="checkbox" :id="'checkbox - ' + teacher.id"
                                           :value="teacher.id" v-model="selectedTeachers">
                                    <label class="form-check-label" :for="'checkbox - ' + teacher.id">
                                        {{ teacher.first_name }} {{ teacher.last_name }}
                                    </label>
                                </li>
                            </ul>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <div class="form-group my-3">
                                <button type="submit" class="btn btn-primary">Add</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group my-3">
                <button type="submit" class="btn btn-primary">Update</button>
                <button type="button" class="btn btn-primary mx-1" data-bs-toggle="modal" data-bs-target="#staticBackdropStudent">
                    Add Students
                </button>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdropTeacher">
                    Add Teachers
                </button>
            </div>
        </form>
    </div>
</template>

<style scoped>
.scrollable-list {
    max-height: 200px;
    overflow-y: auto;
    padding: 5px;
}
</style>
