<template>
	<div>
		<v-card class="mx-auto pa-5" elevation="3" outlined max-width="600px">
			<v-card-text align="center">
				<p class="display-1 text--primary">
					Contact Us
				</p>
				<p>Monday - Saturday (08.30 - 17.30)</p>
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
				<v-text-field
					dense
					outlined
					v-model="phone"
					label="Phone Number"
					data-vv-name="phone"
					required
					:counter="13"
				></v-text-field>
				<v-textarea v-model="message" outlined label="Message" :counter="120"></v-textarea>

				<v-btn color="primary" @click="submit">Send</v-btn>
			</form>
		</v-card>
	</div>
</template>

<script>
export default {
	data: () => ({
		name: "",
		email: "",
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
	methods: {
	},
};
</script>
