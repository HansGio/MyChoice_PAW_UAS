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
            <template
                v-slot:[`item.harga`]="{
                    item,
                }"
            >
                <div>
                    <h3 class="font-weight-bold">Rp. {{ item.harga }}</h3>
                </div>
            </template>
            <template
                v-slot:[`item.name`]="{
                    item,
                }"
            >
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
            <template
                v-slot:[`item.user`]="{
                    item,
                }"
            >
                <div class="p-2 d-flex align-center">
                    <div class="ml-3">
                        {{ item.namaUser }}
                        <v-spacer></v-spacer>
                        {{ item.noHp }}
                        <v-spacer></v-spacer>
                        {{ item.Alamat }}
                    </div>
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
                { text: "Informasi Produk", value: "name" },
                { text: "Informasi Penerima", value: "user" },
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
                    namaUser: "tolanda bodoh",
                    noHp: "08XXXXNERAKAXXX",
                    Alamat: "Jln. Neraka seriusan, gg Gamping tukngku api",
                },
                {
                    no: "2",
                    name: "babi",
                    image: "aa",
                    size: "s,m,l",
                    harga: 100000,
                    stock: 10,
                    status: "non aktif",
                    namaUser: "tolanda bodoh",
                    noHp: "08XXXXNERAKAXXX",
                    Alamat: "Jln. Neraka seriusan, gg Gamping tukngku api",
                },
                {
                    no: "3",
                    name: "kaki babi",
                    image: "aa",
                    size: "s,m,l",
                    harga: 100000,
                    stock: 10,
                    status: "non aktif",
                    namaUser: "tolanda bodoh",
                    noHp: "08XXXXNERAKAXXX",
                    Alamat: "Jln. Neraka seriusan, gg Gamping tukngku api",
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
