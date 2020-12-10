<template>
    <div>
        <v-card class="mx-auto pa-5" elevation="3" outlined max-width="1300px">
            <v-card-text align="Left">
                <p class="display-1 text--primary">Profile</p>
                <v-divider></v-divider>
            </v-card-text>
            <v-container>
                <v-row no-gutters>
                    <v-col cols="8" md="4">
                        <v-img
                            v-model="image64"
                            width="250px"
                            src="https://picsum.photos/id/11/500/300"
                        ></v-img>
                        <div class="container">
                            <div class="large-12 medium-12 small-12 cell">
                                <label
                                    >File
                                    <input
                                        type="file"
                                        id="file"
                                        ref="file"
                                        v-on:change="handleFileUpload()"
                                    />
                                </label>
                            </div>
                            <v-btn
                                color="blue darken-1"
                                text
                                @click="submitFile()"
                            >
                                Upload
                            </v-btn>
                        </div>
                    </v-col>
                    <v-col cols="12" md="8">
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
                            v-model="phone"
                            label="Phone Number"
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
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="blue darken-1" text @click="cancel">
                                Cancel
                            </v-btn>
                            <v-btn
                                color="blue darken-1"
                                text
                                @click="updateData"
                            >
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
            inputType: "Profile",
            enabled: false,
            load: false,
            snackbar: false,
            error_message: "",
            name: localStorage.getItem("name"),
            email: localStorage.getItem("email"),
            password: localStorage.getItem("password"),
            address: localStorage.getItem("address"),
            phone: localStorage.getItem("phone"),
            image64: "",
            gender: localStorage.getItem("gender"),
            confirm_password: "",
            current_password: "",
            birthdate: localStorage.getItem("birth_date"),
            color: "",
            search: null,
            dialog: false,
            dialogConfirm: false,
            user: null,
            deleteId: "",
            editId: "",
            temp: 0,
            file: "",
        };
    },
    methods: {
        updateData() {
            let newDataProfile = {
                name: this.name,
                email: this.email,
                gender: this.gender,
                phone: this.phone,
                birth_date: this.birthdate,
                address: this.address,
            };
            var url = this.$api + "/update";
            this.load = true;
            this.$http
                .put(url, newDataProfile, {
                    headers: {
                        Authorization:
                            "Bearer " + localStorage.getItem("token"),
                    },
                })
                .then((response) => {
                    localStorage.setItem("name", response.data.user.name);
                    localStorage.setItem("email", response.data.user.email);
                    localStorage.setItem("phone", response.data.user.phone);
                    localStorage.setItem(
                        "birth_date",
                        response.data.user.birth_date
                    );
                    localStorage.setItem("gender", response.data.user.gender);
                    localStorage.setItem("address", response.data.user.address);
                    this.error_message = response.data.message;
                    this.color = "green";
                    this.snackbar = true;
                    this.load = false;
                    // this.readData(); //mengambil data
                    // this.resetFormPassword();
                })
                .catch((error) => {
                    this.error_message = error.response.data.message;
                    this.color = "red";
                    this.snackbar = true;
                    this.load = false;
                });
        },

        handleFileUpload() {
            this.file = this.$refs.file.files[0];
            this.temp = 1;
        },
        submitFile() {
            if (this.temp == 0) {
                this.error_message = "Upload image terlebih dahulu!";
                this.color = "red";
            } else {
                let formData = new FormData();
                formData.append("gambar", this.file);

                var url =
                    this.$api + "/user/gambar/" + localStorage.getItem("id");
                this.load = true;
                this.$http
                    .post(url, formData, {
                        headers: {
                            Authorization:
                                "Bearer " + localStorage.getItem("token"),
                        },
                    })
                    .then((response) => {
                        this.error_message = response.data.message;
                        this.color = "green";
                        this.snackbar = true;
                        this.load = false;
                        this.close();
                        this.readData(); //mengambil data
                        this.resetForm();
                    })
                    .catch((error) => {
                        this.error_message = error.response.data.message;
                        this.color = "red";
                        this.snackbar = true;
                        this.load = false;
                    });
            }
        },
        setForm() {
            if (this.enabled == false) this.save();
            else {
                if (this.newPass != this.confPass) {
                    this.error_message =
                        "Password Baru dan Konfirmasi Password berbeda!";
                    this.snackbar = true;
                } else {
                    this.update();
                    this.save();
                }
            }
        },
        readData() {
            var url = this.$api + "/user/" + localStorage.getItem("id");
            this.$http
                .get(url, {
                    headers: {
                        Authorization:
                            "Bearer " + localStorage.getItem("token"),
                    },
                })
                .then((response) => {
                    this.user = response.data.data;
                });
        },
        save() {
            let newData = {
                name: this.user.name,
                email: this.user.email,
            };
            var url = this.$api + "/user/" + localStorage.getItem("id");
            this.load = true;
            this.$http
                .put(url, newData, {
                    headers: {
                        Authorization:
                            "Bearer " + localStorage.getItem("token"),
                    },
                })
                .then((response) => {
                    this.error_message = response.data.message;
                    this.color = "green";
                    this.snackbar = true;
                    this.load = false;
                    this.close();
                    this.readData(); //mengambil data
                    this.resetForm();
                })
                .catch((error) => {
                    this.error_message = error.response.data.message;
                    this.color = "red";
                    this.snackbar = true;
                    this.load = false;
                });
        },

        update() {
            let newData = {
                current_password: this.current_password,
                new_password: this.newPass,
                new_confirm_password: this.confPass,
            };
            var url =
                this.$api + "/user/password/" + localStorage.getItem("id");
            this.load = true;
            this.$http
                .put(url, newData, {
                    headers: {
                        Authorization:
                            "Bearer " + localStorage.getItem("token"),
                    },
                })
                .then((response) => {
                    this.error_message = response.data.message;
                    this.color = "green";
                    this.snackbar = true;
                    this.load = false;
                    this.close();
                    this.readData(); //mengambil data
                    this.resetForm();
                })
                .catch((error) => {
                    this.error_message = error.response.data.message;
                    this.color = "red";
                    this.snackbar = true;
                    this.load = false;
                });
        },
        cancel() {
            this.$router.push("/dashboard");
        },
    },
    computed: {
        formTitle() {
            return this.inputType;
        },
    },
    mounted() {
        // this.readData();
    },
};
</script>
