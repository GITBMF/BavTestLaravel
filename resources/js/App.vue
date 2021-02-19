<template>
    <div class="container max-w-full max-h-screen">
        <default-layout></default-layout>
        <!-- <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="collapse navbar-collapse">
                <div class="navbar-nav">
                    <router-link to="/" class="nav-item nav-link"
                        >Products List</router-link
                    >
                    <router-link to="/create" class="nav-item nav-link"
                        >Create Product</router-link
                    >
                </div>
            </div>
        </nav> -->

        <!-- <router-view> </router-view> -->
    </div>
</template>

<script>
import Navbar from "./global/Navbar.vue";
import DefaultLayout from "./layout/DefaultLayout.vue";
export default {
    components: { Navbar, DefaultLayout },
    mounted() {
        console.log("this.$route.meta.layout ==>> ", this.$route.meta.layout);
    }
};
</script>
