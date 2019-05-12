<template>
    <v-container
            fill-height
            fluid
            grid-list-xl
    >

        <v-layout wrap>
            <v-flex md6 sm12>
                <material-card
                        color="info"
                        title="ورود به حساب کاربری"
                >
                    <v-container>
                        <v-layout row wrap>

                            <!--title-->
                            <v-flex xs12 md6>
                                <v-text-field
                                        v-model="auth_data.username"
                                        label="نام کاربری"
                                        @keydown="errors.deleteError('username')"
                                        :error="errors.hasError('username')"
                                        :messages="errors.getErrorText('username')"
                                ></v-text-field>
                            </v-flex>
                            <!--title-->
                            <v-flex xs12 md6>
                                <v-text-field
                                        v-model="auth_data.password"
                                        label="کلمه عبور"
                                        @keydown="errors.deleteError('password')"
                                        :error="errors.hasError('password')"
                                        :messages="errors.getErrorText('password')"
                                ></v-text-field>
                            </v-flex>
                            <!--error-->
                            <v-flex xs12 md6>
                                <p v-if="error!==''">
                                    <small v-text="error" class="text-danger"></small>
                                </p>
                            </v-flex>

                            <v-flex xs12>
                                <v-layout warp al>
                                    <v-flex xs12 md6 justify-center align-center>
                                        <v-btn
                                                color="success"
                                                fab
                                                small
                                                @click="login"
                                                :disabled="login_loading"
                                                :loading="login_loading"
                                        >
                                            <v-icon small>mdi-login</v-icon>
                                        </v-btn>
                                    </v-flex>
                                    <v-flex xs12 md6>
                                        <v-btn color="red" v-if="authCheck" fab small @click="logout">
                                            <v-icon small>mdi-logout</v-icon>
                                        </v-btn>
                                    </v-flex>
                                </v-layout>
                            </v-flex>

                        </v-layout>
                    </v-container>
                </material-card>
            </v-flex>

        </v-layout>
    </v-container>

</template>

<script>


    import Errors from '../../error';
    import {
        mapMutations,
        mapState
    } from 'vuex'

    export default {
        data: () => ({
            errors: new Errors(),
            error: '',
            auth_data: {
                username: '',
                password: ''
            },

            login_loading: false
        }),
        computed: {
            authCheck: function () {
                return window.Auth.check();
            }
        },

        methods: {
            ...mapMutations('auth', ['setAuthCheck', 'setAuthUser', 'setAuthToken']),

            login: function () {
                this.login_loading = true;
                axios.post('api/auth/login', this.auth_data)
                    .then(response => {
                        this.login_loading = false;
                        if (response.data.result === false) {
                            if (response.data.code === 101)
                                this.errors.recordErrors(response.data.response);
                            if (response.data.code > 101) this.error = response.data.message;
                        } else {
                            console.log(response.data);
                            window.localStorage.auth = JSON.stringify(response.data.response);

                            this.setAuthCheck(response.data.response.check);
                            this.setAuthUser(response.data.response.user);
                            this.setAuthToken(response.data.response.token);

                            this.$router.push({path: `${this.$route.query.redirect}`});
                        }


                    })
                    .catch(response => {
                        console.log(response);
                        this.errors.recordErrors(response.response);
                        this.login_loading = false;
                    })
            },
            logout: function () {
                let headers = {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${window.Auth.token()}`
                };
                axios.post('api/auth/logout', {}, {headers: headers}).then(response => {
                    window.localStorage.removeItem('auth');
                    this.setAuthCheck(response.data.response.check);
                    this.setAuthUser(response.data.response.user);
                    this.setAuthToken(response.data.response.token);
                    console.log(response.data);

                })
                    .catch(response => {
                        console.log(response);
                    });
            },
        }
    }
</script>

<style>

</style>

