<template>
    <v-container fill-height fluid grid-list-xl>

        <v-layout justify-center wrap>

            <v-flex xs12 md6>
                <v-container fluid>
                    <v-layout warp justify-start>
                        <v-flex xs12 md12>
                            <!--image-->
                            <material-card
                                    color="primary"
                                    title="تصویر لباس">
                                <v-card flat class="d-flex">
                                    <v-img
                                            :src="item.image"
                                            :lazy-src="item.image"
                                            aspect-ratio="1"
                                            class="grey lighten-2"
                                    >
                                        <template slot="placeholder">
                                            <v-layout
                                                    fill-height
                                                    align-center
                                                    justify-center
                                                    ma-0
                                            >
                                                <v-progress-circular indeterminate color="grey lighten-5"></v-progress-circular>
                                            </v-layout>
                                        </template>
                                    </v-img>
                                </v-card>
                            </material-card>

                            <!--information-->
                            <material-card
                                    color="primary"
                                    title="مشخصات لباس"
                                    :text="item.title"
                            >

                                <v-container py-0>
                                    <v-layout wrap>
                                        <v-flex xs12>
                                            <p>عنوان: {{item.title}}</p>
                                            <p>اندازه: {{item.size}}</p>
                                            <!--<p>جنسیت: {{item.gender}}</p>-->
                                            <p>توضیحات: {{item.description}}</p>
                                            <v-divider></v-divider>
                                            <br>
                                            <p>صاحب:
                                                <router-link tag="a" :to="`/users/${item.owner.id}`">
                                                        {{item.owner.full_name}}
                                                </router-link>
                                            </p>
                                        </v-flex>
                                    </v-layout>
                                </v-container>
                            </material-card>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-flex>
            <v-flex xs12 md6>
                <v-container fluid>
                    <v-layout warp justify-start>
                        <v-flex xs12 md12>
                            <!--gallery-->
                            <material-card
                                    color="primary"
                                    title="گالری"
                            >
                                <v-carousel
                                        delimiter-icon="stop"
                                        prev-icon="mdi-arrow-left"
                                        next-icon="mdi-arrow-right"
                                >
                                    <v-carousel-item
                                            v-for="(item,i) in items"
                                            :key="i"
                                            :src="item.src"
                                    ></v-carousel-item>
                                </v-carousel>
                            </material-card>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>

    import Avatar from 'vue-avatar';


    export default {
        name: 'item',
        components: {
            Avatar
        },
        data() {
            return {
                item: {},
                items: [
                    {
                        src: 'https://cdn.vuetifyjs.com/images/carousel/squirrel.jpg'
                    },
                    {
                        src: 'https://cdn.vuetifyjs.com/images/carousel/sky.jpg'
                    },
                    {
                        src: 'https://cdn.vuetifyjs.com/images/carousel/bird.jpg'
                    },
                    {
                        src: 'https://cdn.vuetifyjs.com/images/carousel/planet.jpg'
                    }
                ]

            }
        },


        created() {

            axios.get(`/api/admin/clothes/${this.$route.params.id}`)
                .then(response => {
                    this.item = response.data.response;
                })
                .catch(error => console.log(error.response.data));

        },

        methods: {}
    }
</script>

<style>
    .v-card-profile {
        width: 100%;
    }

    .avatar {
        box-shadow: 0 10px 30px -12px rgba(0, 0, 0, 0.42),
        0 4px 25px 0px rgba(0, 0, 0, 0.12),
        0 8px 10px -5px rgba(0, 0, 0, 0.2);
        border-radius: 50%;
        display: inline-flex;
        height: inherit;
        width: inherit;
    }
</style>