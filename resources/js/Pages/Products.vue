<template>
    <div class="the-home w-full h-screen">
        <div class="h-28"></div>
        <div>products</div>
    </div>
</template>

<script>
import FixHeader from "../global/FixHeader.vue";
import { mapState, mapGetters } from "vuex";
export default {
    name: "products",
    data() {
        return {};
    },
    components: {
        FixHeader
    },
    computed: {
        ...mapGetters(["the_token"])
    },
    mounted() {
        if (this.the_token == "null") {
            this.$router.push("/");
        }
    }
};
</script>

<style></style>
