import axios from "axios";

const state = {
    user: null,
};

const mutations = {
    SET_USER(state, user) {
        state.user = user;
    },
    CLEAR_USER(state) {
        state.user = null;
    }
};

const actions = {
    async fetchUser({ commit }) {
        const token = localStorage.getItem('access_token');

        if (token) {
            try {
                const response = await axios.get('/api/user', {
                    headers: {
                        Authorization: `Bearer ${token}`
                    }
                });
                commit('SET_USER', response.data.data);
            } catch (error) {
                console.error('Failed to fetch user data: ', error);
                commit('CLEAR_USER');
                localStorage.removeItem('access_token');
            }
        } else {
            commit('CLEAR_USER');
        }
    },
    async logout({ commit }) {
        commit('CLEAR_USER');
        localStorage.removeItem('access_token');
    }
};

const getters = {
    user: (state) => state.user,
};

export default {
    state,
    mutations,
    actions,
    getters
};
