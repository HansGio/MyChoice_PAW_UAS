<template>
  <div>

    <v-carousel
      cycle
      height="500"
      hide-delimiter-background
      show-arrows-on-hover class="pa-2"
    >
      <v-carousel-item
        v-for="(item,i) in items"
        :key="i"
        :src="item.src"
      ></v-carousel-item>
    </v-carousel>

    <v-item-group>
    <v-container fluid>
       <v-row no-gutters>
        <v-col
          v-for="n in 2"
          :key="n"
          cols="12"
          md="6">
          <v-item>
            <v-card
              class="d-flex align-center"
              height="75"
              @click="man"
            >
            </v-card>
            
          </v-item>
        </v-col>
      </v-row>
    </v-container>
  </v-item-group>


    <v-container fluid>
      <v-row dense>
        <v-col
          v-for="card in cards"
          :key="card.title"
          :cols="card.flex">
          <v-card>
            <v-img
              :src="card.src"
              height="470px">
              <v-card-title v-text="card.title"></v-card-title>
            </v-img>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<script>
  export default {
    data () {
      return {
        items: [
          {
            src: require('@/assets/carousel-1.jpg'),
          },
          {
            src: require('@/assets/carousel-2.jpg'),
          },
          {
            src: require('@/assets/carousel-3.jpg'),
          },
        ],
        cards: [
          { src: require('@/assets/object1.jpg'), flex: 3 },
          { src: require('@/assets/object2.jpg'), flex: 3 },
          { src: require('@/assets/object3.jpg'), flex: 3 },
          { src: require('@/assets/object4.jpg'), flex: 3 },  
        ],

      }
    },

    methods:{
        man(){
            this.$router.push('')
        },
        woman(){
            this.$router.push('')
        },
    }
  }
</script>

