<template>
	<div>
		<v-card class="mx-auto" elevation="3" outlined >
			<v-card 
            class="mx-auto pa-5" 
            align="center" 
            max-width="200px" 
            color="#fca3cc">
				<h3 class="headline white--text text--accent-2"> Woman</h3>
			</v-card>

            <v-container>
                <v-row no-gutters>
                    <v-col
                        v-for="card in cards"
                        :key="card.title"
                        :cols="card.flex"
                        class="pa-4">
                        <v-card>
                        <v-img
                            :src="card.src"
                            height="450px">
                            <v-card-title v-text="card.title"></v-card-title>
                        </v-img>
                         <v-card-title>
                        Item Name
                        </v-card-title>

                        <v-card-subtitle>
                        Size
                        <v-spacer></v-spacer>
                        Price
                        </v-card-subtitle>

                        </v-card>
                    </v-col>
                    </v-row>
             </v-container>
		</v-card>
	</div>
</template>

<script>
  export default {
    data () {
      return {
        cards: [
          { src: require('@/assets/object1.jpg'), flex: 3 },
          { src: require('@/assets/object2.jpg'), flex: 3 },
          { src: require('@/assets/object3.jpg'), flex: 3 },
          { src: require('@/assets/object4.jpg'), flex: 3 },  
        ],

      }
    },
  }
</script>

