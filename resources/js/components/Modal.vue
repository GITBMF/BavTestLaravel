<template>
    <div class="flex justify-center ">
        <dir
            @click.self="closeModal()"
            class="flex justify-center overflow-scroll items-start h-screen w-screen shadow-lg fixed top-0 left-0 z-10 vh-100 bg-black bg-opacity-30"
        >
            <slot />
        </dir>
    </div>
</template>

<script>
export default {
    name: "modal",
    data() {
        return {
            modal: false
        };
    },
    methods: {
        closeModal() {
            this.$emit("closeMe");
        },
        toggleModal() {
            this.modal = !this.modal;
        }
    }
};
</script>

<style lang="scss" scoped></style>
