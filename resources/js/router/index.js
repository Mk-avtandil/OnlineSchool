import { createRouter, createWebHistory } from "vue-router";

const routes = [
    {
        path: "/",
        name: "courses_page_url",
        component: () => import("../pages/course.vue"),
    },
    {
        path: "/course/:id/groups",
        name: "course_groups_page_url",
        component: () => import("../pages/courseGroups.vue"),
    },
];

export default createRouter({
    history: createWebHistory(),
    routes,
});
