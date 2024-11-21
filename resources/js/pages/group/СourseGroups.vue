<script setup>
import axios from "axios";
import {computed, onMounted, ref} from "vue";
import { useRoute } from 'vue-router';
import { useStore } from "vuex";

const store = useStore();
const role = computed(() => store.getters.role);
const groups = ref({});
const route = useRoute();

onMounted(async () => {
    await getGroups();
});

const getGroups = async (url = `/api/course/${route.params.id}/groups`) => {
    try {
        const response = await axios.get(url);
        groups.value = response.data;
    } catch (error) {
        console.error('Error fetching groups:', error);
    }
};

const deleteGroup = async (groupId) => {
    try {
        await axios.delete(`/api/group/${groupId}`);
        await getGroups();
        successMessage.value = 'Group deleted successfully!';
    } catch (error) {
        console.error('Failed to delete group:', error);
    }
};
</script>

<template>
    <div class="container my-3">
        <div class="row">
            <div class="col-8">
                <span class="fs-6">
                    <button @click="$router.go(-1)" class="btn btn-outline-dark">Назад</button>
                </span>
                <span class="fs-3 mx-2 align-middle">Course groups</span>
            </div>
            <div class="col-4 text-end" v-if="['admin', 'super_admin'].includes(role)">
                <router-link :to="{name: 'group_create_page_url'}" class="btn bg-body-tertiary px-2 py-1 border-dark">Add New Group</router-link>
            </div>
        </div>
        <div class="card-group" v-for="group in groups?.data">
            <div class="card my-3">
                <div class="card-body text-secondary">
                    <div class="row">
                        <div class="col-8">
                            <h5 class="card-title text-dark">{{group.title}}</h5>
                        </div>
                        <div class="col-4 text-end align-top" v-if="['admin', 'super_admin'].includes(role)">
                            <div class="btn-group">
                                <router-link data-bs-toggle="dropdown" >
                                    <div id="nav-icon">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </div>
                                </router-link>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-sm-end">
                                    <li>
                                        <router-link :to="{name: 'group_edit_page_url', params: {id: group.id}}" class="dropdown-item">Edit</router-link>
                                    </li>
                                    <li>
                                        <button @click.prevent="deleteGroup(group.id)" class="dropdown-item" type="submit">Delete</button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <p class="card-text">{{group.description}}</p>

                    <h5 class="mb-0 mt-2">Менторы группы:</h5>
                    <span>
                        <a v-for="teacher in group.teachers" type="button" class="btn btn-warning my-1" style="margin-right: 3px;">
                            {{teacher.first_name}} {{teacher.last_name}}
                        </a>
                    </span>

                    <h5 class="mb-0 mt-2">Студенты группы:</h5>
                    <span v-for="student in group.students">
                        <router-link :to="{name: 'student_detail_page_url', params: {id: student.id}}"
                             class="btn btn-warning my-1" style="margin-right: 3px;">
                            {{student.first_name}} {{student.last_name}}
                        </router-link>
                    </span>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
#nav-icon {
    display: inline-block;
    cursor: pointer;
}

#nav-icon span {
    display: block;
    width: 18px;
    height: 2px;
    margin: 3px 0;
    background-color: #333;
    transition: 0.3s;
}
</style>
