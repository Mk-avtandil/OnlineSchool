<script setup>
import axios from "axios";
import { onMounted, ref } from "vue";
import {useRoute} from "vue-router";

const route = useRoute();
const course = ref(null);
const tableGroups = ref([]);
const lessonTitles = ref([]);

onMounted(async () => {
    await getCourse();
});

const getCourse = async (url = `/api/courses/${route.params.id}/statistics`) => {
    const response = await axios.get(url);
    course.value = response.data.data;

    const { groups, lessons } = processCourseData(course.value);
    tableGroups.value = groups;
    lessonTitles.value = lessons;
};


const processCourseData = (course) => {
    const lessons = course.lessons.map(lesson => lesson.title);

    const groups = course.groups.map(group => {
        return {
            groupTitle: group.title,
            students: group.students.map(student => {
                const scores = {};

                course.lessons.forEach(lesson => {
                    const homework = lesson.homeworks?.find(hw =>
                        hw.solutions.some(solution => solution.student_id === student.id)
                    );

                    if (homework) {
                        const solution = homework.solutions.find(
                            sol => sol.student_id === student.id
                        );

                        scores[lesson.title] = {
                            grade: solution?.grade?.grade,
                        };
                    }
                });

                return {
                    name: `${student.first_name} ${student.last_name}`,
                    scores,
                };
            }),
        };
    });
    return { groups, lessons };
};
</script>

<template>
    <div class="container my-3">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Group</th>
                <th>Student</th>
                <th v-for="lesson in lessonTitles" :key="lesson">{{ lesson }}</th>
            </tr>
            </thead>
            <tbody>
            <template v-for="group in tableGroups" :key="group.groupTitle">
                <tr>
                    <td :rowspan="group.students.length + 1">{{ group.groupTitle }}</td>
                </tr>
                <tr v-for="student in group.students" :key="student.name">
                    <td>{{ student.name }}</td>
                    <td v-for="lesson in lessonTitles" :key="lesson">
                        <span>Grade: {{ student.scores[lesson]?.grade }}</span>
                        <br />
                    </td>
                </tr>
            </template>
            </tbody>
        </table>
    </div>
</template>



<style scoped>

</style>
