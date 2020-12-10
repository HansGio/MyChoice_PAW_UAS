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
                            v-model="image64"            
                            width="250px"
                            src="https://picsum.photos/id/11/500/300"
                            
                        ></v-img> 

                         <!-- :src="'http://localhost:8000'+user.gambar" -->

                        <div class="container">
                        <div class="large-12 medium-12 small-12 cell">
                            <label>File
                            <input type="file" id="file" ref="file" v-on:change="handleFileUpload()"/>
                            </label>
                        </div>
                        
                        <v-btn color="blue darken-1" text @click="submitFile()">
                            Upload
                        </v-btn>
                        </div>  


                        </v-col>
                        <v-col
                            cols="12"
                            md="8"
                        >                      

                        <v-text-field
                            dense
                            v-model="user.name"
                            label="Name"
                        >
                         {{ user.name }}
                        </v-text-field>
                         
                        <v-text-field
                            dense
                            v-model="user.email"
                            label="E-mail"
                        >{{ user.email }}
                        </v-text-field>

                        <v-text-field
                            dense
                            v-model="user.gender"
                            label="Gender"
                            >
                         {{ user.gender }}  
                        </v-text-field>
                        <v-text-field
                            dense
                            v-model="user.birthdate"
                            label="Birthdate"					
                        >
                        {{ user.birthdate }} </v-text-field>
                        <v-text-field
                            dense
                            v-model="address"
                            label="Address"					
                        ></v-text-field>

                        <!-- <v-btn color="primary" @click="edit">Edit Profile</v-btn> -->


                        <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="blue darken-1" text @click="cancel">
                            Cancel
                        </v-btn>
                        <v-btn color="blue darken-1" text @click="setForm">
                            Save
                        </v-btn>
                        </v-card-actions>
                    </v-col>
                    </v-row>
             </v-container>
		</v-card>

        
      <v-snackbar v-model="snackbar" :color="color" timeout="2000" bottom>
        {{ error_message }}
      </v-snackbar>
	</div>
</template>

<script>
  export default {
    name: "User",
    data() {
      return {
         user: {
                nama: '',
                email: '',
                phone: '',
                role: ''
            },
            formProfile: {
                nama_user: '',
                email: '',
                telepon: '',
                oldPassword: '',
                newPassword: '',
            },
            confirmPassword: '',
            image: '',
            profileImg: '',
            snackbar: false,
            color: '',
            error_message: '',
        
      };
    },
    methods: {
        loadData() {

            this.profileImg = localStorage.getItem('profileImg') ? this.$api + '/user/image/' + localStorage.getItem('profileImg') :
                'https://cdn1.iconfinder.com/data/icons/user-pictures/100/unknown-512.png';

            let url = this.$api + '/user';
            this.$http.get(url, {
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('token')
                }
            }).then(response => {

                this.user.nama = response.data.user.nama_user.toUpperCase();
                this.user.email = response.data.user.email;
                this.user.phone = response.data.user.telepon;
                this.user.role = response.data.user.role;

                this.formProfile.nama_user = this.user.nama;
                this.formProfile.email = this.user.email;
                this.formProfile.telepon = this.user.phone;

                console.table(response);
            }).catch(e => {
                this.error_message = e.response.data.message;
                this.color = "red";
                this.snackbar = true;
            });
        },
        save() {
            let url = this.$api + '/user/' + localStorage.getItem('id');

            if (this.confirmPassword === this.formProfile.newPassword) {
                this.$http.put(url, this.formProfile, {
                    headers: {
                        'Authorization': 'Bearer ' + localStorage.getItem('token')
                    }
                }).then((response) => {
                    this.loadData();
                    this.error_message = response.data.message;
                    this.color = "green";
                    this.snackbar = true;
                }).catch(e => {
                    this.error_message = e.response.data.message;
                    this.color = "red";
                    this.snackbar = true;
                })
            } else {
                this.error_message = "Password Tidak Sesuai";
                this.color = "red";
                this.snackbar = true;
            }
        },
        hapus() {
            let url = this.$api + '/user/' + localStorage.getItem('id');
            this.$http.delete(url, {
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem('token')
                }
            }).then(() => {
                this.$router.replace('/');
                localStorage.removeItem('id');
                localStorage.removeItem('token');
                localStorage.removeItem('profileImg');
            }).catch(e => {
                this.error_message = e.response.data.message;
                this.color = "red";
                this.snackbar = true;
            })
        },
        onChange(e) {
            const file = e.target.files[0]
            this.image = file
            this.profileImg = URL.createObjectURL(file)

            if (this.image) {
                let url = this.$api + '/user/image';
                let dataFile = new FormData();

                dataFile.append('gambar', this.image);
                dataFile.append('id', localStorage.getItem('id'));

                this.$http.post(url, dataFile, {
                    headers: {
                        'Authorization': 'Bearer ' + localStorage.getItem('token')
                    }
                }).then(response => {
                    localStorage.setItem('profileImg', response.data.user.gambar);
                    console.log(response);
                }).catch(e => {
                    console.log(e);
                })
            }
        }
    },
    mounted() {
        this.loadData();
    }
}
</script>