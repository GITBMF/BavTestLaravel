import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';
Vue.use(Vuex);

const store = new Vuex.Store({
    state: {
        count: 0,
        token: null
    },
    mutations: {
        INCREMENT(state) {
            state.count++;
        },
        SET_TOKEN(state, token) {
            state.token = token
            localStorage.setItem("access_token", token)
        }
    },
    actions: {
        async logout({ commit }, token) {
            console.log("login out token ==>> ", token.token);
            return new Promise((resolve, reject) => {
                axios.get(`/api/logout`, token, {
                        headers: {
                            'Content-Type': 'application/json',
                            Authorization: `Bearer ${token.token}`
                        }
                    })
                    .then((response) => {
                        console.log(response)
                        commit("SET_TOKEN", null)
                        resolve(response);
                    })
                    .catch((error) => {
                        console.log("logout error ==>> ", error)
                        reject(error)
                    })
            })

        },
        async login({ commit }, params) {
            return new Promise((resolve, reject) => {
                axios.post(`/api/login`, params)
                    .then((response) => {
                        console.log(response)
                        commit("SET_TOKEN", response.data.token)
                        resolve(response);
                    })
                    .catch((error) => {
                        console.log(error)
                        reject(error)
                    })
            })

        },
        async register({ commit }, params) {
            return new Promise((resolve, reject) => {
                axios.post(`/api/register`, params)
                    .then((response) => {
                        console.log(response)
                        commit("SET_TOKEN", response.data.token)
                        resolve(response);
                    })
                    .catch((error) => {
                        console.log(error)
                        reject(error)
                    })
            })

        },


    },
    getters: {
        the_token: state => state.token || localStorage.getItem("access_token"),
    }
})

export default store;