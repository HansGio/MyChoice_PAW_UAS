<template>
<<<<<<< HEAD
    <div>
        <v-card class="mx-auto" elevation="3" outlined>
            <v-card
                class="mx-auto pa-5"
                align="center"
                max-width="200px"
                color="#9ad3bc"
            >
                <h3 class="headline white--text text--accent-2">Shopping Bag</h3>
            </v-card>
            <v-container>
                <v-row no-gutters>

                    <v-col 
                        cols="12" md="12"
                        v-for="product in products"
                        :key="product"
                        class="pa-4"
                    >
                        <v-card>
                            <v-col
                                class="hidden-sm-and-down" 
                                md="6"
                            >
                                <v-img :src="require('@/assets/image1.jpg')" class="image-size">
                                    <!-- <v-card-title
                                        v-text="card.title"
                                    ></v-card-title> -->
                                </v-img>
                            </v-col>

                            <v-col
                            class="align-content-space-between layout wrap"
                            cols="12"
                            md="6">
                                <v-row
                                  align="center"
                                  
                                >
                                    <v-col 
                                        cols="10" md="12" >
                                        <v-card-title>
                                            {{ product.name }}
                                        </v-card-title>
                                        <v-card-subtitle>
                                        <br />
                                            Ukuran {{ product.size}}
                                        <br />

                                        <v-spacer></v-spacer>
                                        <p class="headline">
                                            Price Tag : {{ product.price }}
                                        </p>
                                        <br />
                                        </v-card-subtitle>
                                    </v-col>
                                </v-row>
                            </v-col>
                        </v-card>
                    </v-col>
                </v-row>
            </v-container>
        </v-card>
    </div>
</template>

<script>
export default {
    data() {
        return {
            load: false,
            snackbar: false,
            error_message: "",
            color: "",
            search: null,
            dialog: false,
            dialogConfirm: false,
            headers: [
                {
                    text: "Nama produk",
                    align: "start",
                    sortable: true,
                    value: "nama_produk",
                },
                { text: "Satuan", value: "satuan" },
                { text: "Harga jual", value: "harga_jual" },
                { text: "stok", value: "stok" },
                { text: "Actions", value: "actions" },
            ],
            product: new FormData(),
            products: [],
            form: {
                nama_produk: null,
                satuan: null,
                harga_jual: null,
                stok: null,
            },
            deleteId: "",
            editId: "",
        };
    },
    methods: {
        readData() {
            var url = this.$api + "/item/man";
            this.$http
                .get(url, {
                    headers: {
                        Authorization:
                            "Bearer " + localStorage.getItem("token"),
                    },
                })
                .then((response) => {
                    this.products = response.data.items;
                });
        },
    },
    mounted() {
        this.readData();
        for (this.product in this.products) {
            console.log(this.product);
        }
    },
};
</script>
<style>
.image-size {
    height: 250px;
    width: 100px;
}
</style>
=======
    <v-row>
        <v-col class="text-center">
            <base-text class="text-center"> SHOPPING BAG </base-text>
        </v-col>
        <br />
        <v-img
            lazy-src="https://picsum.photos/id/11/10/6"
            max-height="150"
            max-width="250"
            src="https://picsum.photos/id/11/500/300"
        ></v-img>
    </v-row>
</template>
>>>>>>> 396623db70f19dbc4774d973b803b27b9ef6d6b5
