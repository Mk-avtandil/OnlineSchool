<script setup>
import axios from "axios";
import { computed, onMounted, ref, watch } from "vue";
import { useStore } from "vuex";

const store = useStore();
const user = computed(() => store.getters.user);
const courses = ref([]);
const selectedYear = ref(new Date().getFullYear());
const selectedMonth = ref(null);
const years = ref([2020, 2021, 2022, 2023, 2024]);

const months = ref([
    { id: 1, name: "January" },
    { id: 2, name: "February" },
    { id: 3, name: "March" },
    { id: 4, name: "April" },
    { id: 5, name: "May" },
    { id: 6, name: "June" },
    { id: 7, name: "July" },
    { id: 8, name: "August" },
    { id: 9, name: "September" },
    { id: 10, name: "October" },
    { id: 11, name: "November" },
    { id: 12, name: "December" }
]);

const filteredCourses = ref([]);

onMounted(async () => {
    await getCourses();
    applyFilter();
});

const getCourses = async () => {
    try {
        const response = await axios.get('/api/courses/all');
        courses.value = response.data.data;
        applyFilter();
    } catch (error) {
        console.error('Error fetching courses:', error);
    }
}

const filterPayments = (payments) => {
    return payments.filter(payment => {
        const paymentDate = new Date(payment.created_at);
        const paymentYear = paymentDate.getFullYear();
        const paymentMonth = paymentDate.getMonth() + 1;

        if (selectedMonth.value === null) {
            return paymentYear === selectedYear.value;
        }

        return paymentYear === selectedYear.value && paymentMonth === selectedMonth.value;
    });
};

const calculateTotalPaymentStudent = (payments) => {
    if (payments && payments.length > 0) {
        return payments.reduce((total, payment) => total + payment.sum, 0);
    }
    return 0;
}

const calculateTotalPayment = (courses) => {
    return courses.reduce((courseSum, course) => {
        return courseSum + course.groups.reduce((groupSum, group) => {
            return groupSum + group.students.reduce((studentSum, student) => {
                return studentSum + calculateTotalPaymentStudent(student.filteredPayments);
            }, 0);
        }, 0);
    }, 0);
};

const applyFilter = () => {
    filteredCourses.value = courses.value.map(course => {
        return {
            ...course,
            groups: course.groups.map(group => {
                return {
                    ...group,
                    students: group.students.map(student => {
                        return {
                            ...student,
                            filteredPayments: filterPayments(student.payments)
                        };
                    })
                };
            })
        };
    });
};

const totalGroupRows = (groups) => {
    return groups.reduce((total, group) => total + group.students.length, 0);
};

watch([selectedYear, selectedMonth], () => {
    applyFilter();
});
</script>

<template>
    <div v-if="user?.data.role.includes('super_admin')">
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

            <div class="filters mb-3">
                <label for="year">Year:</label>
                <select v-model="selectedYear" id="year" class="mx-2">
                    <option v-for="year in years" :key="year" :value="year">{{ year }}</option>
                </select>

                <label for="month">Month:</label>
                <select v-model="selectedMonth" id="month" class="mx-2">
                    <option :value="null">All months</option>
                    <option v-for="month in months" :key="month.id" :value="month.id">{{ month.name }}</option>
                </select>
            </div>

            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Course</th>
                    <th>Group</th>
                    <th>Student</th>
                    <th>Payment</th>
                </tr>
                </thead>
                <tbody>
                <template v-for="course in filteredCourses" :key="course.id">
                    <template v-for="(group, groupIndex) in course.groups" :key="group.id">
                        <template v-for="(student, studentIndex) in group.students" :key="student.id">
                            <tr>
                                <td v-if="groupIndex === 0 && studentIndex === 0" :rowspan="totalGroupRows(course.groups)">
                                    {{ course.title }}
                                </td>
                                <td v-if="studentIndex === 0" :rowspan="group.students.length">
                                    {{ group.title }}
                                </td>
                                <td>{{ student.first_name }} {{ student.last_name }}</td>
                                <td>{{ calculateTotalPaymentStudent(student.filteredPayments) }}</td>
                            </tr>
                        </template>
                    </template>
                </template>
                </tbody>
            </table>

            <div class="total-sum text-end">
                <strong>Total Payment: {{ calculateTotalPayment(filteredCourses) }}</strong>
            </div>
        </div>
    </div>

    <div class="container my-3" v-else>
        <h3>У вас недостаточно прав для просмотра!</h3>
    </div>
</template>

<style scoped>
</style>
