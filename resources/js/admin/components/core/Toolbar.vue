<template>
    <v-toolbar
            id="core-toolbar"
            flat
            prominent
            style="background: #eee;"
    >
        <div class="v-toolbar-title">
            <v-toolbar-title
                    class="tertiary--text font-weight-light"
            >
                <v-btn
                        v-if="responsive"
                        class="default v-btn--simple"
                        dark
                        icon
                        @click.stop="onClickBtn"
                >
                    <v-icon>mdi-view-list</v-icon>
                </v-btn>
                {{ title }}
            </v-toolbar-title>
        </div>

        <v-spacer/>

        <v-toolbar-items>
            <v-flex align-center layout py-2>


                <!--settings-->
                <v-menu
                        v-if="true"
                        :close-on-content-click="false"
                        bottom
                        left
                        offset-y
                        transition="slide-y-transition"
                >
                    <v-btn
                            v-ripple
                            slot="activator"
                            class="toolbar-items"
                            flat

                    >
                        <v-icon color="tertiary">mdi-settings</v-icon>
                    </v-btn>
                    <v-card>
                        <v-container grid-list-xl>
                            <v-layout wrap>
                                <v-flex xs12>
                                    <div class="text-xs-center body-2 text-uppercase sidebar-filter">Sidebar Filters</div>

                                    <v-layout justify-center>
                                        <v-avatar
                                                v-for="c in colors"
                                                :key="c"
                                                :class="[c === color ? 'color-active color-' + c: 'color-' + c]"
                                                size="23"

                                                @click="setColor(c)"
                                        />
                                    </v-layout>
                                    <v-divider class="mt-3"/>
                                </v-flex>
                                <v-flex
                                        xs12
                                >
                                    <div class="text-xs-center body-2 text-uppercase sidebar-filter">Images</div>
                                </v-flex>
                                <v-flex
                                        v-for="img in images"
                                        :key="img"
                                        xs3
                                >
                                    <v-img
                                            :class="[image === img ? 'image-active' : '']"
                                            :src="img"
                                            height="120"
                                            @click.native="setImage(img)"
                                    />
                                </v-flex>
                            </v-layout>
                        </v-container>
                    </v-card>
                </v-menu>

                <!--notifications-->
                <v-menu
                        bottom
                        left
                        content-class="dropdown-menu"
                        offset-y
                        transition="slide-y-transition">
                    <router-link
                            v-ripple
                            slot="activator"
                            class="toolbar-items"
                            to="/notifications"
                    >
                        <v-badge
                                color="error"
                                overlap
                        >
                            <template slot="badge">
                                {{ notifications.length }}
                            </template>
                            <v-icon color="tertiary">mdi-bell</v-icon>
                        </v-badge>
                    </router-link>
                    <v-card>
                        <v-list dense>
                            <v-list-tile
                                    v-for="notification in notifications"
                                    :key="notification"
                                    @click="onClick"
                            >
                                <v-list-tile-title
                                        v-text="notification"
                                />
                            </v-list-tile>
                        </v-list>
                    </v-card>
                </v-menu>

                <!--account-->
                <v-menu
                        v-if="true"
                        :close-on-content-click="true"
                        bottom
                        left
                        offset-y
                        transition="slide-y-transition"
                >
                    <v-btn
                            v-ripple
                            slot="activator"
                            class="toolbar-items"
                            flat

                    >
                        <v-icon color="tertiary">mdi-account</v-icon>
                    </v-btn>


                        <v-card width="300" class="pt-2"  v-if="check">

                            <v-avatar
                                    class="mx-auto d-block "
                                    size="130"

                            >
                                <img
                                        :src="`${this.user.avatar}`"
                                        class="elevation-7 "
                                        alt="avatar">
                            </v-avatar>
                            <v-card-text class="text-xs-center">

                                <span class="card-title font-weight-black d-block">{{this.user.full_name}}</span>
                                <v-btn
                                        color="danger"
                                        round
                                        @click="logout"
                                        class="font-weight-light"
                                >خروج
                                </v-btn>
                            </v-card-text>

                        </v-card>


                    <v-card v-else>
                        <v-container grid-list-xl>
                            <v-layout wrap>
                                <v-flex xs12>
                                    <v-card-text class="text-xs-center w-100">
                                        <router-link :to="{path:'/login'}">
                                            <v-btn color="primary">ورود</v-btn>
                                        </router-link>
                                    </v-card-text>
                                </v-flex>
                            </v-layout>
                        </v-container>
                    </v-card>
                </v-menu>
                <!--<router-link-->
                <!--v-ripple-->
                <!--class="toolbar-items"-->
                <!--to="/user-profile"-->
                <!--&gt;-->
                <!--<v-icon color="tertiary">mdi-account</v-icon>-->
                <!--</router-link>-->

                <!--back-->
                <a
                        v-if="checkBack"
                        class="toolbar-items"
                        @click="back"
                >
                    <v-icon color="tertiary">mdi-arrow-left-thick</v-icon>
                </a>


            </v-flex>
        </v-toolbar-items>

    </v-toolbar>
</template>

<script>

    import {
        mapMutations,
        mapState
    } from 'vuex'

    export default {
        data: () => ({
            notifications: [
                'Mike, John responded to your email',
                'You have 5 new tasks',
                'You\'re now a friend with Andrew',
                'Another Notification',
                'Another One'
            ],
            title: null,
            responsive: false,
            responsiveInput: false,

            colors: [
                'primary',
                'info',
                'success',
                'warning',
                'danger'
            ],
            images: [
                'https://demos.creative-tim.com/vue-material-dashboard/img/sidebar-1.23832d31.jpg',
                'https://demos.creative-tim.com/vue-material-dashboard/img/sidebar-2.32103624.jpg',
                'https://demos.creative-tim.com/vue-material-dashboard/img/sidebar-3.3a54f533.jpg',
                'https://demos.creative-tim.com/vue-material-dashboard/img/sidebar-4.3b7e38ed.jpg'
            ]
        }),

        watch: {
            '$route'(val) {
                this.title = val.name
            }
        },

        mounted() {
            this.onResponsiveInverted();
            window.addEventListener('resize', this.onResponsiveInverted)
        },
        beforeDestroy() {
            window.removeEventListener('resize', this.onResponsiveInverted)
        },


        methods: {
            back() {
                window.history.length > 1
                    ? this.$router.go(-1)
                    : this.$router.push('/')
            },
            checkBack() {
                return window.history.length > 1;
            },

            ...mapMutations('app', ['setDrawer', 'toggleDrawer']),
            onClickBtn() {
                this.setDrawer(!this.$store.state.app.drawer)
            },
            onClick() {
                //
            },
            logout: function () {
                let headers = {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${window.Auth.token()}`
                };
                axios.post('api/auth/logout', {}, {headers: headers}).then(response => {
                    console.log(response.data);
                    window.localStorage.removeItem('auth');
                    this.setAuthCheck(response.data.response.check);
                    this.setAuthUser(response.data.response.user);
                    this.setAuthToken(response.data.response.token);
                    this.$router.push('/login')

                })
                    .catch(response => {
                        console.log(response);
                    });
            },
            onResponsiveInverted() {
                if (window.innerWidth < 991) {
                    this.responsive = true;
                    this.responsiveInput = false
                } else {
                    this.responsive = false;
                    this.responsiveInput = true
                }
            },
            ...mapMutations('app', ['setImage']),
            ...mapMutations('auth', ['setAuthCheck', 'setAuthUser', 'setAuthToken']),
            setColor(color) {
                this.$store.state.app.color = color
            }
        },
        computed: {
            ...mapState('app', ['image', 'color']),
            ...mapState('auth', ['check', 'user', 'token']),

            color() {
                return this.$store.state.app.color
            },

        }
    }
</script>

<style>
    #core-toolbar a {
        text-decoration: none;
    }

    .v-toolbar:not(.v-toolbar--fixed) .v-toolbar__content {
        margin-left: 0 !important;
    }

    .v-avatar,
    .v-responsive {
        cursor: pointer;
    }
</style>

