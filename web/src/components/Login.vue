<template>
	<div>
		<v-img
			class="mx-auto mt-10"
			:src="require('@/assets/logo.png')"
			max-width="300"
			@click="$router.push('/home')"
		/>
		<v-card class="mx-auto pa-8 my-10" elevation="3" outlined max-width="450px">
			<v-card-text align="center">
				<p class="h1 text--primary">
					Sign In
				</p>
				<p>Selamat Datang, Silahkan Login</p>
			</v-card-text>
			<form align="center">
				<v-text-field
					dense
					outlined
					v-model="email"
					label="E-mail"
					type="email"
					required
				></v-text-field>
				<v-text-field
					dense
					outlined
					v-model="password"
					label="Password"
					:type="show1 ? 'text' : 'password'"
					:append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
					@click:append="show1 = !show1"
					required
				></v-text-field>
				<v-btn block elevation="0" class="grey darken-4" dark @click="submit"
					>Sign In</v-btn
				>
				<v-card-subtitle>
					Belum punya akun?
					<a class="light-blue--text" v-on:click="register"> Sign Up </a>
				</v-card-subtitle>
			</form>
		</v-card>
		<v-snackbar v-model="snackbar" :color="color" timeout="2000" bottom>
			{{ error_message }}
		</v-snackbar>
	</div>
</template>

<script>
export default {
	name: "Login",
	data: () => ({
		// error: "",
		show1: false,
		load: false,
		snackbar: false,
		error_message: "",
		color: "",
		valid: false,
		email: "",
		password: "",
		passwordRules: [(v) => !!v || "Password tidak boleh kosong :("],
		emailRules: [(v) => !!v || "E-mail tidak boleh kosong :("],
	}),
	computed: {},

	methods: {
		register() {
			this.$router.push("/register");
		},
		submit() {
			let url = this.$api + "/login";
			this.$http
				.post(url, {
					email: this.email,
					password: this.password,
				})
				.then((response) => {
					localStorage.setItem("id", response.data.user.id);
					localStorage.setItem("token", response.data.access_token);
					this.$router.replace("/");
					console.table(response);
					this.error_message = response.data.message;
					this.color = "green";
					this.snackbar = true;
					this.load = false;
					this.clear();
					this.create = false;
					this.$router.replace("/");
				})
				.catch((e) => {
					this.error_message = e.response.data.message;
					this.color = "red";
					this.snackbar = true;
					this.load = false;
				});
		},
		clear() {
			this.$refs.form.reset(); //Clear form login
		},
	},
};
</script>
