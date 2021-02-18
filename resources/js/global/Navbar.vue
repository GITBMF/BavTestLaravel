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
                <!-- <div
                    @click="logout"
                    v-if="bridge_user"
                    class="text-black hover:text-white px-3 rounded py-1"
                >
                    Logout
                </div> -->
                <div
                    v-if="the_bridge_user"
                    @click="toggleProfileMenu"
                    class="px-2 flex relative items-center"
                >
                    <i
                        class="cursor-pointer fas fa-user-circle"
                        aria-hidden="true"
                        >&nbsp;{{ the_bridge_user.name }}</i
                    >

                    <transition name="fade">
                        <ul
                            v-if="showProfileMenu"
                            class="header-profil-ul absolute z-10 shadow top-full right-0 bg-white py-4 px-4 rounded-sm"
                        >
                            <li class="cursor-pointer" @click="logout">
                                logout
                            </li>
                        </ul>
                    </transition>
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
    data() {
        return {
            showProfileMenu: false
        };
    },
    components: { FixHeader },
    computed: {
        ...mapGetters(["the_token", "the_bridge_user"])
        // bridge_user() {
        //     return JSON.parse(this.the_bridge_user) || null;
        // }
    },
    methods: {
        toggleProfileMenu(event) {
            event.stopPropagation();
            this.showProfileMenu = !this.showProfileMenu;
        },
        async logout() {
            console.log("login out");
            const token = this.the_token;
            await this.$store.dispatch("logout", token);
            console.log("new bridge_user ===>> ", this.the_bridge_user);
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
<style lang="scss">
.active {
    display: flex;
    flex-direction: column;
}
.header-profil-ul {
    li {
        &:hover {
            color: #0077ff;
        }
        a {
            transition: 0.3s;
        }
    }
}
</style>
