<template>
    <v-main class="list">
        <v-data-table :headers="headers" :items="desserts" :search="search">
            <template v-slot:item.statusPesanan>
                <div>
                    <v-btn elevation="2" color="green" class="mb-2"
                        >Kirim</v-btn
                    >
                    <br />
                    <v-btn elevation="2" color="red">Batal</v-btn>
                </div>
            </template>
        </v-data-table>
    </v-main>
</template>
<script>
export default {
    name: "List",
    data() {
        return {
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
            headers: [
                {
                    text: "No Pesanan",
                    align: "start",
                    sortable: false,
                    value: "no",
                },
                { text: "Informasi Produk", value: "harga" },
                { text: "Informasi Penerima", value: "harga" },
                { text: "Total Harga (Rp)", value: "harga" },
                { text: "Status", value: "statusPesanan" },
            ],
            desserts: [
                {
                    no: "1",
                    name: "ayam",
                    image: "aa",
                    size: "s,m,l",
                    harga: 200000,
                    stock: 20,
                },
                {
                    no: "2",
                    name: "babi",
                    image: "aa",
                    size: "s,m,l",
                    harga: 100000,
                    stock: 10,
                    status: "non aktif",
                },
                {
                    no: "3",
                    name: "kaki babi",
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
        close() {
            this.dialog = false;
        },
        cancel() {
            this.dialog = false;
        },
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
