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
			redirect: { name: "Root" },
			component: importComponent("Admin/DashboardLayout"),
			children: [
				{
					path: "dashboard",
					name: "Root",
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
});

router.beforeEach((to, from, next) => {
	document.title = to.meta.title;
	next();
});

export default router;
