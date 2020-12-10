<template>
	<v-main class="list">
		<div></div>

		<v-card>
			<v-tabs>
				<v-row class="mb-6" no-gutters>
					<v-tab> Semua Produk </v-tab>
					<v-tab> Aktif </v-tab>
					<v-tab> NonAktif </v-tab>
					<v-col md="2" offset-md="3">
						<v-text-field
							v-model="search"
							append-icon="mdi-magnify"
							label="Search"
							single-line
							hide-details
						></v-text-field>
					</v-col>
					<v-col md="1" offset-md="1">
						<v-btn
							class="ma-2"
							:loading="loading2"
							:disabled="loading2"
							color="success"
							@click="addProduct"
						>
							Tambah Produk
							<template v-slot:loader>
								<span>Loading...</span>
							</template>
						</v-btn>
					</v-col>
				</v-row>
				<v-tab-item>
					<v-container fluid>
						<v-row>
							<v-col>
								<v-data-table :headers="headers" :items="items" :search="search">
									<template v-slot:[`item.name`]="{ item }">
										<div class="p-2 d-flex align-center">
											<v-img
												:src="
													item.image64 == NULL || item.image64 == 'null'
														? defaultImage
														: item.image64
												"
												:alt="item.name"
												max-height="100px"
												max-width="100px"
											/>
											<div class="ml-4">
												<h6>
													{{ item.name }}
													<v-icon small>{{
														item.gender.toLowerCase() == "man"
															? "mdi-gender-male"
															: "mdi-gender-female"
													}}</v-icon>
												</h6>
												<v-spacer></v-spacer>
												<span class="caption">{{ getSizes(item) }}</span>
											</div>
										</div>
									</template>

									<template v-slot:[`item.stock`]="{ item }">
										<h6 class="mt-3">
											{{
												"Total = " +
													(item.stock_s +
														item.stock_m +
														item.stock_l +
														item.stock_xl)
											}}
										</h6>
										<div class="caption mb-3">
											{{ "S = " + item.stock_s }}<br />
											{{ "M = " + item.stock_m }}<br />
											{{ "L = " + item.stock_l }}<br />
											{{ "XL = " + item.stock_xl }}
										</div>
									</template>

									<template v-slot:[`item.price`]="{ item }">
										<h6>
											{{
												"Rp. " +
													item.price
														.toString()
														.replace(/\B(?=(\d{3})+(?!\d))/g, ".")
											}}
										</h6>
									</template>

									<template v-slot:[`item.active`]="{ item }">
										<v-chip :color="getColor(item.active)" dark>
											{{ item.active ? "Aktif" : "Nonaktif" }}
										</v-chip>
									</template>

									<template v-slot:[`item.pengaturan`]="{ item }">
										<v-icon
											class="mr-1"
											medium
											color="darken-2"
											@click="deleteHandler(item)"
										>
											mdi-trash-can-outline
										</v-icon>

										<v-icon medium color="darken-2" @click="editHandler(item)">
											mdi-pencil
										</v-icon>
									</template>
								</v-data-table>
							</v-col>
						</v-row>
					</v-container>
				</v-tab-item>
			</v-tabs>
			<v-col md="3" offset-md="4"> </v-col>
		</v-card>

		<v-dialog v-model="dialog" persistent max-width="1200px">
			<v-card>
				<v-card-title>
					<span class="headline">{{ formTitle }} Produk</span>
				</v-card-title>
				<v-card-text>
					<v-container>
						<v-col>
							<v-row cols="12" sm="6" md="4">
								<div class="d-flex justify-center" v-if="image != null">
									<img
										v-if="
											image !=
												'https://www.generationsforpeace.org/wp-content/uploads/2018/03/empty.jpg'
										"
										class="rounded-card image-cover"
										:src="image"
									/>
									<img v-else class="rounded-card image-cover" :src="image" />
									<br />
								</div>
								<br />
								<div>
									<div class="col-md-6">
										<input
											type="file"
											ref="file"
											id="imageUpload"
											v-on:change="onImageChange"
											class="form-control"
										/>
									</div>
								</div>
							</v-row>
							<v-row>
								<v-card-title>
									<span class="headline font-weight-bold">Informasi Produk</span>
								</v-card-title>
							</v-row>

							<v-row cols="12" sm="6" md="4">
								<v-text-field
									v-model="form.name"
									label="Nama produk"
									required
								></v-text-field>
							</v-row>

							<v-row cols="12" sm="6" md="4">
								<v-text-field
									v-model="form.stock_s"
									label="Stok S"
									type="number"
									required
								></v-text-field>
							</v-row>

							<v-row cols="12" sm="6" md="4">
								<v-text-field
									v-model="form.stock_m"
									label="Stok M"
									type="number"
									required
								></v-text-field>
							</v-row>

							<v-row cols="12" sm="6" md="4">
								<v-text-field
									v-model="form.stock_l"
									label="Stok L"
									type="number"
									required
								></v-text-field>
							</v-row>

							<v-row cols="12" sm="6" md="4">
								<v-text-field
									v-model="form.stock_xl"
									label="Stok XL"
									type="number"
									required
								></v-text-field>
							</v-row>

							<v-row cols="12" sm="6" md="4">
								<v-text-field
									v-model="form.price"
									label="Harga jual"
									type="number"
									prefix="Rp."
									required
								></v-text-field>
							</v-row>

							<v-row>
								<v-text-field
									v-model="form.description"
									label="Deskripsi"
									required
								></v-text-field>
							</v-row>

							<v-row>
								<v-radio-group v-model="form.gender" row label="Gender">
									<v-radio label="Man" value="man"></v-radio>
									<v-radio label="Woman" value="woman"></v-radio>
								</v-radio-group>
							</v-row>
							<v-row>
								<v-checkbox v-model="form.active" label="Active"></v-checkbox>
							</v-row>
						</v-col>
					</v-container>
				</v-card-text>
				<v-card-actions>
					<v-spacer></v-spacer>
					<v-btn color="error" @click="cancel">
						Cancel
					</v-btn>
					<v-btn color="success" @click="save">
						Save
					</v-btn>
				</v-card-actions>
			</v-card>
		</v-dialog>

		<v-dialog v-model="dialogConfirm" persistent max-width="400px">
			<v-card>
				<v-card-title>
					<span class="headline">Warning!</span>
				</v-card-title>
				<v-card-text>
					Apakah anda yakin ingin menghapus produk ini?
				</v-card-text>
				<v-card-actions>
					<v-spacer></v-spacer>
					<v-btn color="blue darken-1" text @click="dialogConfirm = false">
						Cancel
					</v-btn>
					<v-btn color="blue darken-1" text @click="deleteData">
						Delete
					</v-btn>
				</v-card-actions>
			</v-card>
		</v-dialog>
		<v-snackbar v-model="snackbar" :color="color" timeout="2000" bottom>
			{{ error_message }}
		</v-snackbar>
	</v-main>
</template>

<script>
export default {
	name: "List",
	data() {
		return {
			image: "https://www.generationsforpeace.org/wp-content/uploads/2018/03/empty.jpg",

			defaultImage:
				"https://www.generationsforpeace.org/wp-content/uploads/2018/03/empty.jpg",
			inputType: "Tambah",
			load: false,
			snackbar: false,
			loader: null,
			loading2: false,
			error_message: "",
			imageUrl: null,
			color: "",
			search: null,
			aktifItem: "Aktif",
			dialog: false,
			dialogConfirm: false,
			item: new FormData(),
			items: [],
			form: {
				name: "",
				gender: "",
				stock_s: 0,
				stock_m: 0,
				stock_l: 0,
				stock_xl: 0,
				active: true,
				description: "",
				price: 0,
				image64: "",
			},
			deleteId: "",
			editId: "",
			headers: [
				{
					text: "Informasi Produk",
					align: "start",
					sortable: false,
					value: "name",
				},
				{ text: "Harga (Rp)", value: "price" },
				{ text: "Stock #", value: "stock" },
				{ text: "Status", value: "active" },
				{ text: "Pengaturan", value: "pengaturan" },
			],
		};
	},
	methods: {
		onImageChange(e) {
			let file = e.target.files[0];

			if (file["size"] > 950000) {
				alert("Photo to Big!");
			} else if (
				file["type"] != "image/jpeg" &&
				file["type"] != "image/bmp" &&
				file["type"] != "image/png" &&
				file["type"] != "image/gif"
			) {
				alert("Incompatible File Type");
				document.getElementById("imageUpload").value = "";
			} else {
				let reader = new FileReader();
				reader.onloadend = () => {
					alert("Photo Uploaded");
					this.image = reader.result;
					this.form.image64 = this.image;
					console.log(reader.result);
				};

				reader.readAsDataURL(file);
			}
		},
		deleteData() {
			//mengahapus data
			var url = this.$api + "/item/" + this.deleteId;
			//data dihapus berdasarkan id
			this.$http
				.delete(url, {
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
					this.inputType = "Tambah";
				})
				.catch((error) => {
					this.error_message = error.response.data.message;
					this.color = "red";
					this.snackbar = true;
					this.load = false;
				});
		},
		save() {
			this.item.append("name", this.form.name);
			this.item.append("gender", this.form.gender);
			this.item.append("stock_s", this.form.stock_s);
			this.item.append("stock_m", this.form.stock_m);
			this.item.append("stock_l", this.form.stock_l);
			this.item.append("stock_xl", this.form.stock_xl);
			this.item.append("active", this.form.active ? 1 : 0);
			this.item.append("description", this.form.description);
			this.item.append("price", this.form.price);
			this.item.append("image64", this.form.image64);

			var url = this.$api + "/item";
			this.load = true;
			this.$http
				.post(url, this.item, {
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
					this.color = "red";
					this.snackbar = true;
					this.load = false;
				});
		},
		createImage(file) {
			let reader = new FileReader();
			let vm = this;

			reader.onload = (e) => {
				vm.image = e.target.result;
			};
			reader.readAsDataURL(file);
		},
		addProduct() {
			this.dialog = true;
			this.loader = "loading2";
		},

		readData() {
			var url = this.$api + "/item";
			this.$http
				.get(url, {
					headers: {
						Authorization: "Bearer " + localStorage.getItem("token"),
					},
				})
				.then((response) => {
					this.items = response.data.items;
				});
		},
		editHandler(item) {
			this.inputType = "Ubah";
			this.editId = item.id;
			console.log(this.editId);
			this.form.name = item.name;
			this.form.gender = item.gender;
			this.form.stock_s = item.stock_s;
			this.form.stock_m = item.stock_m;
			this.form.stock_l = item.stock_l;
			this.form.stock_xl = item.stock_xl;
			this.form.active = item.active;
			this.form.description = item.description;
			this.form.price = item.price;
			this.image = item.image64;
			this.dialog = true;
		},
		deleteHandler(item) {
			this.deleteId = item.id;
			console.log(item.id);
			this.dialogConfirm = true;
		},
		close() {
			this.dialog = false;
			this.dialogConfirm = false;
			this.inputType = "Tambah";
		},
		cancel() {
			this.resetForm();
			this.readData();
			this.dialog = false;
			this.inputType = "Tambah";
		},
		resetForm() {
			this.image = this.defaultImage;
			this.form = {
				name: "",
				gender: "",
				stock_s: 0,
				stock_m: 0,
				stock_l: 0,
				stock_xl: 0,
				active: true,
				description: "",
				price: 0,
				image64: "",
			};
		},
		getColor(status) {
			if (status) return "green";
			else return "red";
		},
		getSizes(item) {
			let sizes = [];
			if (item.stock_s) sizes.push("S");
			if (item.stock_m) sizes.push("M");
			if (item.stock_l) sizes.push("L");
			if (item.stock_xl) sizes.push("XL");

			return "Ukuran: " + sizes.join("/");
		},
	},
	computed: {
		formTitle() {
			return this.inputType;
		},
	},
	watch: {
		loader() {
			const l = this.loader;
			this[l] = !this[l];

			setTimeout(() => (this[l] = false), 2000);

			this.loader = null;
		},
	},
	mounted() {
		this.readData();
	},
};
</script>

<style>
.rounded-card {
	border-radius: 50px;
	height: 200px;
	width: 200px;
}

transparent {
	background-color: transparent !important;
}

.custom-loader {
	animation: loader 1s infinite;
	display: flex;
}
@-moz-keyframes loader {
	from {
		transform: rotate(0);
	}
	to {
		transform: rotate(360deg);
	}
}
@-webkit-keyframes loader {
	from {
		transform: rotate(0);
	}
	to {
		transform: rotate(360deg);
	}
}
@-o-keyframes loader {
	from {
		transform: rotate(0);
	}
	to {
		transform: rotate(360deg);
	}
}
@keyframes loader {
	from {
		transform: rotate(0);
	}
	to {
		transform: rotate(360deg);
	}
}
</style>
