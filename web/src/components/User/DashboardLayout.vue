<template>
	<div class="dashboardUser mt-16">
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

		<v-app-bar app fixed height="60px">
			<v-img
				class="mr-3"
				:src="require('@/assets/logo.png')"
				max-width="130"
				@click="$router.push('/home')"
			/>

			<VSpacer />
			<v-toolbar-items>
				<v-btn text router to="/about"> About </v-btn>
				<v-btn text router to="/contact-us"> Contact Us </v-btn>
				<v-btn text router to="/voucher"> Voucher </v-btn>
				<v-btn text router to="/profile"><v-icon>mdi-account</v-icon></v-btn>
				<v-btn text router to="/checkout"><v-icon>mdi-shopping</v-icon></v-btn>
				<v-btn text router><v-icon>mdi-power</v-icon></v-btn>
			</v-toolbar-items>
		</v-app-bar>
		<div class="fullheight pa-5">
			<router-view></router-view>
		</div>
		<v-snackbar v-model="snackbar" color="red" timeout="2000" bottom>
			{{ logouts }}
		</v-snackbar>
		
		<v-footer>
			<div class="text-center">
				<v-icon class="ml-5">mdi-account-circle</v-icon><base-text> Navigation</base-text>
				<space class="ml-10"></space>
				<v-icon>mdi-account-box-outline</v-icon><base-text> Contact Info</base-text>
			</div>

			<v-container fluid class="pa-0">
			<v-row>
				<v-col justify="space-around" class="ml-5">
					<v-btn text color="primary" router to="/about" >About</v-btn>
					<base-text class="ml-12">Email : MyChoice.cs@gmail.com </base-text>
					<br>
					<v-btn text color="primary" router to="/contact-us" >Help</v-btn>
					<base-text class="ml-15">WhatsApp : 021-235-5313</base-text>
					
				</v-col>
			</v-row>
			<v-row >
				<v-col class="text-center">
					<base-text class="text-center"> Copyright © 2020 All Right Reserved | MyChoice Team  </base-text>
				</v-col>
			</v-row>
			</v-container>
			
			
				
		</v-footer>
	</div>
</template>

<script>
export default {
	name: "DashboardUser",
	data() {
		return {
			drawer: true,
			snackbar: false,
			dialogConfirm: false,
			dialog: false,
			logouts: "LogOut Success",

			items: [
				{ title: "About", to: "/about" },
				{ title: "Contact Us", to: "/contact-us" },
				{ title: "Voucher", to: "/voucher" },
				{ title: "CheckOut", to:"/checkout"},
			],
		};
	},

	methods: {},
};
</script>

<style scoped>
.fullheight {
	min-height: 100vh !important;
}
</style>
