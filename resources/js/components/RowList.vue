<template>
    <div class="w-full h-auto bg-gray-50 rounded-lg px-12 grid grid-cols-5">
        <div>{{ product.id }}</div>
        <div>{{ product.name }}</div>
        <div>{{ product.price }}</div>
        <div>
            <i @click.prevent="edit()" class="cursor-pointer fas fa-eraser"></i>
        </div>
        <div class="">
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
