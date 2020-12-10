<template>
    <v-main class="list">
        <div></div>

        <v-card>
            <v-tabs>
                <v-row class="mb-6" no-gutters>
                    <v-tab> Semua Produk </v-tab>
                    <v-tab> Aktif </v-tab>
                    <v-tab> NonAktif </v-tab>
                    <v-col md="2" offset-md="3">
                        <v-text-field
                            v-model="search"
                            append-icon="mdi-magnify"
                            label="Search"
                            single-line
                            hide-details
                        ></v-text-field>
                    </v-col>
                    <v-col md="1" offset-md="1">
                        <v-btn
                            class="ma-2"
                            :loading="loading2"
                            :disabled="loading2"
                            color="success"
                            @click="addProduct"
                        >
                            Tambah Produk
                            <template v-slot:loader>
                                <span>Loading...</span>
                            </template>
                        </v-btn>
                    </v-col>
                </v-row>
                <v-tab-item>
                    <v-container fluid>
                        <v-row>
                            <v-col>
                                <v-data-table
                                    :headers="headers"
                                    :items="items"
                                    :search="search"
                                >
                                    <template v-slot:[`item.name`]="{ item }">
                                        <div class="p-2 d-flex align-center">
                                            <v-img
                                                src="https://images.unsplash.com/photo-1606654951863-70346cd12201?ixlib=rb-1.2.1&ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&auto=format&fit=crop&w=1268&q=80"
                                                :alt="item.name"
                                                max-height="100px"
                                                max-width="100px"
                                            />
                                            <div class="ml-4">
                                                <h6>
                                                    {{ item.name }}
                                                    <v-icon small>{{
                                                        item.gender.toLowerCase() ==
                                                        "man"
                                                            ? "mdi-gender-male"
                                                            : "mdi-gender-female"
                                                    }}</v-icon>
                                                </h6>
                                                <v-spacer></v-spacer>
                                                <span class="caption">{{
                                                    getSizes(item)
                                                }}</span>
                                            </div>
                                        </div>
                                    </template>

                                    <template v-slot:[`item.stock`]="{ item }">
                                        <h6 class="mt-3">
                                            {{
                                                "Total = " +
                                                    (item.stock_s +
                                                        item.stock_m +
                                                        item.stock_l +
                                                        item.stock_xl)
                                            }}
                                        </h6>
                                        <div class="caption mb-3">
                                            {{ "S = " + item.stock_s }}<br />
                                            {{ "M = " + item.stock_m }}<br />
                                            {{ "L = " + item.stock_l }}<br />
                                            {{ "XL = " + item.stock_xl }}
                                        </div>
                                    </template>

                                    <template v-slot:[`item.price`]="{ item }">
                                        <h6>
                                            {{
                                                "Rp. " +
                                                    item.price
                                                        .toString()
                                                        .replace(
                                                            /\B(?=(\d{3})+(?!\d))/g,
                                                            "."
                                                        ) +
                                                    ",00"
                                            }}
                                        </h6>
                                    </template>

                                    <template v-slot:[`item.active`]="{ item }">
                                        <v-chip
                                            :color="getColor(item.active)"
                                            dark
                                        >
                                            {{
                                                item.active
                                                    ? "Aktif"
                                                    : "Nonaktif"
                                            }}
                                        </v-chip>
                                    </template>

                                    <template v-slot:[`item.pengaturan`]>
                                        <v-icon
                                            class="mr-1"
                                            medium
                                            color="darken-2"
                                            @click="dialog = true"
                                        >
                                            mdi-trash-can-outline
                                        </v-icon>

                                        <v-icon
                                            medium
                                            color="darken-2"
                                            @click="checkDialog = true"
                                        >
                                            mdi-eyedropper-variant
                                        </v-icon>
                                    </template>
                                </v-data-table>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-tab-item>
            </v-tabs>
            <v-col md="3" offset-md="4"> </v-col>
        </v-card>

        <v-dialog v-model="dialog" persistent max-width="1200px">
            <v-card>
                <v-card-title>
                    <span class="headline">{{ formTitle }} Produk</span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-col>
                            <v-row cols="12" sm="6" md="4">
                                <div
                                    class="d-flex justify-center"
                                    v-if="image != null"
                                >
                                    <img
                                        v-if="
                                            image !=
                                                'https://www.generationsforpeace.org/wp-content/uploads/2018/03/empty.jpg'
                                        "
                                        class="rounded-card image-cover"
                                        :src="image"
                                    />
                                    <img
                                        v-else
                                        class="rounded-card image-cover"
                                        :src="image"
                                    />
                                    <br />
                                </div>
                                <br />
                                <div>
                                    <div class="col-md-6">
                                        <input
                                            type="file"
                                            ref="file"
                                            v-on:change="onImageChange"
                                            class="form-control"
                                        />
                                    </div>
                                </div>
                            </v-row>
                            <v-row>
                                <v-card-title>
                                    <span class="headline font-weight-bold"
                                        >Informasi Produk</span
                                    >
                                </v-card-title>
                            </v-row>

                            <v-row cols="12" sm="6" md="4">
                                <v-text-field
                                    v-model="form.nama_produk"
                                    label="Nama produk"
                                    required
                                ></v-text-field>
                            </v-row>

                            <v-row cols="10" sm="3" md="2" offset-md="1">
                                <v-text-field
                                    class="mr-2"
                                    v-model="form.stok"
                                    label="Stok"
                                    required
                                ></v-text-field>
                                <v-text-field
                                    class="ml-2"
                                    v-model="form.harga_jual"
                                    label="Harga jual"
                                    prefix="Rp."
                                    required
                                ></v-text-field>
                            </v-row>
                            <v-row>
                                <v-text-field
                                    v-model="form.harga_jual"
                                    label="Deskripsi"
                                    required
                                ></v-text-field>
                            </v-row>
                            <v-row>
                                <v-radio-group v-model="row" row label="Ukuran">
                                    <v-radio
                                        label="S"
                                        value="radio-1"
                                    ></v-radio>
                                    <v-radio
                                        label="M"
                                        value="radio-2"
                                    ></v-radio>
                                    <v-radio
                                        label="L"
                                        value="radio-2"
                                    ></v-radio>
                                    <v-radio
                                        label="XL"
                                        value="radio-2"
                                    ></v-radio>
                                </v-radio-group>
                            </v-row>

                            <v-row>
                                <v-radio-group v-model="row" row label="Status">
                                    <v-radio
                                        label="Aktif"
                                        value="radio-1"
                                    ></v-radio>
                                    <v-radio
                                        label="Non Aktif"
                                        value="radio-2"
                                    ></v-radio>
                                </v-radio-group>
                            </v-row>
                        </v-col>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="error" @click="cancel">
                        Cancel
                    </v-btn>
                    <v-btn color="success" @click="setForm">
                        Save
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <v-dialog v-model="dialogConfirm" persistent max-width="400px">
            <v-card>
                <v-card-title>
                    <span class="headline">warning!</span>
                </v-card-title>
                <v-card-text>
                    Anda yakin ingin menghapus produk ini?
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="blue darken-1"
                        text
                        @click="dialogConfirm = false"
                    >
                        Cancel
                    </v-btn>
                    <v-btn color="blue darken-1" text @click="deleteData">
                        Delete
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-snackbar v-model="snackbar" :color="color" timeout="2000" bottom>
            {{ error_message }}
        </v-snackbar>
    </v-main>
</template>

<script>
export default {
    name: "List",
    data() {
        return {
            image:
                "https://www.generationsforpeace.org/wp-content/uploads/2018/03/empty.jpg",

            defaultImage:
                "https://www.generationsforpeace.org/wp-content/uploads/2018/03/empty.jpg",
            inputType: "Tambah",
            load: false,
            snackbar: false,
            loader: null,
            loading2: false,
            error_message: "",
            imageUrl: null,
            color: "",
            search: null,
            aktifItem: "Aktif",
            dialog: false,
            dialogConfirm: false,
            item: new FormData(),
            items: [],
            form: {
                nama_produk: null,
                satuan: null,
                harga_jual: null,
                stok: null,
            },
            deleteId: "",
            editId: "",
            headers: [
                {
                    text: "Informasi Produk",
                    align: "start",
                    sortable: false,
                    value: "name",
                },
                { text: "Harga (Rp)", value: "price" },
                { text: "Stock #", value: "stock" },
                { text: "Status", value: "active" },
                { text: "Pengaturan", value: "pengaturan" },
            ],
            products: [
                {
                    name: "Ayam",
                    gender: "Man",
                    image: "aa",
                    stock_s: 2,
                    stock_m: 3,
                    stock_l: 6,
                    stock_xl: 2,
                    price: 200000,
                    description: "Kaos bang",
                    active: true,
                },
                {
                    name: "Ayam",
                    gender: "woman",
                    image: "aa",
                    stock_s: 2,
                    stock_m: 3,
                    stock_l: 6,
                    stock_xl: 2,
                    price: 200000,
                    description: "Kaos bang",
                    active: true,
                },
                {
                    name: "Ayam",
                    gender: "Man",
                    image: "aa",
                    stock_s: 2,
                    stock_m: 3,
                    stock_l: 6,
                    stock_xl: 2,
                    price: 200000,
                    description: "Kaos bang",
                    active: false,
                },
            ],
        };
    },
    methods: {
        onImageChange(e) {
            let files = e.target.files || e.dataTransfer.files;
            if (!files.length) return;
            this.createImage(files[0]);
            this.image = e.target.files[0];
            const reader = new FileReader();
            reader.onload = (e) => {
                this.image = e.target.result;
            };
            reader.readAsDataURL(this.image);
            this.checkImg = e.target.files[0];
            console.log(this.checkImg);
            this.handleFileUpload();
        },

        createImage(file) {
            let reader = new FileReader();
            let vm = this;
            reader.onload = (e) => {
                vm.image = e.target.result;
            };
            reader.readAsDataURL(file);
        },
        addProduct() {
            this.dialog = true;
            this.loader = "loading2";
        },

        readData() {
            var url = this.$api + "/item";
            this.$http
                .get(url, {
                    headers: {
                        Authorization:
                            "Bearer " + localStorage.getItem("token"),
                    },
                })
                .then((response) => {
                    this.items = response.data.data;
                });
        },
        editHandler(item) {
            this.inputType = "Ubah";
            this.editId = item.id;
            this.form.nama_produk = item.nama_produk;
            this.form.satuan = item.satuan;
            this.form.stok = item.stok;
            this.form.harga_jual = item.harga_jual;
            this.dialog = true;
        },
        deleteHandler(id) {
            this.deleteId = id;
            this.dialogConfirm = true;
        },
        close() {
            this.dialog = false;
            this.inputType = "Tambah";
        },
        cancel() {
            this.resetForm();
            this.readData();
            this.dialog = false;
            this.inputType = "Tambah";
        },
        resetForm() {
            this.form = {
                nama_produk: null,
                satuan: null,
                harga_jual: null,
                stok: null,
            };
        },
        getColor(status) {
            if (status) return "green";
            else return "red";
        },
        getSizes(item) {
            let sizes = [];
            if (item.stock_s) sizes.push("S");
            if (item.stock_m) sizes.push("M");
            if (item.stock_l) sizes.push("L");
            if (item.stock_xl) sizes.push("XL");

            return "Ukuran: " + sizes.join("/");
        },
    },
    computed: {
        formTitle() {
            return this.inputType;
        },
    },
    watch: {
        loader() {
            const l = this.loader;
            this[l] = !this[l];

            setTimeout(() => (this[l] = false), 2000);

            this.loader = null;
        },
    },
    mounted() {
        this.readData();
    },
};
</script>

<style>
.rounded-card {
    border-radius: 50px;
    height: 200px;
    width: 200px;
}

transparent {
    background-color: transparent !important;
}

.custom-loader {
    animation: loader 1s infinite;
    display: flex;
}
@-moz-keyframes loader {
    from {
        transform: rotate(0);
    }
    to {
        transform: rotate(360deg);
    }
}
@-webkit-keyframes loader {
    from {
        transform: rotate(0);
    }
    to {
        transform: rotate(360deg);
    }
}
@-o-keyframes loader {
    from {
        transform: rotate(0);
    }
    to {
        transform: rotate(360deg);
    }
}
@keyframes loader {
    from {
        transform: rotate(0);
    }
    to {
        transform: rotate(360deg);
    }
}
</style>
