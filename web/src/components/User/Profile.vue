<template>
	<div>
		<v-card class="mx-auto pa-5" elevation="3" outlined max-width="1300px">
			<v-card-text align="Left">
				<p class="display-1 text--primary">
					Profile
				</p>
            <v-divider></v-divider>
			</v-card-text>

            <v-container>
                <v-row no-gutters>
                    <v-col
                        cols="8"
                        md="4"
                    >
                        <v-img
                            v-model="profilepic"
                            lazy-src="https://picsum.photos/id/11/10/6"
                            max-height="150"
                            max-width="250"
                            src="https://picsum.photos/id/11/500/300"
                        ></v-img>   
                        
                        </v-col>
                        <v-col
                            cols="12"
                            md="8"
                        >                      

                        <v-text-field
                            dense
                            v-model="name"
                            label="Name"
                        ></v-text-field>
                        <v-text-field
                            dense
                            v-model="email"
                            label="E-mail"
                        ></v-text-field>
                        <v-text-field
                            dense
                            v-model="gender"
                            label="Gender"
                            ></v-text-field>
                        <v-text-field
                            dense
                            v-model="birthdate"
                            label="Birthdate"					
                        ></v-text-field>
                        <v-text-field
                            dense
                            v-model="address"
                            label="Address"					
                        ></v-text-field>

                        <v-btn color="primary" @click="edit">Edit Profile</v-btn>

                    </v-col>
                    </v-row>
             </v-container>
		</v-card>
	</div>
</template>