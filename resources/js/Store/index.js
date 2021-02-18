import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';
Vue.use(Vuex);

const store = new Vuex.Store({
    state: {
        count: 0,
        token: '',
        products: [],
        user: null
    },
    mutations: {
        INCREMENT(state) {
            state.count++;
        },
        SET_TOKEN(state, token) {
            state.token = token
            localStorage.setItem("access_token", token)
        },
        SET_USER(state, user) {
            state.user = user
            let my_user = JSON.stringify(user)
            localStorage.setItem("bridge_user", my_user)
        },
        REMOVE_USER(state) {
            localStorage.removeItem("access_token");
            localStorage.removeItem("bridge_user");
            state.user = null;
            state.token = null;
        },
        SET_PRODUCTS(state, products) {
            state.products = products;
        },
        SET_PRODUCT(state, product) {
            state.products.unshift(product)
        },
        UPDATE_PRODUCT(state, product) {
            const idx = state.products.findIndex((elt) => elt.id == product.id)
            state.products.splice(idx, 1, product)

        },
        DELETE_PRODUCT(state, id) {
            const idx = state.products.findIndex((elt) => elt.id == id)
            state.products.splice(idx, 1)
        },
    },
    actions: {
        async deleteProduct({ commit }, id) {
            return new Promise((resolve, reject) => {
                axios.delete(`/api/deleteProduct/${id}`, {
                        headers: {
                            'Content-Type': 'application/json',
                            Authorization: `Bearer ${localStorage.getItem("access_token")}`
                        }
                    })
                    .then((response) => {
                        console.log(response)
                        commit("DELETE_PRODUCT", id)
                        resolve(response);
                    })
                    .catch((error) => {
                        console.log("logout error ==>> ", error)
                        reject(error)
                    })
            })
        },
        async updateProduct({ commit }, product) {
            return new Promise((resolve, reject) => {
                axios.put(`/api/editProducts/${product.id}`, product, {
                        headers: {
                            'Content-Type': 'application/json',
                            Authorization: `Bearer ${localStorage.getItem("access_token")}`
                        }
                    })
                    .then((response) => {
                        console.log(response)
                        commit("UPDATE_PRODUCT", response.data.data)
                        resolve(response);
                    })
                    .catch((error) => {
                        console.log("logout error ==>> ", error)
                        reject(error)
                    })
            })
        },
        async addProduct({ commit }, product) {
            return new Promise((resolve, reject) => {
                axios.post(`/api/storeProduct`, product, {
                        headers: {
                            'Content-Type': 'application/json',
                            Authorization: `Bearer ${localStorage.getItem("access_token")}`
                        }
                    })
                    .then((response) => {
                        console.log(response)
                        commit("SET_PRODUCT", response.data.data)
                        resolve(response);
                    })
                    .catch((error) => {
                        console.log("logout error ==>> ", error)
                        reject(error)
                    })
            })
        },
        async fetchProducts({ commit }) {
            return new Promise((resolve, reject) => {
                axios.get(`/api/products`, {
                        headers: {
                            'Content-Type': 'application/json',
                            Authorization: `Bearer ${localStorage.getItem("access_token")}`
                        }
                    })
                    .then((response) => {
                        console.log(response)
                        commit("SET_PRODUCTS", response.data.data)
                        resolve(response);
                    })
                    .catch((error) => {
                        console.log("logout error ==>> ", error)
                        reject(error)
                    })
            })
        },
        async logout({ commit }, token) {

            return new Promise((resolve, reject) => {
                axios.get(`/api/logout?token=${ token.token }`, {
                        headers: {
                            'Content-Type': 'application/json',
                            Authorization: `Bearer ${token.token}`
                        }
                    })
                    .then((response) => {

                        if (!response.data.user) {
                            console.log("logout response ===>> ", response)
                            commit("SET_TOKEN", '')
                            commit("REMOVE_USER")
                        }
                        resolve(response);
                    })
                    .catch((error) => {
                        console.log("logout error ==>> ", error)
                        reject(error)
                    })
            })

        },
        async login({ commit }, params) {
            console.log("Login ....................................");
            return new Promise((resolve, reject) => {
                axios.get(`/api/login?email=${params.email}&password=${params.password}`)
                    .then((response) => {
                        console.log("login response.data.user")
                        console.log(response.data.user)
                        commit("SET_TOKEN", response.data.token)
                        commit("SET_USER", response.data.user)
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
                        commit("SET_USER", response.data.user)
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
        the_bridge_user: state => state.user || JSON.parse(localStorage.getItem("bridge_user")),
        products_list: state => state.products,
    }
})

export default store;