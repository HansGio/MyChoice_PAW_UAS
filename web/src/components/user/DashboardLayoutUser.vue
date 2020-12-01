<template>
	<div class="dashboard">

		<v-dialog v-model="dialogConfirm" persistent max-width="400px">
			<v-card>
				<v-card-title>
					<span class="headline">warning!</span>
				</v-card-title>
				<v-card-text>
					Anda yakin ingin keluar?
				</v-card-text>
				<v-card-actions>
					<v-spacer></v-spacer>
					<v-btn color="blue darken-1" text @click="dialogConfirm = false">
						Cancel
					</v-btn>
					<v-btn color="red darken-1" text>
						Log Out
					</v-btn>
				</v-card-actions>
			</v-card>
		</v-dialog>

		<v-app-bar app fixed height="75px">

            <img class="mr-3" :src="require('@/assets/logo.png')" height="40"/>

			<VSpacer />
			<v-toolbar-items>
                <v-btn text router @click="about"> About </v-btn>
                <v-btn text router @click="contactus"> Contact Us </v-btn>
				<v-btn text router><v-icon>mdi-account</v-icon></v-btn>
				<v-btn text router><v-icon>mdi-power</v-icon></v-btn>
			</v-toolbar-items>
		</v-app-bar>
		<div class="fullheight pa-5">
			<router-view></router-view>
		</div>
		<v-snackbar v-model="snackbar" color="red" timeout="2000" bottom>
			{{ logouts }}
		</v-snackbar>
	</div>
</template>

<script>
export default {
	name: "Dashboard",
	data() {
		return {
			drawer: true,
			snackbar: false,
			dialogConfirm: false,
			dialog: false,
			logouts: "LogOut Success",

			items: [
				{ title: "About", to: "/About" },
				{ title: "Contact Us", to: "/ContactUs" },
			],
		};
    },
    
    methods:{
        about(){
            this.$router.push('About')
        },
        contactus(){
            this.$router.push('ContactUs')
        }
    }
};
</script>

<style scoped>
.fullheight {
	min-height: 100vh !important;
}
</style>
