<template>
    <div class="flex justify-center">
        <slot />
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
        toggleModal() {
            this.modal = !this.modal;
        }
    }
};
</script>

<style lang="scss" scoped></style>
