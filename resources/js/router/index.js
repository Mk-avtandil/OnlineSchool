import { createRouter, createWebHistory } from "vue-router";

const routes = [
    // Courses
    {
        path: "/",
        name: "courses_page_url",
        component: () => import("../pages/course/Сourse.vue"),
    },
    {
        path: "/course/:id/edit",
        name: "courses_edit_page_url",
        component: () => import("../pages/course/CourseEdit.vue"),
    },
    {
        path: "/course/store",
        name: "course_create_page_url",
        component: () => import("../pages/course/CourseCreate.vue"),
    },
    // Groups
    {
        path: "/course/:id/groups",
        name: "course_groups_page_url",
        component: () => import("../pages/group/СourseGroups.vue"),
    },
    {
        path: "/course/:id/group/store",
        name: "group_create_page_url",
        component: () => import("../pages/group/GroupCreate.vue"),
    },
    {
        path: "/group/:id/edit",
        name: "group_edit_page_url",
        component: () => import("../pages/group/GroupEdit.vue"),
    },
    // Lessons
    {
        path: "/course/:id/lessons",
        name: "course_lessons_page_url",
        component: () => import("../pages/lesson/СourseLessons.vue"),
    },
    {
        path: "/course/:id/lesson/store",
        name: "lesson_create_page_url",
        component: () => import("../pages/lesson/LessonCreate.vue"),
    },
    {
        path: "/lesson/:id/edit",
        name: "lesson_edit_page_url",
        component: () => import("../pages/lesson/LessonEdit.vue"),
    },
    // Students
    {
        path: "/students",
        name: "student_list_page_url",
        component: () => import("../pages/student/StudentList.vue"),
    },
    {
        path: "/student/:id",
        name: "student_detail_page_url",
        component: () => import("../pages/student/StudentDetail.vue"),
    },
    {
        path: "/student/store",
        name: "student_create_page_url",
        component: () => import("../pages/student/StudentCreate.vue"),
    },
    {
        path: "/student/:id/edit",
        name: "student_edit_page_url",
        component: () => import("../pages/student/StudentEdit.vue"),
    },
    // Teachers
    {
        path: "/teachers",
        name: "teacher_list_page_url",
        component: () => import("../pages/teacher/TeacherList.vue"),
    },
    {
        path: "/teacher/:id",
        name: "teacher_detail_page_url",
        component: () => import("../pages/teacher/TeacherDetail.vue"),
    },
    {
        path: "/teacher/store",
        name: "teacher_create_page_url",
        component: () => import("../pages/teacher/TeacherCreate.vue"),
    },
    {
        path: "/teacher/:id/edit",
        name: "teacher_edit_page_url",
        component: () => import("../pages/teacher/TeacherEdit.vue"),
    },
    // Homeworks
    {
        path: "/lesson/:id/homework/store",
        name: "homework_create_page_url",
        component: () => import("../pages/homework/HomeworkCreate.vue"),
    },
    {
        path: "/homework/:id",
        name: "homework_detail_page_url",
        component: () => import("../pages/homework/HomeworkDetail.vue"),
    },
    // Schedule
    {
        path: "/schedule",
        name: "schedule_page_url",
        component: () => import("../pages/schedule/Schedule.vue"),
    },
    {
        path: "/schedule/store",
        name: "schedule_create_page_url",
        component: () => import("../pages/schedule/ScheduleCreate.vue"),
    },
    // Statistics
    {
        path: "/statistics",
        name: "statistics_page_url",
        component: () => import("../pages/statistic/Statistics.vue"),
    },
    // Auth
    {
        path: "/login",
        name: "login_page_url",
        component: () => import("../pages/auth/LoginPage.vue"),
    },
];

export default createRouter({
    history: createWebHistory(),
    routes,
});
