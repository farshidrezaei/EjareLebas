<template>

    <v-navigation-drawer
            id="app-drawer"
            v-model="inputValue"
            app
            dark
            right
            mobile-break-point="991"
            width="260"
            height="auto"

    >
        <v-img
                :src="image"
                height="100%"
        >
            <v-layout
                    class="fill-height pb-3"
                    tag="v-list"
                    column

            >
                <!--avatar-->
                <v-list-tile avatar>
                    <v-list-tile-avatar
                            color="white"
                    >
                        <v-img
                                :src="this.user.avatar?this.user.avatar:this.logo"
                                height="34"
                                contain
                        />
                    </v-list-tile-avatar>
                    <v-list-tile-title class="title">{{this.user.full_name?this.user.full_name:'اجاره لباس'}}</v-list-tile-title>
                </v-list-tile>
                <v-divider/>
                <!--search-->
                <v-list-tile
                        v-if="responsive"
                >
                    <v-text-field
                            class="purple-input search-input"
                            label="Search..."
                            color="primary"
                    />
                </v-list-tile>
                <!--list-->
                <v-list-tile
                        v-for="(link, i) in this.links"
                        :key="i"
                        :disabled="link.disabled"
                        :to="link.to"
                        :active-class="color"
                        avatar
                        class="v-list-item"
                >

                    <v-list-tile-action>
                        <v-icon>{{ link.icon }}</v-icon>
                    </v-list-tile-action>
                    <v-list-tile-title
                            v-text="link.text"
                    />
                </v-list-tile>


            </v-layout>
        </v-img>
    </v-navigation-drawer>

</template>

<script>
    // Utilities
    import {
        mapMutations,
        mapState
    } from 'vuex'

    export default {
        data: () => ({
            logo: '/img/vuetifylogo.png',
            links: [
                {
                    to: '/dashboard',
                    icon: 'mdi-view-dashboard',
                    text: 'Dashboard',
                    disabled: false,
                },
                {
                    to: '/user-profile',
                    icon: 'mdi-account',
                    text: 'User Profile',
                    disabled: false,
                },
                {
                    to: '/clothes',
                    icon: 'mdi-tshirt-crew',
                    text: 'لباس ها',
                    disabled: false,

                },
                {
                    to: '/users',
                    icon: 'mdi-account',
                    text: 'کاربران',
                    disabled: false,
                },
                {
                    to: '/typography',
                    icon: 'mdi-format-font',
                    text: 'Typography',
                    disabled: false,
                },
                {
                    to: '/icons',
                    icon: 'mdi-chart-bubble',
                    text: 'Icons',
                    disabled: false,
                },
                {
                    to: '/maps',
                    icon: 'mdi-map-marker',
                    text: 'Maps',
                    disabled: false,
                },
                {
                    to: '/notifications',
                    icon: 'mdi-bell',
                    text: 'Notifications',
                    disabled: false,
                }
            ],
            admins: [
                ['Management', 'people_outline'],
                ['Settings', 'settings']
            ],
            cruds: [
                ['Create', 'add'],
                ['Read', 'insert_drive_file'],
                ['Update', 'update'],
                ['Delete', 'delete']
            ],
            responsive: true
        }),
        computed: {
            ...mapState('app', ['image', 'color']),
            ...mapState('auth', ['check', 'user']),
            inputValue: {
                get() {
                    return this.$store.state.app.drawer
                },
                set(val) {
                    this.setDrawer(val)
                }
            },
            items() {
                return this.$t('Layout.View.items')
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
            ...mapMutations('app', ['setDrawer', 'toggleDrawer']),

            onResponsiveInverted() {
                this.responsive = window.innerWidth < 991;
            }
        }
    }
</script>

<style lang="scss">
    #app-drawer {
        .v-list__tile {
            border-radius: 4px;

            &--buy {
                margin-top: auto;
                margin-bottom: 17px;
            }
        }

        .v-image__image--contain {
            top: 9px;
            height: 60%;
        }

        .search-input {
            margin-bottom: 30px !important;
            padding-left: 15px;
            padding-right: 15px;
        }

        .back-black {
            background-color: black;
        }
    }
</style>
