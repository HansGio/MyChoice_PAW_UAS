<template>
	<v-main class="list">
		<v-data-table :headers="headers" :items="orders" :search="search">
			<template v-slot:[`item.statusPesanan`]="{ item }">
				<div class="pa-4">
					<v-btn
						width="90px"
						elevation="2"
						color="green"
						class="mb-2"
						dark
						@click="deliverHandler(item)"
						>Kirim</v-btn
					>
					<br />
					<v-btn width="90px" elevation="2" color="red" dark @click="cancelHandler(item)"
						>Batal</v-btn
					>
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
		<v-dialog v-model="dialogConfirm" persistent max-width="400px">
			<v-card>
				<v-card-title>
					<span class="headline">Warning!</span>
				</v-card-title>
				<v-card-text>
					{{ formTitle }}
				</v-card-text>
				<v-card-actions>
					<v-spacer></v-spacer>
					<v-btn color="blue darken-1" text @click="dialogConfirm = false">
						Tidak
					</v-btn>
					<v-btn color="blue darken-1" text @click="save()">
						Ya
					</v-btn>
				</v-card-actions>
			</v-card>
		</v-dialog>
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
			editedItem: null,
			status: null,
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
		deliverHandler(item) {
			this.editedItem = item;
			this.status = "deliver";
			this.dialogConfirm = true;
		},
		cancelHandler(item) {
			this.editedItem = item;
			this.status = "cancel";
			this.dialogConfirm = true;
		},
		save() {
			if (status == "deliver") {
				this.deliverOrder();
			} else {
				this.cancelOrder();
			}
		},
		deliverOrder() {
			let item = this.editedItem;
			let newData = {
				user_id: item.user_id,
				recipient_address: item.recipient_address,
				recipient_name: item.recipient_name,
				recipient_phone: item.recipient_phone,
				delivery_status: "Terkirim",
			};

			console.log(newData);
			var url = this.$api + "/order/" + item.id;
			this.load = true;
			this.$http
				.put(url, newData, {
					headers: {
						Authorization: "Bearer " + localStorage.getItem("token"),
					},
				})
				.then((response) => {
					this.error_message = response.data.message;
					this.color = "green";
					this.snackbar = true;
					this.load = false;
					this.close();
					this.readData(); //mengambil data
					this.resetForm();
				})
				.catch((error) => {
					this.error_message = error.response.data.message;
					console.log(this.error_message);
					this.color = "red";
					this.snackbar = true;
					this.load = false;
				});
			this.dialogConfirm = false;
		},
		cancelOrder() {
			let item = this.editedItem;
			let newData = {
				user_id: item.user_id,
				recipient_address: item.recipient_address,
				recipient_name: item.recipient_name,
				recipient_phone: item.recipient_phone,
				delivery_status: "Dibatalkan",
			};

			console.log(newData);
			var url = this.$api + "/order/" + item.id;
			this.load = true;
			this.$http
				.put(url, newData, {
					headers: {
						Authorization: "Bearer " + localStorage.getItem("token"),
					},
				})
				.then((response) => {
					this.error_message = response.data.message;
					this.color = "green";
					this.snackbar = true;
					this.load = false;
					this.close();
					this.readData(); //mengambil data
					this.resetForm();
				})
				.catch((error) => {
					this.error_message = error.response.data.message;
					console.log(this.error_message);
					this.color = "red";
					this.snackbar = true;
					this.load = false;
				});
			this.dialogConfirm = false;
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
							e.delivery_status !== "Terkirim" && e.delivery_status !== "Dibatalkan"
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
	computed: {
		formTitle() {
			return this.status == "deliver"
				? "Apakah anda yakin ingin mengirim order ini?"
				: "Apakah anda yakin ingin membatalkan order ini?";
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
