<template>
    <div class="w-full h-full">
        <navbar></navbar>
        <!-- <home /> -->
        <!-- <second-header></second-header> -->
        <transition name="fade">
            <router-view></router-view>
        </transition>
        <!-- <the-footer></the-footer> -->
    </div>
</template>

<script>
import Navbar from "../global/Navbar.vue";
import TheFooter from "../global/TheFooter.vue";
import Home from "../Pages/Home.vue";
export default {
    name: "default-layout",
    components: { Navbar, Home, TheFooter }
};
</script>

<style></style>
