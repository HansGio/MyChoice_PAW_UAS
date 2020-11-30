<template>
	<v-main class="list">
		<div></div>

		<v-card>
			<v-tabs>
				<v-row class="mb-6" no-gutters>
					<v-tab> Semua Produk </v-tab>
					<v-tab> Aktif </v-tab>
					<v-tab> Non Aktif </v-tab>
					<v-col md="3" offset-md="4">
						<v-text-field
							v-model="search"
							append-icon="mdi-magnify"
							label="Search"
							single-line
							hide-details
						></v-text-field>
					</v-col>
				</v-row>
				<v-tab-item>
					<v-container fluid>
						<v-row>
							<v-col>
								<v-data-table :headers="headers" :items="desserts" :search="search">
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
										v-slot:item.status="{
											item,
										}"
									>
										<v-chip :color="getColor(item.status)" dark>
											{{ item.status }}
										</v-chip>
									</template>

									<template v-slot:item.pengaturan>
										<v-icon large color="darken-2" @click="dialog = true">
											mdi-trash-can-outline
										</v-icon>

										<v-icon large color="darken-2" @click="checkDialog = true">
											mdi-eyedropper-variant
										</v-icon>
									</template>
								</v-data-table>
							</v-col>
						</v-row>
					</v-container>
				</v-tab-item>

				<v-tab-item>
					<v-container fluid>
						<v-row>
							<v-col>
								<v-data-table
									:headers="headers"
									:items="desserts"
									:search="`aktif`"
								>
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
										v-slot:item.status="{
											item,
										}"
									>
										<v-chip :color="getColor(item.status)" dark>
											{{ item.status }}
										</v-chip>
									</template>

									<template v-slot:item.pengaturan>
										<v-icon large color="darken-2" @click="dialog = true">
											mdi-trash-can-outline
										</v-icon>

										<v-icon large color="darken-2" @click="checkDialog = true">
											mdi-eyedropper-variant
										</v-icon>
									</template>
								</v-data-table>
							</v-col>
						</v-row>
					</v-container>
				</v-tab-item>

				<v-tab-item>
					<v-container fluid>
						<v-row>
							<v-col>
								<v-data-table
									:headers="headers"
									:items="desserts"
									:search="`non aktif`"
								>
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
										v-slot:item.status="{
											item,
										}"
									>
										<v-chip :color="getColor(item.status)" dark>
											{{ item.status }}
										</v-chip>
									</template>

									<template v-slot:item.pengaturan>
										<v-icon large color="darken-2" @click="dialog = true">
											mdi-trash-can-outline
										</v-icon>

										<v-icon large color="darken-2" @click="checkDialog = true">
											mdi-eyedropper-variant
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

		<v-dialog v-model="dialog" persistent max-width="600px">
			<v-card>
				<v-card-title>
					<span class="headline">{{ formTitle }} Produk</span>
				</v-card-title>
				<v-card-text>
					<v-container>
						<v-text-field
							v-model="form.nama_produk"
							label="Nama produk"
							required
						></v-text-field>

						<v-text-field v-model="form.satuan" label="Satuan" required></v-text-field>

						<v-text-field
							v-model="form.harga_jual"
							label="Harga jual"
							required
						></v-text-field>

						<v-text-field v-model="form.stok" label="Stok" required></v-text-field>
					</v-container>
				</v-card-text>
				<v-card-actions>
					<v-spacer></v-spacer>
					<v-btn color="blue darken-1" text @click="cancel">
						Cancel
					</v-btn>
					<v-btn color="blue darken-1" text @click="setForm">
						Save
					</v-btn>
				</v-card-actions>
			</v-card>
		</v-dialog>

		<v-dialog v-model="dialogConfirm" persistent max-width="400px">
			<v-card>
				<v-card-title>
					<span class="headline">warning!</span>
				</v-card-title>
				<v-card-text>
					Anda yakin ingin menghapus produk ini?
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
			inputType: "Tambah",
			load: false,
			snackbar: false,
			error_message: "",
			color: "",
			search: null,
			aktifItem: "aktif",
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
					text: "Informasi Produk",
					align: "start",
					sortable: false,
					value: "name",
				},
				{ text: "Harga (Rp)", value: "harga" },
				{ text: "Stock #", value: "stock" },
				{ text: "Status", value: "status" },
				{ text: "Pengaturan", value: "pengaturan" },
			],
			desserts: [
				{
					name: "ayam",
					image: "aa",
					size: "s,m,l",
					harga: 200000,
					stock: 20,
					status: "aktif",
				},
				{
					name: "babi",
					image: "aa",
					size: "s,m,l",
					harga: 100000,
					stock: 10,
					status: "non aktif",
				},
				{
					name: "kaki babi",
					image: "aa",
					size: "s,m,l",
					harga: 100000,
					stock: 10,
					status: "non aktif",
				},
			],
		};
	},
	methods: {
		editHandler(item) {
			this.inputType = "Ubah";
			this.editId = item.id;
			this.form.nama_produk = item.nama_produk;
			this.form.satuan = item.satuan;
			this.form.stok = item.stok;
			this.form.harga_jual = item.harga_jual;
			this.dialog = true;
		},
		deleteHandler(id) {
			this.deleteId = id;
			this.dialogConfirm = true;
		},
		close() {
			this.dialog = false;
			this.inputType = "Tambah";
		},
		cancel() {
			this.resetForm();
			this.readData();
			this.dialog = false;
			this.inputType = "Tambah";
		},
		resetForm() {
			this.form = {
				nama_produk: null,
				satuan: null,
				harga_jual: null,
				stok: null,
			};
		},
		getColor(status) {
			if (status == "aktif") return "green";
			else return "red";
		},
	},
	computed: {
		formTitle() {
			return this.inputType;
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
