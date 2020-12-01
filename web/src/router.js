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
			path: "/admin",
			name: "Admin",
			component: importComponent("admin/DashboardLayout"),
			children: [
				{
					path: "/dashboardAdmin",
					name: "Dashboard Admin",
					meta: { title: "Dashboard" },
					component: importComponent("admin/Dashboard"),
				},
				{
					path: "/daftar-produk",
					name: "Daftar Produk",
					meta: { title: "Daftar Produk" },
					component: importComponent("admin/daftarProduk"),
				},
				{
					path: "/tambah-produk",
					name: "Tambah Produk",
					meta: { title: "Tambah Produk" },
					component: importComponent("admin/tambahProduk"),
				},
				{
					path: "/daftar-pesanan",
					name: "Daftar Pesanan",
					meta: { title: "Daftar Pesanan" },
					component: importComponent("admin/daftarPesanan"),
				},
				{
					path: "/laporan",
					name: "Laporan",
					meta: { title: "Laporan" },
					component: importComponent("admin/laporan"),
				},
				{
					path: "/voucher",
					name: "Voucher",
					meta: { title: "Voucher" },
					component: importComponent("admin/Voucher"),
				},
			],

		},

		{
			path:"/",
			redirect:"dashboard",
			component: importComponent("user/DashboardLayoutUser"),
			children: [
				{
					path: "/dashboard",
					name: "Dashboard",
					meta: {title: "Dashboard"},
					component: importComponent("user/DashboardUser")
				},
				{
					path: "/about",
					name: "About",
					meta: {title : "About Us"},
					component: importComponent("user/About")
				},
				{
					path: "/checkout",
					name: "Check Out",
					meta: {title : "Check Out"},
					component: importComponent("user/CheckOutUser")
				},
				{
					path: "/contactus",
					name: "Contact Us",
					meta: {title : "Contact Us"},
					component: importComponent("user/ContactUs")
				},
				{
					path: "/itemdetails",
					name: "Item Details",
					meta: {title: "Item Details"},
					component: importComponent("user/ItemDetails")
				},
				{
					path: "/manlistitem",
					name: "Man List Item",
					meta: {title: "Man List Item"},
					component: importComponent("user/ManListItemUser")
				},
				{
					path: "/womanlistitem",
					name: "Woman List Item",
					meta: {title: "Woman List Item"},
					component: importComponent("user/WomanListItemUser")
				},
				{
					path: "/profile",
					name: "Profile",
					meta: {title: "Profile"},
					component: importComponent("user/Profile")
				},
				{
					path: "/recommendationitem",
					name: "Recommendation Item",
					meta: {title: "Recommendation Item"},
					component: importComponent("user/RecommendationItemUser")
				},
				{
					path: "/shoppingbag",
					name: "Shopping Bag",
					meta: {title: "Shopping Bag"},
					component: importComponent("User/ShoppingBag")
				},
				{
					path: "/voucheruser",
					name: "Voucher User",
					meta: {title: "Voucher User"},
					component: importComponent("User/VoucherUser")
				},
			],

		},
	],
});

router.beforeEach((to, from, next) => {
	document.title = to.meta.title;
	next();
});

export default router;
