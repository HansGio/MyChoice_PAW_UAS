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
			name: "admin",
			component: importComponent("admin/DashboardLayout"),
			children: [
				{
					path: "/",
					name: "Root",
					meta: { title: "Dashboard" },
					component: importComponent("admin/Dashboard"),
				},
				{
					path: "/daftarProduk",
					name: "Daftar Produk",
					meta: { title: "Daftar Produk" },
					component: importComponent("admin/daftarProduk"),
				},
				{
					path: "/tambahProduk",
					name: "Tambah Produk",
					meta: { title: "Tambah Produk" },
					component: importComponent("admin/tambahProduk"),
				},{
					path: "/daftarPesanan",
					name: "Daftar Pesanan",
					meta: { title: "Daftar Pesanan" },
					component: importComponent("admin/daftarPesanan"),
				},{
					path: "/laporan",
					name: "Laporan",
					meta: { title: "Laporan" },
					component: importComponent("admin/laporan"),
				},{
					path: "/voucher",
					name: "Voucher",
					meta: { title: "Voucher" },
					component: importComponent("admin/voucher"),
				},{
					path: "/keluar",
					name: "Keluar",
					meta: { title: "Keluar" },
					component: importComponent("admin/keluar"),
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
