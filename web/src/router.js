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
			redirect: { name: "Home" },
			meta: { requiresAuth: true },
			component: importComponent("User/DashboardLayout"),
			children: [
				{
					path: "/home",
					name: "Home",
					meta: { title: "Home" },
					component: importComponent("User/Home"),
				},
				{
					path: "/about",
					name: "About",
					meta: { title: "About Us" },
					component: importComponent("User/About"),
				},
				{
					path: "/check-out",
					name: "Check Out",
					meta: { title: "Check Out" },
					component: importComponent("User/CheckOut"),
				},
				{
					path: "/contact-us",
					name: "Contact Us",
					meta: { title: "Contact Us" },
					component: importComponent("User/ContactUs"),
				},
				{
					path: "/item-details",
					name: "Item Details",
					meta: { title: "Item Details" },
					component: importComponent("User/ItemDetails"),
				},
				{
					path: "/man-list-item",
					name: "Man List Item",
					meta: { title: "Man List Item" },
					component: importComponent("User/ManListItem"),
				},
				{
					path: "/woman-list-item",
					name: "Woman List Item",
					meta: { title: "Woman List Item" },
					component: importComponent("User/WomanListItem"),
				},
				{
					path: "/profile",
					name: "Profile",
					meta: { title: "Profile" },
					component: importComponent("User/Profile"),
				},
				{
					path: "/recommendation-item",
					name: "Recommendation Item",
					meta: { title: "Recommendation Item" },
					component: importComponent("user/RecommendationItem"),
				},
				{
					path: "/shopping-bag",
					name: "Shopping Bag",
					meta: { title: "Shopping Bag" },
					component: importComponent("User/ShoppingBag"),
				},
				{
					path: "/voucher",
					name: "Voucher User",
					meta: { title: "Voucher User" },
					component: importComponent("User/Voucher"),
				},
				{
					path: "/admin",
					name: "Admin",
					meta: { adminArea: true },
					redirect: { name: "Dashboard Admin" },
					component: importComponent("Admin/DashboardLayout"),
					children: [
						{
							path: "dashboard",
							name: "Dashboard Admin",
							meta: { title: "Dashboard" },
							component: importComponent("Admin/Dashboard"),
						},
						{
							path: "daftar-produk",
							name: "Daftar Produk",
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
							name: "Daftar Pesanan",
							meta: { title: "Daftar Pesanan" },
							component: importComponent("Admin/DaftarPesanan"),
						},
						{
							path: "laporan",
							name: "Laporan",
							meta: { title: "Laporan" },
							component: importComponent("Admin/Laporan"),
						},
						{
							path: "voucher",
							name: "Voucher",
							meta: { title: "Voucher" },
							component: importComponent("Admin/Voucher"),
						},
					],
				},
			],
		},
		{
			path: "*",
			redirect: "/",
		},
	],
});

router.beforeEach((to, from, next) => {
	document.title = to.meta.title;
	next();
});

export default router;
