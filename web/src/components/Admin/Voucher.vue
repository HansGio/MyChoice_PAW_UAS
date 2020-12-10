<template>
	<v-main class="list">
		<v-data-table :headers="headers" :items="desserts" :search="search">
			<template v-slot:[`item.pengaturan`]>
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

			voucher: new FormData(),
			vouchers: [],
			form: {
				nama_produk: null,
				satuan: null,
				harga_jual: null,
				stok: null,
			},
			deleteId: "",
			editId: "",
		};
	},
	methods: {
		readData() {
			var url = this.$api + "/voucher";
			this.$http
				.get(url, {
					headers: {
						Authorization: "Bearer " + localStorage.getItem("token"),
					},
				})
				.then((response) => {
					this.vouchers = response.data.vouchers;
				});
		},
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
