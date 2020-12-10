<template>
  <v-row class="grey lighten-5 ml-4">
    <v-col cols="12" md="3" sm="6" v-for="">
        <v-card class="mx-auto" max-width="344" outlined  style="background-color:#FFBE76">
            <v-card-actions>
                <v-icon large  @click=""> mdi-plus-circle-outline</v-icon>
            </v-card-actions>
            
            <v-list-item-content>
                <v-list-item-title class="headline text-center"> Headline 5 {{}} </v-list-item-title>
                <hr>
                <v-list-item-subtitle class="text-center">Kode Voucher</v-list-item-subtitle>
                <v-list-item-title class="headline text-center">adas{{}} </v-list-item-title>
            </v-list-item-content>

            </v-list-item>

        </v-card>
    </v-col>
 </v-row> 

</template>

<script>
    export default{
        data : () => ({

        })
    }
</script>