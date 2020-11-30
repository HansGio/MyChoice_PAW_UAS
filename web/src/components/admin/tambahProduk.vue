<template>
    <v-main class="list">
        <template>
            <div class="d-flex">
                <v-img
                    :src="
                        `https://images.unsplash.com/photo-1606654951863-70346cd12201?ixlib=rb-1.2.1&ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&auto=format&fit=crop&w=1268&q=80`
                    "
                    max-height="100px"
                    max-width="100px"
                ></v-img>
                <v-file-input
                    show-size
                    class="col-5"
                    label="+ Tambah Foto"
                ></v-file-input>
            </div>
        </template>
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
            checkDialog: false,
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
            ],
        };
    },
    methods: {
        getColor(status) {
            if (status == "aktif") return "green";
            else return "red";
        },
    },
};
</script>

<style>
transparent {
    background-color: transparent !important;
}
</style>
