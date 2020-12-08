<template>
  <v-carousel
    cycle
    height="500"
    hide-delimiter-background
    show-arrows-on-hover
  >
    <v-carousel-item
      v-for="(item,i) in items"
      :key="i"
      :src="item.src"
    ></v-carousel-item>
  </v-carousel>
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
      }
    },
  }
</script>

