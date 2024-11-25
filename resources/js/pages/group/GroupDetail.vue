<script setup>
import axios from "axios";
import {onMounted, ref} from "vue";
import {useRoute} from "vue-router";

const group = ref();
const lessons = ref();
const route = useRoute();

onMounted(async () => {
    await getGroup();
});
const getGroup = async (url = `/api/groups/${route.params.id}/detail`) => {
    try {
        const response = await axios.get(url);
        group.value = response.data.data;

        if (group.value?.course?.id) {
            await getLessons(group.value.course.id);
        }
    } catch (error) {
        console.error('Error fetching group:', error);
    }
}

const getLessons = async (courseId) => {
    try {
        const response = await axios.get(`/api/lessons/${courseId}`);
        lessons.value = response.data.data;
    } catch (error) {
        console.error('Error fetching lessons:', error);
    }
}


</script>
<template>
    <div class="container my-3">
        <h3>Group</h3>
        <table class="table table-bordered">
            <tr>
                <th scope="col" class="table-header">Course</th>
                <td>{{group?.course.title}}</td>
            </tr>
            <tr>
                <th scope="col" class="table-header">Group</th>
                <td>{{group?.title}}</td>
            </tr>
            <tr>
                <th scope="col" class="table-header">Students</th>
                <td class="border-0">
                    <table class="nested-table">
                        <tr v-for="student in group?.students">
                            <td>{{student.first_name}} {{student.last_name}}</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <th class="table-header">Teachers</th>
                <td class="border-0">
                    <table class="nested-table">
                        <tr v-for="teacher in group?.teachers">
                            <td>{{teacher.first_name}} {{teacher.last_name}}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

    <div class="container my-3">
        <h3>Lessons</h3>
        {{lessons}}
        <table class="table table-bordered">
            <tr>
                <th scope="col" class="table-header">Students</th>
                <td>
                    <table class="nested-table">
                        <tr>
                            <td class="table-header" v-for="lesson in lessons">{{lesson.title}}</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr v-for="student in group?.students">
                <td>{{student.first_name}} {{student.last_name}}</td>
            </tr>
        </table>
    </div>
</template>

<style scoped>
table, th, td {
    vertical-align: top;
    border: 1px solid #ddd;
    border-collapse: collapse;
}

table {
    width: 100%;
}

.table-header {
    font-weight: bold;
    padding: 10px;
}

td {
    padding: 12px;
    vertical-align: middle;
}

td:has(table) {
    padding: 0;
}
</style>
