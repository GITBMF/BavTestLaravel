<template>
    <div class="w-full h-auto bg-gray-50 rounded-lg px-12 grid grid-cols-5">
        <div>{{ product.id }}</div>
        <div class="overflow-hidden">{{ product.name }}</div>
        <div class="overflow-hidden">{{ product.price }}</div>
        <div class="flex justify-center items-center">
            <i @click.prevent="edit()" class="cursor-pointer fas fa-eraser"></i>
        </div>
        <div class="flex justify-center items-center">
            <i
                @click.prevent="deleteProduct()"
                class="cursor-pointer fas fa-trash"
            ></i>
        </div>
    </div>
</template>

<script>
export default {
    name: "row-list",
    props: ["product"],
    methods: {
        edit() {
            this.$emit("edit", this.product);
        },
        deleteProduct() {
            this.$emit("deleteProduct", this.product.id);
        }
    }
};
</script>

<style></style>
