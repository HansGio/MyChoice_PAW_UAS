import Vue from "vue";
import VueRouter from "vue-router";

Vue.use(VueRouter);

function importComponent(path) {
	return () => import(`./components/${path}.vue`);
}

Vue.use(VueRouter);

const router = new VueRouter({
	mode: "history",
	routes: [
		{
			path: "/",
			redirect: { name: "home" },
			component: importComponent("User/DashboardLayout"),
			children: [
				{
					path: "/home",
					name: "home",
					meta: { title: "Home" },
					component: importComponent("User/Home"),
				},
				{
					path: "/about",
					name: "about",
					meta: { title: "About Us" },
					component: importComponent("User/About"),
				},
				{
					path: "/check-out",
					name: "checkOut",
					meta: { title: "Check Out", requiresAuth: true },
					component: importComponent("User/CheckOut"),
				},
				{
					path: "/contact-us",
					name: "contactUs",
					meta: { title: "Contact Us" },
					component: importComponent("User/ContactUs"),
				},
				{
					path: "/item-details",
					name: "itemDetails",
					meta: { title: "Item Details" },
					component: importComponent("User/ItemDetails"),
				},
				{
					path: "/man-list-item",
					name: "manListItem",
					meta: { title: "Man List Item" },
					component: importComponent("User/ManListItem"),
				},
				{
					path: "/woman-list-item",
					name: "womanListItem",
					meta: { title: "Woman List Item" },
					component: importComponent("User/WomanListItem"),
				},
				{
					path: "/profile",
					name: "Profile",
					meta: { title: "Profile", requiresAuth: true },
					component: importComponent("User/Profile"),
				},
				{
					path: "/recommended-item",
					name: "recommendedItem",
					meta: { title: "Recommended Item" },
					component: importComponent("User/RecommendedItem"),
				},
				{
					path: "/shopping-bag",
					name: "shoppingBag",
					meta: { title: "Shopping Bag", requiresAuth: true },
					component: importComponent("User/ShoppingBag"),
				},
				{
					path: "/voucher",
					name: "voucherUser",
					meta: { title: "Voucher" },
					component: importComponent("User/Voucher"),
				},
			],
		},
		{
			path: "/admin",
			name: "admin",
			meta: { adminArea: true },
			redirect: { name: "dashboardAdmin" },
			component: importComponent("Admin/DashboardLayout"),
			children: [
				{
					path: "dashboard",
					name: "dashboardAdmin",
					meta: { title: "Dashboard" },
					component: importComponent("Admin/Dashboard"),
				},
				{
					path: "daftar-produk",
					name: "daftarProduk",
					meta: { title: "Daftar Produk" },
					component: importComponent("Admin/DaftarProduk"),
				},
				{
					path: "tambah-produk",
					name: "Tambah Produk",
					meta: { title: "Tambah Produk" },
					component: importComponent("Admin/TambahProduk"),
				},
				{
					path: "daftar-pesanan",
					name: "daftarPesanan",
					meta: { title: "Daftar Pesanan" },
					component: importComponent("Admin/DaftarPesanan"),
				},
				{
					path: "laporan",
					name: "laporan",
					meta: { title: "Laporan" },
					component: importComponent("Admin/Laporan"),
				},
				{
					path: "voucher",
					name: "voucher",
					meta: { title: "Voucher" },
					component: importComponent("Admin/Voucher"),
				},
			],
		},
		{
			path: "/login",
			name: "login",
			meta: { title: "Login" },
			component: importComponent("Login"),
		},
		{
			path: "/register",
			name: "register",
			meta: { title: "Register" },
			component: importComponent("Register"),
		},


		{
			path: "*",
			redirect: "/",
		},
	],
});

router.beforeEach((to, from, next) => {
	document.title = to.meta.title;

	// // Kalau belum login redirect ke view login
	// if (to.matched.some((record) => record.meta.requiresAuth)) {
	// 	if (/* diganti kondisi belum login */) {
	// 		next({ name: "login" });
	// 	}
	// }

	// // Kalau bukan admin redirect ke view home
	// else if (to.matched.some((record) => record.meta.adminArea)) {
	// 	if (/* diganti kondisi bukan admin */) {
	// 		next({ name: "home" });
	// 	}
	// }

	next();
});

export default router;
