<script setup>
import axios from "axios";
import {onMounted, ref} from "vue";
import { useRoute } from 'vue-router';

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
    <div class="container my-4">
        <div class="row">
            <div class="col-8">
                <h3 class="mb-2">Course groups</h3>
            </div>
            <div class="col-4 text-end">
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
                        <div class="col-4 text-end align-top">
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
                                    <button @click.prevent="deleteGroup(group.id)" class="dropdown-item" type="submit">Delete</button>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <p class="card-text">{{group.description}}</p>

                    <span>Менторы группы:</span>
                    <div>
                        <button v-for="teacher in group.teachers" type="button" class="bg-success rounded-4 text-light p-2">
                            {{teacher.first_name}} {{teacher.last_name}}
                        </button>
                    </div>

                    <span>Студенты группы:</span>
                    <div>
                        <button v-for="student in group.students" type="button" class="bg-success rounded-4 text-light p-2">
                            {{student.first_name}} {{student.last_name}}
                        </button>
                    </div>
                </div>
                <div class="card-footer">
                    <span>Start time: {{group.start_time}}</span><br>
                    <span>End time: {{group.end_time}}</span>
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
