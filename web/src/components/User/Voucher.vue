<template>
    <v-row class="grey lighten-5 ml-4">
        <v-col cols="12" md="3" sm="6">

            <!-- <v-col 
                cols="12" md="3"
                v-for="voucher in vouchers"
                :key="voucher"
                class="pa-4"
            > -->

            <v-card
                class="mx-auto"
                outlined
                style="background-color:#FFBE76"
            >
                <v-card-actions>
                    <v-icon large> mdi-plus-circle-outline</v-icon>
                </v-card-actions>

                <v-list-item-content>
                    <v-list-item-title class="headline text-center">
                        Potongan Rp. {{}}
                    </v-list-item-title>
                    <hr />
                    <v-list-item-subtitle class="text-center"
                        >Kode Voucher</v-list-item-subtitle
                    >
                    <v-list-item-title class="headline text-center"
                        >{{}}
                    </v-list-item-title>
                </v-list-item-content>
            </v-card>
        </v-col>
    </v-row>
</template>

<script>
export default {
    data() {
        return{
            load: false,
            snackbar: false,
            error_message: "",
            color: "",
            search: null,
            dialog: false,
            dialogConfirm: false,
        }
    },

    methods: {
        readData() {
            var url = this.$api + "/voucher";
            this.$http
                .get(url, {
                    headers: {
                        Authorization:
                            "Bearer " + localStorage.getItem("token"),
                    },
                })
                .then((response) => {
                    this.vouchers = response.data.items;
                });
        },
        mounted() {
        this.readData();
        for (this.voucher in this.vouchers) {
            console.log(this.voucher);
        }
    },
    },

};
</script>
