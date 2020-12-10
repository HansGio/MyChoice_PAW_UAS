<template>
	<div>
		<v-card class="mx-auto pa-5 mt-16" elevation="3" outlined max-width="550px">
			<v-card-text align="center">
				<p class="display-1 text--primary">
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

				<v-select
				v-model="gender"
				:items="items"
				label="Gender"
				outlined
				></v-select>

                <v-text-field
					dense
					outlined
					v-model="password"
					label="Password"
					required
				></v-text-field>

                <v-text-field
					dense
					outlined
					v-model="confirmPassword"
					label="Confirm Password"
					required
				></v-text-field>

				<v-textarea v-model="address" outlined label="Address" :counter="120"></v-textarea>

				<v-btn @click="submit">Sign Up</v-btn>

                <v-card-subtitle>
					By signing up, you agree to our Terms & Conditions |
					<a v-on:click="login"> Sign In </a>
				</v-card-subtitle>

				<v-divider></v-divider>
				

			</form>
		</v-card>
	</div>
</template>
				<!-- 'name', 'email', 'password', 'phone', 'birth_date', 'gender', 'address', 'image64' -->

<script>
export default {
	data: () => ({
		name: "",
		email: "",
		password:"",
		address:"",
		confirmPassword:"",
		items:['Man' , 'Woman'],
		// select: null,
		// checkbox: null,
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
		fromDateDisp() {
		return this.birth_date;
		// format/do something with date
		},
	},

	methods: {
		login(){
			this.$router.push('/login')
		}
	},
};
</script>
 


