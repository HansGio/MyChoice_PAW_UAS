<template>
	<div>
		<v-card class="mx-auto" elevation="3" outlined>
			<v-card class="mx-auto pa-5" align="center" max-width="200px" color="#fca3cc">
				<h3 class="headline white--text text--accent-2">Woman</h3>
			</v-card>
			<v-container>
				<v-row no-gutters>
					<v-col
						cols="12"
						md="3"
						sm="6"
						v-for="product in products"
						:key="product"
						class="pa-4"
					>
						<v-card>
							<v-img
								height="200"
								:src="
									product.image64
										? product.image64
										: 'https://www.generationsforpeace.org/wp-content/uploads/2018/03/empty.jpg'
								"
							>
								<!-- <v-card-title
                                    v-text="card.title"
                                ></v-card-title> -->
							</v-img>
							<v-card-title>
								{{ product.name }}
							</v-card-title>
							<v-card-subtitle>
								{{ getSizes(product) }}

								<v-spacer></v-spacer>
								<p class="headline">
									Rp.
									{{
										product.price
											.toString()
											.replace(/\B(?=(\d{3})+(?!\d))/g, ",")
									}}
								</p>
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
			var url = this.$api + "/item/woman";
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
		getSizes(item) {
			let sizes = [];
			if (item.stock_s) sizes.push("S");
			if (item.stock_m) sizes.push("M");
			if (item.stock_l) sizes.push("L");
			if (item.stock_xl) sizes.push("XL");

			return sizes.join("/");
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
