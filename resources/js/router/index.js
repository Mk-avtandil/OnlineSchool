import { createRouter, createWebHistory } from "vue-router";
import {useStore} from "vuex";

const routes = [
    // Courses
    {
        path: "/",
        name: "courses_page_url",
        component: () => import("../pages/course/Сourse.vue"),
        meta: { requiresAuth: true },
    },
    {
        path: "/course/:id/edit",
        name: "courses_edit_page_url",
        component: () => import("../pages/course/CourseEdit.vue"),
        meta: { requiresAuth: true },
    },
    {
        path: "/course/store",
        name: "course_create_page_url",
        component: () => import("../pages/course/CourseCreate.vue"),
        meta: { requiresAuth: true },
    },
    {
        path: "/course/:id/detail",
        name: "course_detail_page_url",
        component: () => import("../pages/course/CourseDetail.vue"),
        meta: { requiresAuth: true },
    },
    // Groups
    {
        path: "/course/:id/groups",
        name: "course_groups_page_url",
        component: () => import("../pages/group/СourseGroups.vue"),
        meta: { requiresAuth: true },
    },
    {
        path: "/course/:id/group/store",
        name: "group_create_page_url",
        component: () => import("../pages/group/GroupCreate.vue"),
        meta: { requiresAuth: true },
    },
    {
        path: "/group/:id/edit",
        name: "group_edit_page_url",
        component: () => import("../pages/group/GroupEdit.vue"),
        meta: { requiresAuth: true },
    },
    {
        path: "/group/:id/detail",
        name: "group_detail_page_url",
        component: () => import("../pages/group/GroupDetail.vue"),
        meta: { requiresAuth: true },
    },
    // Lessons
    {
        path: "/course/:id/lessons",
        name: "course_lessons_page_url",
        component: () => import("../pages/lesson/СourseLessons.vue"),
        meta: { requiresAuth: true },
    },
    {
        path: "/course/:id/lesson/store",
        name: "lesson_create_page_url",
        component: () => import("../pages/lesson/LessonCreate.vue"),
        meta: { requiresAuth: true },
    },
    {
        path: "/lesson/:id/edit",
        name: "lesson_edit_page_url",
        component: () => import("../pages/lesson/LessonEdit.vue"),
        meta: { requiresAuth: true },
    },
    // Students
    {
        path: "/students",
        name: "student_list_page_url",
        component: () => import("../pages/student/StudentList.vue"),
        meta: { requiresAuth: true },
    },
    {
        path: "/student/:id",
        name: "student_detail_page_url",
        component: () => import("../pages/student/StudentDetail.vue"),
        meta: { requiresAuth: true },
    },
    {
        path: "/student/store",
        name: "student_create_page_url",
        component: () => import("../pages/student/StudentCreate.vue"),
        meta: { requiresAuth: true },
    },
    {
        path: "/student/:id/edit",
        name: "student_edit_page_url",
        component: () => import("../pages/student/StudentEdit.vue"),
        meta: { requiresAuth: true },
    },
    // Teachers
    {
        path: "/teachers",
        name: "teacher_list_page_url",
        component: () => import("../pages/teacher/TeacherList.vue"),
        meta: { requiresAuth: true },
    },
    {
        path: "/teacher/:id",
        name: "teacher_detail_page_url",
        component: () => import("../pages/teacher/TeacherDetail.vue"),
        meta: { requiresAuth: true },
    },
    {
        path: "/teacher/store",
        name: "teacher_create_page_url",
        component: () => import("../pages/teacher/TeacherCreate.vue"),
        meta: { requiresAuth: true },
    },
    {
        path: "/teacher/:id/edit",
        name: "teacher_edit_page_url",
        component: () => import("../pages/teacher/TeacherEdit.vue"),
        meta: { requiresAuth: true },
    },
    // Homeworks
    {
        path: "/lesson/:id/homework/store",
        name: "homework_create_page_url",
        component: () => import("../pages/homework/HomeworkCreate.vue"),
        meta: { requiresAuth: true },
    },
    {
        path: "/homework/:id",
        name: "homework_detail_page_url",
        component: () => import("../pages/homework/HomeworkDetail.vue"),
        meta: { requiresAuth: true },
    },
    // Schedule
    {
        path: "/schedule",
        name: "schedule_page_url",
        component: () => import("../pages/schedule/Schedule.vue"),
        meta: { requiresAuth: true },
    },
    {
        path: "/schedule/store",
        name: "schedule_create_page_url",
        component: () => import("../pages/schedule/ScheduleCreate.vue"),
        meta: { requiresAuth: true },
    },
    // Statistics
    {
        path: "/statistics",
        name: "statistics_page_url",
        component: () => import("../pages/statistic/Statistics.vue"),
        meta: { requiresAuth: true },
    },
    // Auth
    {
        path: "/login",
        name: "login_page_url",
        component: () => import("../pages/auth/LoginPage.vue"),
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    const store = useStore();
    const isAuthenticated = store.getters.isAuthenticated;
    const requiresAuth = to.matched.some(record => record.meta.requiresAuth);

    if (requiresAuth && !isAuthenticated) {
        next('/login');
    } else {
        next();
    }
});
export default router;
