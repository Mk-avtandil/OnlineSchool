import { createRouter, createWebHistory } from "vue-router";

const routes = [
    {
        path: "/",
        name: "courses_page_url",
        component: () => import("../pages/Сourse.vue"),
    },
    {
        path: "/courses/:id/groups",
        name: "course_groups_page_url",
        component: () => import("../pages/СourseGroups.vue"),
    },
    {
        path: "/courses/:id/lessons",
        name: "course_lessons_page_url",
        component: () => import("../pages/СourseLessons.vue"),
    },
    {
        path: "/students",
        name: "student_list_page_url",
        component: () => import("../pages/StudentList.vue"),
    },
    {
        path: "/students/store",
        name: "student_create_page_url",
        component: () => import("../pages/StudentCreate.vue"),
    },
    {
        path: "/teachers",
        name: "teacher_list_page_url",
        component: () => import("../pages/TeacherList.vue"),
    },
    {
        path: "/teachers/store",
        name: "teacher_create_page_url",
        component: () => import("../pages/TeacherCreate.vue"),
    },
];

export default createRouter({
    history: createWebHistory(),
    routes,
});
