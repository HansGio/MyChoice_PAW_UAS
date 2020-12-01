<template>
    <v-main class="list">
        <v-data-table :headers="headers" :items="desserts" :search="search">
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
                { text: "Nama Pembeli", value: "namaUser" },
                { text: "Nama Barang", value: "name" },
                { text: "Alamat", value: "alamat" },
                { text: "Resi", value: "resi" },
            ],
            desserts: [
                {
                    no: "1",
                    name: "ayam",
                    image: "aa",
                    size: "s,m,l",
                    harga: 200000,
                    stock: 20,
                    namaUser: "tolanda paling ganteng sedunia",
                    noHp: "08XXXXNERAKAXXX",
                    alamat: "Jln. Neraka seriusan, gg Gamping tukngku api",
                    resi: "tol 13 0 D 0 H",
                },
                {
                    no: "2",
                    name: "babi",
                    image: "aa",
                    size: "s,m,l",
                    harga: 100000,
                    stock: 10,
                    status: "non aktif",
                    namaUser: "tolanda paling ganteng sedunia",
                    noHp: "08XXXXNERAKAXXX",
                    alamat: "Jln. Neraka seriusan, gg Gamping tukngku api",
                    resi: "tol 13 0 D 0 H",
                },
                {
                    no: "3",
                    name: "kaki babi",
                    image: "aa",
                    size: "s,m,l",
                    harga: 100000,
                    stock: 10,
                    status: "non aktif",
                    namaUser: "tolanda paling ganteng sedunia",
                    noHp: "08XXXXNERAKAXXX",
                    alamat: "Jln. Neraka seriusan, gg Gamping tukngku api",
                    resi: "tol 13 0 D 0 H",
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
