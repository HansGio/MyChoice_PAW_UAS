<template>
	<div class="dashboard">
		<v-navigation-drawer v-model="drawer" color="#C5E1F4" class="fullheight" width="256" app>
			<div class="sizeLogo d-flex justify-content-center align-center">
				<img class="cover" src="../../assets/logo.png" alt="" />
			</div>
			<v-divider></v-divider>
			<v-list dense nav class="text-center">
				<v-list-item
					v-for="item in items"
					:key="item.title"
					link
					tag="router-link"
					:to="item.to"
				>
					<v-list-item-content>
						<v-list-item-title>{{ item.title }}</v-list-item-title>
					</v-list-item-content>
				</v-list-item>
			</v-list>
		</v-navigation-drawer>
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
			<v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
			<VSpacer />
			<v-toolbar-items>
				<v-btn text router @click="logout">
					<v-icon>{{ loggedIn ? "mdi-logout" : "mdi-login" }}</v-icon>
				</v-btn>
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
				{ title: "Dashboard", to: "dashboard" },
				{ title: "Daftar Produk", to: "daftar-produk" },
				{ title: "Daftar Pesanan", to: "daftar-pesanan" },
				{ title: "Laporan", to: "laporan" },
				{ title: "Voucher", to: "voucher" },
			],
		};
	},
	methods: {
		logout() {
			if (this.loggedIn) {
				var url = this.$api + "/logout";
				this.$http
					.get(url, {
						headers: {
							Authorization: "Bearer " + localStorage.getItem("token"),
						},
					})
					.then((response) => {
						this.error_message = response.data.message;
						this.color = "green";
						this.snackbar = true;
						this.load = false;
						localStorage.removeItem("id");
						localStorage.removeItem("token");
						localStorage.removeItem("email");
						// location.reload();
					})
					.catch((error) => {
						this.error_message = error.response.data.message;
						this.color = "red";
						this.snackbar = true;
						this.load = false;
					});
			} else this.$router.push("/login");
		},
	},
	computed: {
		loggedIn() {
			return localStorage.getItem("token") != null;
		},
	},
};
</script>

<style scoped>
.fullheight {
	min-height: 100vh !important;
}
.sizeLogo {
	height: 150px;
}
.cover {
	width: 200px;
}
</style>
