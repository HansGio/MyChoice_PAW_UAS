<template>
	<div>
		<v-card class="mx-auto pa-5 mt-16" elevation="3" outlined max-width="450px">
			<v-card-text align="center">
				<p class="display-1 text--primary">
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
					required
					type="password"
				></v-text-field>


				<v-btn @click="submit">Sign In</v-btn>
				
				<v-card-subtitle>
					Belum punya akun? <a v-on:click="register"> Sign Up </a>
				</v-card-subtitle>
			</form>
		</v-card>
	</div>
</template>

<script>
export default {
	name:"Login",
	data: () => ({
		email: "",
		password:"",
		load: false,
		snackbar: false,
		error_message: "",
		color: "",
		valid: false,
		// select: null,
		// checkbox: null,
		dictionary: {
			attributes: {
				email: "E-mail Address",
				// custom attributes
			},
			custom: {
				email: {
					required: () => "Name can not be empty",
				},
				select: {
					required: "Select field is required",
				},
			},
			
		},
	}),
	computed: {
	},

	methods: {
		register(){
			//  this.$router.push('/register')
		},
		submit() {
			if (this.email == "") {
				this.$http
				.post(this.$api + "/login", {
					email: this.email,
					password: this.password,
				})
				.then((response) => {
					localStorage.setItem("id", response.data.user.id); //menyimpan id user yang sedang login
					localStorage.setItem("token", response.data.access_token); //menyimpan auth token
					this.error_message = response.data.message;
					this.color = "green";
					this.snackbar = true;
					this.load = false;
					this.$router.push({
					name: "admin",
					});
				})
				.catch((error) => {
					this.error_message = error.response.data.message;
					this.color = "red";
					this.snackbar = true;
					localStorage.removeItem("token");
					this.load = false;
				});
			} else {
				this.$http
				.post(this.$api + "/login", {
					email: this.email,
					password: this.password,
				})
				.then((response) => {
					localStorage.setItem("id", response.data.user.id); //menyimpan id user yang sedang login
					localStorage.setItem("token", response.data.access_token); //menyimpan auth token
					this.error_message = response.data.message;
					this.color = "green";
					this.snackbar = true;
					this.load = false;
					this.$router.push({
					name: "",
					});
				})
				.catch((error) => {
					this.error_message = error.response.data.message;
					this.color = "red";
					this.snackbar = true;
					localStorage.removeItem("token");
					this.load = false;
				});
			}
		},
	},
};
</script>
 


