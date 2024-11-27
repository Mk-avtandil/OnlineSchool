import axios from "axios";

const state = {
    user: localStorage.getItem('user') ? JSON.parse(localStorage.getItem('user')) : null,
    role: localStorage.getItem('role') || null
};

const mutations = {
    SET_USER(state, user) {
        state.user = user;
        localStorage.setItem('user', JSON.stringify(user));
    },
    SET_ROLE(state, role) {
        state.role = role;
        localStorage.setItem('role', role);
    },
    REMOVE_TOKEN(state) {
        state.token = '';
        localStorage.removeItem('authToken');
    },
    REMOVE_ROLE(state) {
        state.role = null;
        localStorage.removeItem('role');
    },
    CLEAR_USER(state) {
        state.user = null;
        localStorage.removeItem('user');
    }
};

const actions = {
    async setRole({ commit }, role) {
        commit('SET_ROLE', role);
    },
    async fetchUser({ commit }) {
        const token = localStorage.getItem('access_token');

        if (token) {
            try {
                const response = await axios.get('/api/user', {
                    headers: {
                        Authorization: `Bearer ${token}`
                    }
                });

                commit('SET_USER', response.data);
            } catch (error) {
                console.error('Failed to fetch user data: ', error);
                commit('CLEAR_USER');
            }
        } else {
            commit('CLEAR_USER');
        }
    },
    async logout({ commit }) {
        commit('CLEAR_USER');
        commit('REMOVE_ROLE');
        localStorage.removeItem('access_token');
    }
};

const getters = {
    user: (state) => state.user,
    isAuthenticated: (state) => !!localStorage.getItem('access_token'),
    role: (state) => state.role,
};

export default {
    state,
    mutations,
    actions,
    getters
};
