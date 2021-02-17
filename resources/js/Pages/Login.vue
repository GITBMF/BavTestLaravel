<template>
    <div class="the-home w-full h-full">
        <form @submit.prevent="login">
            <input v-model="username" placeholder="username" />
            <input v-model="password" placeholder="password" type="password" />
            <input type="submit" value="log in" />
        </form>
    </div>
</template>

<script>
// import Header from "~/js/global/header";
import FixHeader from "../global/FixHeader.vue";
import { mapState } from "vuex";
export default {
    name: "home",
    data() {
        return {
            username: "",
            password: ""
        };
    },
    components: {
        FixHeader
    },
    computed: {
        ...mapState({
            count: state => state.count
        })
    },
    methods: {
        async login() {
            const { username, password } = this;
            const res = await fetch(
                "https://SomberHandsomePhysics--five-nine.repl.co/login",
                {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({ username, password })
                }
            );
            const data = await res.json();
            console.log(data);
        }
    },
    mounted() {
        console.log("Component mounted.");
    }
};
</script>
