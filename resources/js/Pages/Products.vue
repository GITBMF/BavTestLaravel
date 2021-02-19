<template>
    <div
        @click.self="ismodal = false"
        class="the-home px-12 pb-6 w-full h-full"
    >
        <div class="h-28"></div>
        <button class="bg-blue-500 rounded p-3" @click="ismodal = true">
            Add product
        </button>
        <modal v-if="ismodal" @closeMe="closeModal()">
            <div
                class="max-w-lg max-h-full flex justify-center items-center z-20 mt-14 bg-gray-300 rounded-2xl"
            >
                <form @submit.prevent="onEditId ? editProduct() : addProduct()">
                    <div class="p-6 grid grid-rows-5 gap-4">
                        <div class="grid grid-cols-2">
                            <label for="name">Name</label>
                            <input
                                class="rounded-xl p-2 h-7"
                                type="text"
                                name="name"
                                v-model="name"
                                id=""
                            />
                        </div>
                        <div class="grid grid-cols-2">
                            <label for="description">Description</label>
                            <textarea
                                class="rounded-xl p-2 h-10"
                                type="text"
                                name="description"
                                v-model="description"
                                id=""
                            />
                        </div>
                        <div class="grid grid-cols-2">
                            <label for="picture">Picture</label>
                            <input
                                class="rounded-xl p-2"
                                type="file"
                                name="picture"
                                ref="imageUpload"
                                accept="image/*"
                                id="file-input"
                                @change="imChanged"
                            />
                        </div>
                        <div class="grid grid-cols-2">
                            <label for="price">Price</label>
                            <input
                                class="rounded-xl p-2 h-7"
                                type="text"
                                min="0"
                                name="price"
                                v-model="price"
                                @keypress="onlyNumber"
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
                                    :disabled="false"
                                >
                                    Save
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </modal>
        <div class="mt-5 space-y-3">
            <div
                class="w-full h-auto bg-gray-50 rounded-lg px-12 grid grid-cols-7 gap-3"
            >
                <div>ID</div>
                <div>NAME</div>
                <div class="overflow-hidden">DESCRIPTION</div>
                <div class="overflow-hidden">PICTURE</div>
                <div>PRICE</div>
                <div class="flex justify-center items-center">
                    EDIT
                </div>
                <div class="flex justify-center items-center">
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
            description: "",
            picture: null,
            price: 0,
            ismodal: false,
            onEditId: null,
            onsubmition: false
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
        imChanged(event) {
            const file = event.target.files[0];
            this.picture = file;

            console.log("this.picture ===>>> ", this.picture);
        },
        onlyNumber($event) {
            //console.log($event.keyCode); //keyCodes value
            let keyCode = $event.keyCode ? $event.keyCode : $event.which;
            if ((keyCode < 48 || keyCode > 57) && keyCode !== 46) {
                // 46 is dot
                $event.preventDefault();
            }
        },
        closeModal() {
            this.ismodal = false;
        },
        toggleEdit($product) {
            console.log(this.onEditId);
            this.name = $product.name;
            this.price = $product.price;
            this.description = $product.description;
            this.picture = $product.picture;
            this.onEditId = $product.id;
            console.log(this.onEditId);
            this.ismodal = true;
        },
        async removeProduct($id) {
            await this.$store.dispatch("deleteProduct", $id);
        },
        async editProduct() {
            this.onsubmition = true;
            const req = {
                name: this.name,
                description: this.description,
                picture: this.picture,
                price: this.price
            };
            let formData1 = new FormData();
            // formData1.append("id", this.onEditId);
            formData1.append("name", this.name);
            formData1.append("description", this.description);
            formData1.append("picture", this.picture);
            formData1.append("price", this.price);
            await this.$store.dispatch("updateProduct", {
                id: this.onEditId,
                formData: formData1
            });
            this.ismodal = false;
            this.onsubmition = false;
            this.name = "";
            this.price = 0;
            this.description = "";
            this.onEditId = null;
        },
        async addProduct() {
            this.onsubmition = true;
            const req = {
                name: this.name,
                description: this.description,
                picture: this.picture,
                price: this.price
            };
            let formData = new FormData();
            formData.append("name", this.name);
            formData.append("description", this.description);
            formData.append("picture", this.picture);
            formData.append("price", this.price);
            await this.$store.dispatch("addProduct", formData);
            this.ismodal = false;
            this.onsubmition = false;
            this.name = "";
            this.price = 0;
            this.description = "";
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
