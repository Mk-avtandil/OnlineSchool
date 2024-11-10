import { createRouter, createWebHistory } from "vue-router";

const routes = [
    // Courses
    {
        path: "/",
        name: "courses_page_url",
        component: () => import("../pages/Сourse.vue"),
    },
    {
        path: "/course/store",
        name: "course_create_page_url",
        component: () => import("../pages/CourseCreate.vue"),
    },
    // Groups
    {
        path: "/course/:id/groups",
        name: "course_groups_page_url",
        component: () => import("../pages/СourseGroups.vue"),
    },
    {
        path: "/course/:id/group/store",
        name: "group_create_page_url",
        component: () => import("../pages/GroupCreate.vue"),
    },
    // Lessons
    {
        path: "/course/:id/lessons",
        name: "course_lessons_page_url",
        component: () => import("../pages/СourseLessons.vue"),
    },
    {
        path: "/students",
        name: "student_list_page_url",
        component: () => import("../pages/StudentList.vue"),
    },
    {
        path: "/student/store",
        name: "student_create_page_url",
        component: () => import("../pages/StudentCreate.vue"),
    },
    {
        path: "/teachers",
        name: "teacher_list_page_url",
        component: () => import("../pages/TeacherList.vue"),
    },
    {
        path: "/teacher/store",
        name: "teacher_create_page_url",
        component: () => import("../pages/TeacherCreate.vue"),
    },
];

export default createRouter({
    history: createWebHistory(),
    routes,
});
