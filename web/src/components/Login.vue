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
					required
				></v-text-field>

				<v-text-field
					dense
					outlined
					v-model="password"
					label="Password"
					required
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
	data: () => ({
		email: "",
		password:"",
		// select: null,
		// checkbox: null,
		dictionary: {
			attributes: {
				email: "E-mail Address",
				// custom attributes
			},
			custom: {
				name: {
					required: () => "Name can not be empty",
					max: "The name field may not be greater than 10 characters",
					// custom messages
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
	},
};
</script>
 


