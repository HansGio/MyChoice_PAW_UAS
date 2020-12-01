<template>
    <v-main class="list">
        <v-data-table :headers="headers" :items="desserts" :search="search">
            <template v-slot:item.pengaturan>
                <v-icon large color="darken-2" @click="dialog = true">
                    mdi-trash-can-outline
                </v-icon>

                <v-icon large color="darken-2" @click="checkDialog = true">
                    mdi-eyedropper-variant
                </v-icon>
            </template>
            <template
                v-slot:[`item.voucherPrice`]="{
                    item,
                }"
            >
                <div>
                    <p class="font-weight-bold">Rp. {{ item.voucherPrice }}</p>
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
                    text: "No Kode Voucher",
                    align: "start",
                    sortable: false,
                    value: "no",
                },
                { text: "Nama Voucher", value: "namaVoucher" },
                { text: "Kode Voucher", value: "kodeVoucher" },
                { text: "Voucher", value: "voucherPrice" },
                { text: "action", value: "pengaturan" },
            ],
            desserts: [
                {
                    no: "1",
                    name: "ayam",
                    image: "aa",
                    size: "s,m,l",
                    harga: 200000,
                    stock: 20,
                    namaVoucher:
                        "cukup follow ig tolanda dapatkan potongan 100%",
                    noHp: "08XXXXNERAKAXXX",
                    alamat: "Jln. Neraka seriusan, gg Gamping tukngku api",
                    resi: "tol 13 0 D 0 H",
                    kodeVoucher: "TOL1818",
                    voucherPrice: 100000,
                },
                {
                    no: "2",
                    name: "babi",
                    image: "aa",
                    size: "s,m,l",
                    harga: 100000,
                    stock: 10,
                    status: "non aktif",
                    namaVoucher:
                        "cukup follow ig tolanda dapatkan potongan 100%",
                    noHp: "08XXXXNERAKAXXX",
                    alamat: "Jln. Neraka seriusan, gg Gamping tukngku api",
                    resi: "tol 13 0 D 0 H",
                    kodeVoucher: "TOL1818",
                    voucherPrice: 100000,
                },
                {
                    no: "3",
                    name: "kaki babi",
                    image: "aa",
                    size: "s,m,l",
                    harga: 100000,
                    stock: 10,
                    status: "non aktif",
                    namaVoucher:
                        "cukup follow ig tolanda dapatkan potongan 100%",
                    noHp: "08XXXXNERAKAXXX",
                    alamat: "Jln. Neraka seriusan, gg Gamping tukngku api",
                    resi: "tol 13 0 D 0 H",
                    kodeVoucher: "TOL1818",
                    voucherPrice: 100000,
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
