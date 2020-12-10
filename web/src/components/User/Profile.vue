<template>
	<div>
		<v-card class="mx-auto pa-5" elevation="3" outlined max-width="1300px">
			<v-card-text align="Left">
				<p class="display-1 text--primary">Profile</p>
				<v-divider></v-divider>
			</v-card-text>
			<v-container>
				<v-row no-gutters>
					<v-col cols="8" md="4">
						<v-img
							width="250px"
							:src="
								image64 !== null
									? image64
									: 'https://www.generationsforpeace.org/wp-content/uploads/2018/03/empty.jpg'
							"
						></v-img>
						<div class="container">
							<div class="large-12 medium-12 small-12 cell">
								<label>
									<input
										type="file"
										id="file"
										ref="file"
										accept="image/*"
										v-on:change="onImageChange"
									/>
								</label>
							</div>
						</div>
					</v-col>
					<v-col cols="12" md="8">
						<v-text-field dense v-model="name" label="Name"></v-text-field>
						<v-text-field dense readonly v-model="email" label="E-mail"></v-text-field>
						<v-select dense v-model="gender" :items="items" label="Gender"></v-select>
						<v-text-field dense v-model="phone" label="Phone Number"></v-text-field
						><v-menu
							v-model="fromDateMenu"
							:close-on-content-click="false"
							:nudge-right="40"
							transition="scale-transition"
							offset-y
							max-width="290px"
							min-width="290px"
						>
							<template v-slot:activator="{ on }">
								<v-text-field
									dense
									label="Birth Date"
									readonly
									:value="fromDateDisp"
									v-on="on"
								></v-text-field>
							</template>
							<v-date-picker
								locale="en-in"
								v-model="birth_date"
								no-title
								@input="fromDateMenu = false"
								:min="minDate"
							></v-date-picker>
						</v-menu>
						<v-text-field dense v-model="address" label="Address"></v-text-field>
						<v-card-actions>
							<v-spacer></v-spacer>
							<v-btn color="blue darken-1" text @click="cancel">
								Cancel
							</v-btn>
							<v-btn color="blue darken-1" text @click="updateData">
								Save
							</v-btn>
						</v-card-actions>
					</v-col>
				</v-row>
			</v-container>
		</v-card>

		<v-snackbar v-model="snackbar" :color="color" timeout="2000" bottom>
			{{ error_message }}
		</v-snackbar>
	</div>
</template>

<script>
export default {
	name: "User",
	data() {
		return {
			inputType: "Profile",
			enabled: false,
			load: false,
			snackbar: false,
			error_message: "",
			name: "",
			email: "",
			password: "",
			address: "",
			phone: "",
			image64: "",
			gender: "",
			minDate: "1990-01-01",
			maxDate: "2021-01-01",
			items: ["Man", "Woman"],
			confirm_password: "",
			current_password: "",
			birth_date: "",
			color: "",
			search: null,
			dialog: false,
			dialogConfirm: false,
			user: null,
			deleteId: "",
			editId: "",
			temp: 0,
			file: "",
		};
	},
	methods: {
		updateData() {
			let newDataProfile = {
				name: this.name,
				email: this.email,
				gender: this.gender,
				phone: this.phone,
				birth_date: this.birth_date,
				address: this.address,
				image64: this.image64,
			};
			var url = this.$api + "/update";
			this.load = true;
			this.$http
				.put(url, newDataProfile, {
					headers: {
						Authorization: "Bearer " + localStorage.getItem("token"),
					},
				})
				.then((response) => {
					this.error_message = response.data.message;
					this.color = "green";
					this.snackbar = true;
					this.load = false;
					this.readData();
				})
				.catch((error) => {
					this.error_message = error.response.data.message;
					this.color = "red";
					this.snackbar = true;
					this.load = false;
				});
		},

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
					this.image64 = reader.result;
					this.form.image64 = this.image64;
					console.log(reader.result);
				};

				reader.readAsDataURL(file);
			}
		},
		submitFile() {
			if (this.temp == 0) {
				this.error_message = "Upload image terlebih dahulu!";
				this.color = "red";
			} else {
				let formData = new FormData();
				formData.append("gambar", this.file);

				var url = this.$api + "/user/gambar/" + localStorage.getItem("id");
				this.load = true;
				this.$http
					.post(url, formData, {
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
			}
		},
		setForm() {
			if (this.enabled == false) this.save();
			else {
				if (this.newPass != this.confPass) {
					this.error_message = "Password Baru dan Konfirmasi Password berbeda!";
					this.snackbar = true;
				} else {
					this.update();
					this.save();
				}
			}
		},
		readData() {
			var url = this.$api + "/details";
			this.$http
				.get(url, {
					headers: {
						Authorization: "Bearer " + localStorage.getItem("token"),
					},
				})
				.then((response) => {
					this.user = response.data.user;
					this.name = response.data.user.name;
					this.email = response.data.user.email;
					this.phone = response.data.user.phone;
					this.birth_date = response.data.user.birth_date;
					this.gender = response.data.user.gender;
					this.address = response.data.user.address;
					this.image64 = response.data.user.image64;
				});
		},
		save() {
			let newData = {
				name: this.user.name,
				email: this.user.email,
			};
			var url = this.$api + "/user/" + localStorage.getItem("id");
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
					this.color = "red";
					this.snackbar = true;
					this.load = false;
				});
		},

		update() {
			let newData = {
				current_password: this.current_password,
				new_password: this.newPass,
				new_confirm_password: this.confPass,
			};
			var url = this.$api + "/user" + localStorage.getItem("id");
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
					this.color = "red";
					this.snackbar = true;
					this.load = false;
				});
		},
		cancel() {
			this.$router.push("/dashboard");
		},
	},
	computed: {
		formTitle() {
			return this.inputType;
		},
		fromDateDisp() {
			return this.birth_date;
			// format/do something with date
		},
	},
	mounted() {
		this.readData();
	},
};
</script>
