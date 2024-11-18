import { createRouter, createWebHistory } from "vue-router";

const routes = [
    // Courses
    {
        path: "/",
        name: "courses_page_url",
        component: () => import("../pages/Сourse.vue"),
    },
    {
        path: "/course/:id/edit",
        name: "courses_edit_page_url",
        component: () => import("../pages/CourseEdit.vue"),
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
    {
        path: "/group/:id/edit",
        name: "group_edit_page_url",
        component: () => import("../pages/GroupEdit.vue"),
    },
    // Lessons
    {
        path: "/course/:id/lessons",
        name: "course_lessons_page_url",
        component: () => import("../pages/СourseLessons.vue"),
    },
    {
        path: "/course/:id/lesson/store",
        name: "lesson_create_page_url",
        component: () => import("../pages/LessonCreate.vue"),
    },
    {
        path: "/lesson/:id/edit",
        name: "lesson_edit_page_url",
        component: () => import("../pages/LessonEdit.vue"),
    },
    // Students
    {
        path: "/students",
        name: "student_list_page_url",
        component: () => import("../pages/StudentList.vue"),
    },
    {
        path: "/student/:id",
        name: "student_detail_page_url",
        component: () => import("../pages/StudentDetail.vue")
    },
    {
        path: "/student/store",
        name: "student_create_page_url",
        component: () => import("../pages/StudentCreate.vue"),
    },
    {
        path: "/student/:id/edit",
        name: "student_edit_page_url",
        component: () => import("../pages/StudentEdit.vue"),
    },
    // Teachers
    {
        path: "/teachers",
        name: "teacher_list_page_url",
        component: () => import("../pages/TeacherList.vue"),
    },
    {
        path: "/teacher/:id",
        name: "teacher_detail_page_url",
        component: () => import("../pages/TeacherDetail.vue")
    },
    {
        path: "/teacher/store",
        name: "teacher_create_page_url",
        component: () => import("../pages/TeacherCreate.vue"),
    },
    {
        path: "/teacher/:id/edit",
        name: "teacher_edit_page_url",
        component: () => import("../pages/TeacherEdit.vue"),
    },
    // Homeworks
    {
        path: "/lesson/:id/homework/store",
        name: "homework_create_page_url",
        component: () => import("../pages/HomeworkCreate.vue"),
    },
    {
        path: "/homework/:id",
        name: "homework_detail_page_url",
        component: () => import("../pages/HomeworkDetail.vue")
    },
    // Auth
    {
        path: "/login",
        name: "login_page_url",
        component: () => import("../pages/LoginPage.vue"),
    },
];

export default createRouter({
    history: createWebHistory(),
    routes,
});
