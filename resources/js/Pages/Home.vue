<template>
    <div class="the-home w-full h-screen">
        <div class=""></div>
        <div
            v-if="isLogin"
            class="w-full h-full px-12 flex justify-center items-center"
        >
            <form class="grid grid-flow-row gap-4" @submit.prevent="login">
                <input
                    class="rounded p-1"
                    v-model="email"
                    placeholder="email"
                />
                <input
                    class="rounded p-1"
                    v-model="password"
                    placeholder="password"
                    type="password"
                />
                <div class="flex justify-between items-end">
                    <div
                        @click="isLogin = false"
                        class="text-blue-500 cursor-pointer hover:underline"
                    >
                        Register
                    </div>
                    <input
                        class="rounded px-3 py-1 bg-blue-400 cursor-pointer hover:bg-blue-600"
                        type="submit"
                        value="log in"
                    />
                </div>
            </form>
        </div>
        <div
            v-else
            class="w-full h-full px-12 flex justify-center items-center"
        >
            <form class="grid grid-flow-row gap-4" @submit.prevent="register">
                <input class="rounded p-1" v-model="name" placeholder="name" />
                <input
                    class="rounded p-1"
                    v-model="email"
                    placeholder="email"
                />
                <input
                    class="rounded p-1"
                    v-model="password"
                    placeholder="password"
                    type="password"
                />
                <input
                    class="rounded p-1"
                    v-model="c_password"
                    placeholder="confirm password"
                    type="password"
                />
                <div class="flex justify-between items-end">
                    <div
                        @click="isLogin = true"
                        class="text-blue-500 cursor-pointer hover:underline"
                    >
                        Login
                    </div>
                    <input
                        class="rounded px-3 py-1 bg-blue-400 cursor-pointer hover:bg-blue-600"
                        type="submit"
                        value="Register"
                    />
                </div>
            </form>
        </div>
    </div>
</template>

<script>
// import Header from "~/js/global/header";
import FixHeader from "../global/FixHeader.vue";
import { mapState, mapGetters } from "vuex";
export default {
    name: "home",
    data() {
        return {
            name: "",
            email: "",
            password: "",
            c_password: "",
            isLogin: true
        };
    },
    components: {
        FixHeader
    },
    computed: {
        ...mapState({
            count: state => state.count
        }),
        ...mapGetters(["the_token"])
    },
    methods: {
        async login() {
            const req = {
                email: this.email,
                password: this.password
            };
            await this.$store.dispatch("login", req).then("");
            console.log("new access_token ===>> ", this.the_token);
            this.$router.push("/products");
        },
        async register() {
            const req = {
                name: this.name,
                email: this.email,
                password: this.password,
                c_password: this.c_password
            };
            await this.$store.dispatch("register", req);
            this.$router.push("/products");
        }
    },
    mounted() {
        console.log("the_token ===>> ", this.the_token);
    }
};
</script>
