<template>
    <nav class="navBar">
        <header
            class="fixed navBar__header shadow-md  z-50 w-full px-5 py-2 grid
grid-cols-1 md:flex md:flex-row md:justify-between items-center"
        >
            <div class="flex flex-row justify-between">
                <router-link to="/" class="text-2xl text-white"
                    ><img :src="''" alt="Bridge-test"
                /></router-link>
                <i id="hamburgerbtn" class="fas fa-bars md:hidden"></i>
                <!-- <p id="hamburgerbtn" class="md:hidden ">
                    menu
                </p> -->
            </div>
            <!-- <ul class="hidden md:flex md:flex-row" id="mobileMenu">
                <li class="pr-5"><a> Services </a></li>
                <li class="pr-5"><a>Porfolio</a></li>
                <li class="pr-5"><a>About</a></li>
                <li><a>Contact</a></li>
            </ul> -->

            <div
                class="lg-menu-items hidden md:flex md:flex-row"
                id="mobileMenu"
            >
                <router-link
                    v-if="
                        this.the_token != '' &&
                            this.the_token != null &&
                            this.the_token != undefined
                    "
                    to="/products"
                    class="text-black hover:text-white px-3 rounded py-1"
                    >Products</router-link
                >
                <div
                    @click="logout"
                    v-if="
                        this.the_token != '' &&
                            this.the_token != null &&
                            this.the_token != undefined
                    "
                    class="text-black hover:text-white px-3 rounded py-1"
                >
                    Logout
                </div>
            </div>
        </header>
        <!-- <fix-header></fix-header>
        <ul class="narBar__link">
            <li><router-link :to="{ name: 'home' }">Home</router-link></li>
            <li><router-link :to="{ name: 'about' }">About</router-link></li>
        </ul> -->
    </nav>
</template>

<script>
import FixHeader from "../global/FixHeader.vue";
import { mapState, mapGetters } from "vuex";
export default {
    name: "navbar",
    components: { FixHeader },
    computed: {
        ...mapGetters(["the_token"])
    },
    methods: {
        async logout() {
            console.log("login out");
            const token = this.the_token;
            await this.$store.dispatch("logout", token);
            console.log("new access_token ===>> ", this.the_token);
            this.$router.push("/");
        }
    },
    mounted() {
        let hamburger = document.getElementById("hamburgerbtn");

        let mobileMenu = document.getElementById("mobileMenu");

        hamburger.addEventListener("click", function() {
            mobileMenu.classList.toggle("active");
        });
    }
};
</script>
<style>
.active {
    display: flex;
    flex-direction: column;
}
</style>
