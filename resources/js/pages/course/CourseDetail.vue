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

                const allGrades = [];
                let totalLessons = 0;

                course.lessons.forEach(lesson => {
                    const homework = lesson.homeworks?.find(hw =>
                        hw.solutions.some(solution => solution.student_id === student.id)
                    );

                    let grade = null;

                    if (homework) {
                        const solution = homework.solutions.find(
                            sol => sol.student_id === student.id
                        );
                        grade = solution?.grade?.grade;
                    }

                    if (grade !== undefined) {
                        scores[lesson.title] = { grade };
                        allGrades.push(grade);
                    } else {
                        scores[lesson.title] = { grade: 0 };
                    }

                    totalLessons++;
                });

                let averageGrade = 'N/A';
                if (allGrades.length > 0) {
                    const total = allGrades.reduce((acc, grade) => acc + grade, 0);
                    averageGrade = (total / totalLessons).toFixed(2);
                }

                return {
                    name: `${student.first_name} ${student.last_name}`,
                    scores,
                    averageGrade,
                };
            }),
        };
    });

    return { groups, lessons };
};

</script>

<template>
    <div class="container my-3">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Group</th>
                    <th>Student</th>
                    <th v-for="lesson in lessonTitles" :key="lesson">{{ lesson }}</th>
                    <th>Average grade</th>
                </tr>
                </thead>
                <tbody>
                <template v-for="group in tableGroups" :key="group.groupTitle">
                    <tr v-if="group.students.length > 0">
                        <td :rowspan="group.students.length + 1">{{ group.groupTitle }}</td>
                    </tr>
                    <tr v-for="student in group.students" :key="student.name">
                        <td>{{ student.name }}</td>
                        <td v-for="lesson in lessonTitles" :key="lesson">
                            <span>Grade: {{ student.scores[lesson]?.grade }}</span>
                        </td>
                        <td>{{ student.averageGrade }}</td>
                    </tr>

                    <tr v-if="group.students.length === 0">
                        <td :rowspan="group.students.length + 1">{{group.groupTitle}}</td>
                        <td></td>
                        <td v-for="lesson in lessonTitles" :key="lesson">
                            <span></span>
                        </td>
                        <td></td>
                    </tr>
                </template>
                </tbody>
            </table>
        </div>
    </div>
</template>
<style scoped>

</style>
