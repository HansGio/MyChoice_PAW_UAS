<template>
	<div>
		<v-img
			class="mx-auto mt-10"
			:src="require('@/assets/logo.png')"
			max-width="300"
			@click="$router.push('/home')"
		/>
		<v-card class="mx-auto pa-8 my-10" elevation="3" outlined max-width="550px">
			<v-card-text align="center">
				<p class="h1 text--primary">
					Sign Up
				</p>
				<p>Selamat Datang, silahkan melakukan Registrasi Akun</p>
				<v-divider></v-divider>
			</v-card-text>
			<form align="center">
				<v-text-field
					dense
					outlined
					v-model="name"
					label="Name"
					data-vv-name="name"
					required
				></v-text-field>
				<v-text-field
					dense
					outlined
					v-model="email"
					label="E-mail"
					data-vv-name="email"
					required
				></v-text-field>
				<v-text-field dense outlined v-model="phone" label="Phone" required></v-text-field>

				<v-menu
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
							outlined
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

				<v-select dense v-model="gender" :items="items" label="Gender" outlined></v-select>

				<v-text-field
					dense
					outlined
					v-model="password"
					label="Password"
					type="password"
					required
				></v-text-field>

				<v-text-field
					dense
					outlined
					v-model="confirm_password"
					label="Confirm Password"
					type="password"
					required
				></v-text-field>

				<v-textarea v-model="address" outlined label="Address" :counter="120"></v-textarea>

				<v-btn block elevation="0" class="grey darken-4" dark @click="submit"
					>Sign Up</v-btn
				>

				<v-card-subtitle>
					By signing up, you agree to our Terms & Conditions |
					<a class="light-blue--text" v-on:click="login"> Sign In </a>
				</v-card-subtitle>

				<v-divider></v-divider>
			</form>
		</v-card>
		<v-snackbar v-model="snackbar" :color="color" timeout="2000" bottom>
			{{ error_message }}
		</v-snackbar>
	</div>
</template>
<!-- 'name', 'email', 'password', 'phone', 'birth_date', 'gender', 'address', 'image64' -->

<script>
export default {
	data: () => ({
		name: "",
		email: "",
		password: "",
		address: "",
		phone: "",
		image64: "",
		gender: "",
		confirm_password: "",
		user: new FormData(),
		users: [],
		load: false,
		snackbar: false,
		error_message: "",
		color: "",
		items: ["Man", "Woman"],
		fromDateMenu: false,
		birth_date: null,
		minDate: "1990-01-01",
		maxDate: "2021-01-01",
		dictionary: {
			attributes: {
				email: "E-mail Address",
				// custom attributes
			},
			custom: {
				name: {
					required: () => "Name can not be empty",
				},
				select: {
					required: "Select field is required",
				},
			},
		},
	}),
	computed: {
		fromDateDisp() {
			return this.birth_date;
			// format/do something with date
		},
	},

	methods: {
		login() {
			this.$router.push("/login");
		},
		submit() {
			this.user.append("name", this.name);
			this.user.append("email", this.email);
			this.user.append("phone", this.phone);
			this.user.append("birth_date", this.birth_date);
			this.user.append("gender", this.gender);
			this.user.append("address", this.address);
			this.user.append("password", this.password);
			this.user.append("confirm_password", this.confirm_password);
			var url = this.$api + "/register";
			this.load = true;
			this.$http
				.post(url, this.user)
				.then((response) => {
					this.error_message = response.data.message;
					this.color = "green";
					this.snackbar = true;
					this.load = false;
					this.login();
					this.clear();
					this.create = false;
				})
				.catch((error) => {
					this.error_message = error.response.data.message;
					this.color = "red";
					this.snackbar = true;
					this.load = false;
				});
		},
	},
};
</script>
