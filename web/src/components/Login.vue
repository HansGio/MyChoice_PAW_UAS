<template>
    <div>
        <v-card
            class="mx-auto pa-5 mt-16"
            elevation="3"
            outlined
            max-width="450px"
        >
            <v-card-text align="center">
                <p class="display-1 text--primary">
                    Sign In
                </p>
                <p>Selamat Datang, Silahkan Login</p>
            </v-card-text>
            <form align="center">
                <v-text-field
                    dense
                    outlined
                    v-model="email"
                    label="E-mail"
                    type="email"
                    required
                ></v-text-field>
                <v-text-field
                    dense
                    outlined
                    v-model="password"
                    label="Password"
                    required
                    type="text"
                ></v-text-field>
                <v-btn @click="submit">Sign In</v-btn>
                <v-card-subtitle>
                    Belum punya akun? <a v-on:click="register"> Sign Up </a>
                </v-card-subtitle>
            </form>
        </v-card>
    </div>
</template>

<script>
export default {
    name: "Login",
    data: () => ({
        // error: "",
        load: false,
        snackbar: false,
        error_message: "",
        color: "",
        valid: false,
        email: "",
        password: "",
        passwordRules: [(v) => !!v || "Password tidak boleh kosong :("],
        emailRules: [(v) => !!v || "E-mail tidak boleh kosong :("],
    }),
    computed: {},

    methods: {
        register() {
            this.$router.push("/register");
        },
        submit() {
            let url = this.$api + "/login";
            this.$http
                .post(url, {
                    email: this.email,
                    password: this.password,
                })
                .then((response) => {
                    localStorage.setItem("id", response.data.user.id);
                    localStorage.setItem("token", response.data.access_token);
                    localStorage.setItem(
                        "profileImg",
                        response.data.user.gambar
                    );

                    this.$router.replace("/");
                    console.table(response);
                })
                .catch((e) => {
                    this.error_message = e.response.data.message;
                    this.color = "red";
                    this.snackbar = true;
                });
        },
        clear() {
            this.$refs.form.reset(); //Clear form login
        },
    },
};
</script>
