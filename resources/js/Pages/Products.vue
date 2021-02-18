<template>
    <div @click.self="ismodal = false" class="the-home px-12 w-full h-screen">
        <div class="h-28"></div>
        <button
            v-if="!ismodal"
            class="bg-blue-500 rounded p-3"
            @click="ismodal = true"
        >
            Add product
        </button>
        <modal v-if="ismodal">
            <div class="max-w-sm justify-center mt-4 bg-gray-300 rounded-2xl">
                <form @submit.prevent="onEditId ? editProduct() : addProduct()">
                    <div class="p-6 grid grid-rows-3 gap-4">
                        <div class="grid grid-cols-2">
                            <label for="name">Name</label>
                            <input
                                class="rounded-sm p-2"
                                type="text"
                                name="name"
                                v-model="name"
                                id=""
                            />
                        </div>
                        <div class="grid grid-cols-2">
                            <label for="price">Price</label>
                            <input
                                class="rounded-sm p-2"
                                type="number"
                                min="0"
                                name="price"
                                v-model="price"
                                id=""
                            />
                        </div>
                        <div class="grid grid-cols-2">
                            <div></div>
                            <div class="flex justify-between">
                                <button
                                    @click="ismodal = false"
                                    class="rounded px-3 py-1 mr-3 border border-red-400 hover:bg-red-400"
                                >
                                    Cancel
                                </button>
                                <button
                                    class="rounded px-3 py-1 bg-blue-600"
                                    type="submit"
                                >
                                    Save
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </modal>
        <div class="mt-5 space-y-3" v-if="!ismodal">
            <div
                class="w-full h-auto bg-gray-50 rounded-lg px-12 grid grid-cols-5"
            >
                <div>ID</div>
                <div>NAME</div>
                <div>PRICE</div>
                <div>
                    EDIT
                </div>
                <div class="">
                    DELETE
                </div>
            </div>
            <row-list
                v-for="product in products_list"
                :product="product"
                :key="product.id"
                @edit="toggleEdit"
                @deleteProduct="removeProduct"
            />
        </div>
    </div>
</template>

<script>
import FixHeader from "../global/FixHeader.vue";
import { mapState, mapGetters } from "vuex";
import RowList from "../components/RowList.vue";
import Modal from "../components/Modal.vue";
export default {
    name: "products",
    data() {
        return {
            name: "",
            price: 0,
            ismodal: false,
            onEditId: null
        };
    },
    components: {
        FixHeader,
        RowList,
        Modal
    },
    computed: {
        ...mapGetters(["the_token", "products_list"])
    },
    methods: {
        toggleEdit($product) {
            console.log(this.onEditId);
            this.name = $product.name;
            this.price = $product.price;
            this.onEditId = $product.id;
            console.log(this.onEditId);
            this.ismodal = true;
        },
        async removeProduct($id) {
            await this.$store.dispatch("deleteProduct", $id);
        },
        async editProduct() {
            const req = {
                id: this.onEditId,
                name: this.name,
                price: this.price
            };
            await this.$store.dispatch("updateProduct", req);
            this.ismodal = false;
            this.name = "";
            this.price = 0;
            this.onEditId = null;
        },
        async addProduct() {
            const req = {
                name: this.name,
                price: this.price
            };
            await this.$store.dispatch("addProduct", req);
            this.ismodal = false;
            this.name = "";
            this.price = 0;
            console.log("new access_token ===>> ", this.the_token);
        },
        toggleModal() {
            this.ismodal = !this.ismodal;
        }
    },
    async mounted() {
        console.log(
            "this.the_token == null ++++>>> ",
            this.the_token == "null"
        );
        console.log("this.the_token == null ++++>>> ", this.the_token == null);
        if (
            this.the_token == "" ||
            this.the_token == null ||
            this.the_token == undefined
        ) {
            this.$router.push("/");
            return;
        }
        await this.$store.dispatch("fetchProducts");
    }
};
</script>

<style></style>
