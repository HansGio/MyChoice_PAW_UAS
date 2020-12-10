<template>
    <v-main class="list">
        <v-data-table :headers="headers" :items="orders" :search="search">
            <!-- Kurang tampilan for didalam item -->
            <!-- <template v-slot:[`item.name`]>
                <div
                    v-for="order in order_detail"
                    :key="order"
                    cols="12"
                    xs="1"
                    sm="6"
                    md="2"
                >
                    {{ this.order.item_name }}
                    <br />
                </div>
            </template> -->
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
            products: [],
            form: {
                nama_produk: null,
                satuan: null,
                harga_jual: null,
                stok: null,
            },
            deleteId: "",
            editId: "",
            orders: [],
            order_detail: [],
            headers: [
                {
                    text: "No Pesanan",
                    align: "start",
                    sortable: false,
                    value: "id",
                },
                { text: "Nama Pembeli", value: "recipient_name" },
                { text: "Nama Barang", value: "name" },
                { text: "Alamat", value: "recipient_address" },
                { text: "Status", value: "delivery_status" },
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
        readDataOrderDetail() {
            var url = this.$api + "/order-detail";
            this.$http
                .get(url, {
                    headers: {
                        Authorization:
                            "Bearer " + localStorage.getItem("token"),
                    },
                })
                .then((response) => {
                    this.order_detail = response.data.items;
                });
        },
        readDataOrder() {
            var url = this.$api + "/order";
            this.$http
                .get(url, {
                    headers: {
                        Authorization:
                            "Bearer " + localStorage.getItem("token"),
                    },
                })
                .then((response) => {
                    this.orders = response.data.items;
                });
        },
    },
    mounted() {
        this.readDataOrder();
        this.readDataUser();
        for (this.product in this.products) {
            console.log(this.product);
        }
    },
};
</script>

<style>
transparent {
    background-color: transparent !important;
}
</style>
