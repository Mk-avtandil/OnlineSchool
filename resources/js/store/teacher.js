import axios from "axios";

const state = {
    teachers: []
}

const mutations = {
    SET_TEACHER(state, teachers) {
        state.teachers = teachers;
    }
}

const actions = {
    async fetchTeachers({ commit }) {
        try {
            const response = await axios.get('/api/teachers');
            commit('SET_TEACHER', response.data);
        } catch (error) {
            console.error('Failed to fetch teachers: ', error);
        }
    }
}

const getters = {
    teachers: (state) => state.teachers,
}

export default {
    state,
    mutations,
    actions,
    getters
}
