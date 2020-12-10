<template>
	<v-container>
		<v-carousel cycle height="500" hide-delimiter-background show-arrows-on-hover class="pa-2">
			<v-carousel-item v-for="(item, i) in items" :key="i" :src="item.src"></v-carousel-item>
		</v-carousel>

		<v-item-group>
			<v-row dense class="mt-2">
				<v-col cols="12" md="6" class="pa-2">
					<v-item>
						<v-card
							class="d-flex justify-center pa-6"
							height="75"
							@click="man"
							color="#aee6e6"
						>
							<h3 class="headline white--text text--accent-2">Man</h3>
						</v-card>
					</v-item>
				</v-col>
				<v-col cols="12" md="6" class="pa-2">
					<v-item>
						<v-card
							class="d-flex justify-center pa-6"
							height="75"
							@click="woman"
							color="#fca3cc"
						>
							<h3 class="headline white--text text--accent-2">Woman</h3>
						</v-card>
					</v-item>
				</v-col>
			</v-row>
		</v-item-group>

		<v-row dense>
			<v-col class="pa-2" v-for="card in cards" :key="card.title" :cols="card.flex">
				<v-card>
					<v-img :src="card.src" height="600px">
						<v-card-title v-text="card.title"></v-card-title>
					</v-img>
				</v-card>
			</v-col>
		</v-row>

		<v-row dense>
			<v-col class="pa-2">
				<v-item>
					<v-card
						class="d-flex justify-center pa-6"
						height="75"
						@click="recommendation"
						color="#f5b461"
					>
						<h3 class="headline white--text text--accent-2">Weekly Recommendation</h3>
					</v-card>
				</v-item>
			</v-col>
		</v-row>

		<v-img
			lazy-src="require('@/assets/carousel-1.jpg')"
			max-height
			max-width
			:src="require('@/assets/carousel-1.jpg')"
			class="mt-4 ma-1"
		></v-img>
	</v-container>
</template>

<script>
export default {
	data() {
		return {
			items: [
				{
					src: require("@/assets/carousel-1.jpg"),
				},
				{
					src: require("@/assets/carousel-2.jpg"),
				},
				{
					src: require("@/assets/carousel-3.jpg"),
				},
			],
			cards: [
				{ src: require("@/assets/object1.jpg"), flex: 3 },
				{ src: require("@/assets/object2.jpg"), flex: 3 },
				{ src: require("@/assets/object3.jpg"), flex: 3 },
				{ src: require("@/assets/object4.jpg"), flex: 3 },
			],
		};
	},

	methods: {
		man() {
			this.$router.push("/man-list-item");
		},
		woman() {
			this.$router.push("/woman-list-item");
		},
		recommendation() {
			this.$router.push("/recommended-item");
		},
	},
};
</script>
