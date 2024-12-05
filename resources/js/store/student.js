import axios from "axios";

const state = {
    students: []
}

const mutations = {
    SET_STUDENT(state, students) {
        state.students = students;
    }
}

const actions = {
    async fetchStudents({ commit }) {
        try {
            const response = await axios.get('/api/students');
            commit('SET_STUDENT', response.data);
        } catch (error) {
            console.error('Failed to fetch students: ', error);
        }
    }
}

const getters = {
    students: (state) => state.students,
}

export default {
    state,
    mutations,
    actions,
    getters
}
