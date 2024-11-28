<script setup>
import axios from "axios";
import { computed, onMounted, ref, watch } from "vue";
import { useStore } from "vuex";

const store = useStore();
const role = computed(() => store.getters.role);
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
        const response = await axios.get('/api/courses');
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
                            filteredPayments: filterPayments(student.payments)  // Фильтруем платежи
                        };
                    })
                };
            })
        };
    });
};

watch([selectedYear, selectedMonth], () => {
    applyFilter();
});
</script>

<template>
    <div class="container my-3" v-if="role === 'super_admin'">
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
                    <router-link :to="{ name: 'course_detail_page_url', params: { id: course.id } }">{{
                            course.title
                        }}
                    </router-link>
                </td>
                <td>{{ course.price }}</td>
                <td>{{ course.groups ? course.groups.length : 0 }}</td>
                <td>{{ course.lessons ? course.lessons.length : 0 }}</td>
            </tr>
            </tbody>
        </table>
    </div>

    <div class="container my-3" v-else>
        <h3>У вас недостаточно прав для просмотра!</h3>
    </div>

    <!-- Фильтрация по году и месяцу -->
    <div class="container my-3" v-if="role === 'super_admin'">
        <h3>Payments</h3>

        <div class="filters">
            <label for="year">Year:</label>
            <select v-model="selectedYear" id="year">
                <option v-for="year in years" :key="year" :value="year">{{ year }}</option>
            </select>

            <label for="month">Month:</label>
            <select v-model="selectedMonth" id="month">
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
                <template v-for="group in course.groups" :key="group.id">
                    <tr v-for="student in group.students" :key="student.id">
                        <td>{{ course.title }}</td>
                        <td>{{ group.title }}</td>
                        <td>{{ student.first_name }} {{ student.last_name }}</td>
                        <td>{{ calculateTotalPaymentStudent(student.filteredPayments) }}</td>
                    </tr>
                </template>
            </template>
            </tbody>
        </table>

        <div class="total-sum text-end">
            <strong>Total Payment: {{ calculateTotalPayment(filteredCourses) }}</strong>
        </div>
    </div>
</template>

<style scoped>
.filters {
    margin-bottom: 15px;
}

.filters label {
    margin-right: 10px;
}

.filters select {
    margin-right: 20px;
}
</style>
