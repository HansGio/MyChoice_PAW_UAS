<template>
	<v-main class="list">
		<v-data-table :headers="headers" :items="orders" :search="search">
			<template v-slot:[`item.statusPesanan`]="{ item }">
				<div class="pa-4">
					<v-chip :color="getColor(item.delivery_status)" dark>
						{{ item.delivery_status }}
					</v-chip>
				</div>
			</template>

			<template v-slot:[`item.harga`]="{ item }">
				<div>
					<h5 class="font-weight-bold">Rp. {{ getTotal(item) }}</h5>
				</div>
			</template>

			<template v-slot:[`item.productInfo`]="{ item }">
				<div class="p-2">
					<div v-for="(detail, index) in item.order_details" :key="index">
						<p>
							{{
								index +
									1 +
									". Item Name: " +
									item.order_details[index].item_name +
									", Qty: " +
									item.order_details[index].item_quantity +
									", Size: " +
									item.order_details[index].item_size +
									", Price: Rp. " +
									item.order_details[index].buy_price
							}}
						</p>
					</div>
				</div>
			</template>
			<template v-slot:[`item.userInfo`]="{ item }">
				<div class="p-2 d-flex align-center">
					<div class="ml-3">
						<span class="h6">{{ item.recipient_name }}</span>
						<v-spacer></v-spacer>
						{{ item.recipient_phone }}
						<v-spacer></v-spacer>
						{{ item.recipient_address }}
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
			order: new FormData(),
			orders: [],
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
					value: "id",
				},
				{ text: "Informasi Produk", value: "productInfo" },
				{ text: "Informasi Penerima", value: "userInfo" },
				{ text: "Total Harga (Rp)", value: "harga" },
				{ text: "Status", value: "statusPesanan" },
			],
			desserts: [],
		};
	},
	methods: {
		getTotal(item) {
			let total = 0;
			item.order_details.forEach((element) => {
				total += parseFloat(element.buy_price) * parseInt(element.item_quantity);
			});

			return total;
		},
		getColor(status) {
			if (status == "Terkirim") return "green";
			else if (status == "Dibatalkan") return "red";
		},
		readData() {
			var url = this.$api + "/order";
			this.$http
				.get(url, {
					headers: {
						Authorization: "Bearer " + localStorage.getItem("token"),
					},
				})
				.then((response) => {
					console.log(response);
					this.orders = response.data.items;
					this.orders = this.orders.filter(
						(e) =>
							e.delivery_status === "Terkirim" || e.delivery_status === "Dibatalkan"
					);
				});
		},
		close() {
			this.dialog = false;
		},
		cancel() {
			this.dialog = false;
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
