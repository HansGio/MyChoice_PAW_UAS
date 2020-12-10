<template>
	<div>
		<v-card class="mx-auto" elevation="3" outlined>
			<v-card class="mx-auto pa-5" align="center" max-width="200px" color="#aee6e6">
				<h3 class="headline white--text text--accent-2">Man</h3>
			</v-card>
			<v-container>
				<v-row no-gutters>
					<v-col v-for="product in products" :key="product" class="pa-4">
						<v-card>
							<v-img :src="product.image64">
								<!-- <v-card-title
                                    v-text="card.title"
                                ></v-card-title> -->
							</v-img>
							<v-card-title>
								{{ product.name }}
							</v-card-title>
							<v-card-subtitle>
								Size S {{ product.stock_s }}
								<br />
								Size M {{ product.stock_m }}
								<br />
								Size L {{ product.stock_l }}
								<br />
								Size XL {{ product.stock_xl }}
								<br />
								<v-spacer></v-spacer>
								<p class="headline">Price Tag : {{ product.price }}</p>
								<br />
								Desc : {{ product.description }}
							</v-card-subtitle>
						</v-card>
					</v-col>
				</v-row>
			</v-container>
		</v-card>
	</div>
</template>

<script>
export default {
	data() {
		return {
			load: false,
			snackbar: false,
			error_message: "",
			color: "",
			search: null,
			dialog: false,
			dialogConfirm: false,
			headers: [
				{
					text: "Nama produk",
					align: "start",
					sortable: true,
					value: "nama_produk",
				},
				{ text: "Satuan", value: "satuan" },
				{ text: "Harga jual", value: "harga_jual" },
				{ text: "stok", value: "stok" },
				{ text: "Actions", value: "actions" },
			],
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
		};
	},
	methods: {
		readData() {
			var url = this.$api + "/item/man";
			this.$http
				.get(url, {
					headers: {
						Authorization: "Bearer " + localStorage.getItem("token"),
					},
				})
				.then((response) => {
					this.products = response.data.items;
				});
		},
	},
	mounted() {
		this.readData();
		for (this.product in this.products) {
			console.log(this.product);
		}
	},
};
</script>
<style>
.image-size {
	height: 250px;
	width: 100px;
}
</style>
