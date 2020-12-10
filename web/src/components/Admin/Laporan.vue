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
            desserts: [],
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
