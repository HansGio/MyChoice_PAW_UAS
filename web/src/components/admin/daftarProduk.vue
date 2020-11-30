<template>
    <v-main class="list">
        <div></div>

        <v-card>
            <v-card-title>
                <v-row class="mb-6" no-gutters>
                    <v-col md="5">
                        <template cols="12" sm="6" md="8">
                            <v-tabs align-with-title>
                                <v-tab> Semua Produk </v-tab>
                                <v-tab> Aktif </v-tab>
                                <v-tab> Non Aktif </v-tab>
                            </v-tabs>
                            <v-tab-item v-for="n in 3" :key="n">
                                <v-container fluid>
                                    <v-row>
                                        <v-col
                                            v-for="i in 6"
                                            :key="i"
                                            cols="12"
                                            md="4"
                                        >
                                            <v-img
                                                :src="
                                                    `https://picsum.photos/500/300?image=${i *
                                                        n *
                                                        5 +
                                                        10}`
                                                "
                                                :lazy-src="
                                                    `https://picsum.photos/10/6?image=${i *
                                                        n *
                                                        5 +
                                                        10}`
                                                "
                                                aspect-ratio="1"
                                            ></v-img>
                                        </v-col>
                                    </v-row>
                                </v-container>
                            </v-tab-item>
                        </template>
                    </v-col>
                    <v-col md="3" offset-md="4">
                        <v-text-field
                            v-model="search"
                            append-icon="mdi-magnify"
                            label="Search"
                            single-line
                            hide-details
                        ></v-text-field>
                    </v-col>
                </v-row>
                <div class="">
                    <v-col>
                        <v-spacer></v-spacer>
                    </v-col>
                </div>
            </v-card-title>
            <v-data-table :headers="headers" :items="desserts" :search="search">
                <template v-slot:[`item.name`]="{ item }">
                    <div class="p-2 d-flex align-center">
                        <v-img
                            :src="
                                `https://images.unsplash.com/photo-1606654951863-70346cd12201?ixlib=rb-1.2.1&ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&auto=format&fit=crop&w=1268&q=80`
                            "
                            :alt="item.name"
                            max-height="100px"
                            max-width="100px"
                        ></v-img>
                        <div class="ml-3">
                            {{ item.name }}
                            <v-spacer></v-spacer>
                            {{ item.size }}
                        </div>
                    </div>
                </template>

                <template v-slot:item.status="{ item }">
                    <v-chip :color="getColor(item.status)" dark>
                        {{ item.status }}
                    </v-chip>
                </template>

                <template v-slot:item.pengaturan>
                    <v-icon large color="darken-2" @click="dialog = true">
                        mdi-trash-can-outline
                    </v-icon>

                    <v-icon
                        large
                        color="darken-2"
                        @click="dialogConfirm = true"
                    >
                        mdi-eyedropper-variant
                    </v-icon>
                </template>
            </v-data-table>
        </v-card>

        <v-dialog v-model="dialog" persistent max-width="600px">
            <v-card>
                <v-card-title>
                    <span class="headline">{{ formTitle }} Produk</span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-text-field
                            v-model="form.nama_produk"
                            label="Nama produk"
                            required
                        ></v-text-field>

                        <v-text-field
                            v-model="form.satuan"
                            label="Satuan"
                            required
                        ></v-text-field>

                        <v-text-field
                            v-model="form.harga_jual"
                            label="Harga jual"
                            required
                        ></v-text-field>

                        <v-text-field
                            v-model="form.stok"
                            label="Stok"
                            required
                        ></v-text-field>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click="cancel">
                        Cancel
                    </v-btn>
                    <v-btn color="blue darken-1" text @click="setForm">
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
            inputType: "Tambah",
            load: false,
            snackbar: false,
            error_message: "",
            color: "",
            search: null,
            dialog: false,
            dialogConfirm: false,

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

            informasiProduk: [
                {
                    gambar: null,
                    nama_produk: null,
                    size: null,
                },
            ],

            headers: [
                {
                    text: "Informasi Produk",
                    align: "start",
                    sortable: false,
                    value: "name",
                },
                { text: "Harga (Rp)", value: "harga" },
                { text: "Stock #", value: "stock" },
                { text: "Status", value: "status" },
                { text: "Pengaturan", value: "pengaturan" },
            ],
            desserts: [
                {
                    name: "ayam",
                    image: "aa",
                    size: "s,m,l",
                    harga: 100000,
                    stock: 10,
                    status: "aktif",
                },
                {
                    name: "ayam",
                    image: "aa",
                    size: "s,m,l",
                    harga: 100000,
                    stock: 10,
                    status: "non aktif",
                },
                {
                    name: "ayam",
                    image: "aa",
                    size: "s,m,l",
                    harga: 100000,
                    stock: 10,
                    status: "non aktif",
                },
                {
                    name: "ayam",
                    image: "aa",
                    size: "s,m,l",
                    harga: 100000,
                    stock: 10,
                    status: "non aktif",
                },
                {
                    name: "ayam",
                    image: "aa",
                    size: "s,m,l",
                    harga: 100000,
                    stock: 10,
                    status: "non aktif",
                },
                {
                    name: "ayam",
                    image: "aa",
                    size: "s,m,l",
                    harga: 100000,
                    stock: 10,
                    status: "non aktif",
                },
            ],
        };
    },
    methods: {
        setForm() {
            if (this.inputType === "Tambah") {
                this.save();
            } else {
                this.update();
            }
        },
        //read data product
        readData() {
            var url = this.$api + "/product";
            this.$http
                .get(url, {
                    headers: {
                        Authorization:
                            "Bearer " + localStorage.getItem("token"),
                    },
                })
                .then((response) => {
                    this.products = response.data.data;
                });
        },
        //simpan data produk
        save() {
            this.product.append("nama_produk", this.form.nama_produk);
            this.product.append("satuan", this.form.satuan);
            this.product.append("harga_jual", this.form.harga_jual);
            this.product.append("stok", this.form.stok);

            var url = this.$api + "/product/";
            this.load = true;
            this.$http
                .post(url, this.product, {
                    headers: {
                        Authorization:
                            "Bearer " + localStorage.getItem("token"),
                    },
                })
                .then((response) => {
                    this.error_message = response.data.message;
                    this.color = "green";
                    this.snackbar = true;
                    this.load = false;
                    this.close();
                    this.readData(); //mengambil data
                    this.resetForm();
                })
                .catch((error) => {
                    this.error_message = error.response.data.message;
                    this.color = "red";
                    this.snackbar = true;
                    this.load = false;
                });
        },
        //ubah data produk
        update() {
            let newData = {
                nama_produk: this.form.nama_produk,
                satuan: this.form.satuan,
                harga_jual: this.form.harga_jual,
                stok: this.form.stok,
            };
            var url = this.$api + "/product/" + this.editId;
            this.load = true;
            this.$http
                .put(url, newData, {
                    headers: {
                        Authorization:
                            "Bearer " + localStorage.getItem("token"),
                    },
                })
                .then((response) => {
                    this.error_message = response.data.message;
                    this.color = "green";
                    this.snackbar = true;
                    this.load = false;
                    this.close();
                    this.readData(); //mengambil data
                    this.resetForm();
                    this.inputType = "Tambah";
                })
                .catch((error) => {
                    this.error_message = error.response.data.message;
                    this.color = "red";
                    this.snackbar = true;
                    this.load = false;
                });
        },
        //hapus data produk
        deleteData() {
            //mengahapus data
            var url = this.$api + "/product/" + this.deleteId;
            //data dihapus berdasarkan id
            this.$http
                .delete(url, {
                    headers: {
                        Authorization:
                            "Bearer " + localStorage.getItem("token"),
                    },
                })
                .then((response) => {
                    this.error_message = response.data.message;
                    this.color = "green";
                    this.snackbar = true;
                    this.load = false;
                    this.close();
                    this.readData(); //mengambil data
                    this.resetForm();
                    this.inputType = "Tambah";
                })
                .catch((error) => {
                    this.error_message = error.response.data.message;
                    this.color = "red";
                    this.snackbar = true;
                    this.load = false;
                });
            this.dialogConfirm = false;
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
            if (status == "aktif") return "green";
            else return "red";
        },
    },
    computed: {
        formTitle() {
            return this.inputType;
        },
    },
    mounted() {
        this.readData();
    },
};
</script>

<style>
transparent {
    background-color: transparent !important;
}
</style>
