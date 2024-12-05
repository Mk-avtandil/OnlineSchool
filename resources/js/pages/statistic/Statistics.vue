<script setup>
import axios from "axios";
import { computed, onMounted, ref } from "vue";
import { useStore } from "vuex";

const store = useStore();
const user = computed(() => store.getters.user);
const courses = ref([]);

onMounted(async () => {
    await getCourses();
});

const getCourses = async () => {
    try {
        const response = await axios.get('/api/courses/all');
        courses.value = response.data.data;
    } catch (error) {
        console.error('Error fetching courses:', error);
    }
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

        </div>
    </div>

    <div class="container my-3" v-else>
        <h3>У вас недостаточно прав для просмотра!</h3>
    </div>
</template>

<style scoped>
</style>
