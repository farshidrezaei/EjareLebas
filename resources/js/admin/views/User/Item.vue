<template>
    <v-container fill-height fluid grid-list-xl>

        <v-layout justify-center wrap>

            <v-flex xs12 md5>
                <v-container fluid>
                    <v-layout warp justify-center>
                        <v-flex xs12 md12>
                            <!--avatar-->
                            <material-card class="v-card-profile w-100">
                                <v-avatar
                                        slot="offset"
                                        class="mx-auto d-block "
                                        size="130"
                                >
                                    <v-img
                                            :src="`${item.avatar}`"
                                            :lazy-src="`${item.avatar}`"
                                            :size="130"
                                            aspect-ratio="1"
                                            class="grey lighten-2 avatar"
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
                                </v-avatar>
                                <v-card-text class="text-xs-center w-100">
                                    <p class="card-title font-weight-black">{{item.full_name}}</p>
                                    <p class="card-description  font-weight-light" style="text-align: justify">{{item.biography}}</p>
                                    <!--<v-btn-->
                                    <!--color="success"-->
                                    <!--round-->
                                    <!--class="font-weight-light"-->
                                    <!--&gt;Follow-->
                                    <!--</v-btn>-->
                                </v-card-text>
                            </material-card>

                            <!--information-->
                            <material-card
                                     color="primary"
                                    title="مشخصات کاربر"
                                    :text="item.full_name"
                            >

                                <v-container py-0>
                                    <v-layout wrap>
                                        <v-flex xs12>
                                            <p>نام: {{item.first_name}}</p>
                                            <p>نام خانوادگی: {{item.last_name}}</p>
                                            <p>جنسیت:
                                                <v-chip small>{{item.gender_farsi}}</v-chip>
                                            </p>
                                            <p>کدملی: {{item.national_code}}</p>
                                            <p>موبایل:
                                                <v-tooltip left>
                                                    <a slot="activator" :href="`tel:${item.mobile}`">{{item.mobile}}</a>
                                                    <span>برای تماس کلیک کنید.</span>
                                                </v-tooltip>
                                            </p>
                                            <p>ایمیل:
                                                <v-tooltip left>
                                                    <a slot="activator" :href="`mailto:${item.email}`">{{item.email}}</a>
                                                    <span>برای ارسال ایمیل کلیک کنید.</span>
                                                </v-tooltip>
                                            </p>

                                            <p v-if="item.address">آدرس:
                                                <v-tooltip left>
                                                    <a slot="activator" target="_blank" :href="`https://maps.google.com/maps?daddr=${parseFloat(item.y)},${parseFloat(item.x)}`">
                                                        {{item.address}}
                                                    </a>
                                                    <span>
                                                        نمایش روی نقشه
                                                    </span>
                                                </v-tooltip>
                                            </p>
                                            <p>تاریخ عضویت: {{item.created_at_fa}}</p>
                                        </v-flex>
                                    </v-layout>
                                </v-container>
                                <v-card class="elevation-5">
                                    <gmap-map :center="{lat:parseFloat(item.y),lng:parseFloat(item.x)}" ref="map" :zoom="19" style="width: 100%; height: 150px">
                                        <gmap-marker
                                                ref="marker"
                                                :position="{lat:parseFloat(item.y),lng:parseFloat(item.x)}"

                                        >
                                        </gmap-marker>
                                    </gmap-map>
                                </v-card>
                            </material-card>
                        </v-flex>

                    </v-layout>
                </v-container>

            </v-flex>

            <v-flex xs12 md7>
                <v-container fluid>
                    <v-layout warp justify-center>
                        <v-flex xs12 md12>
                            <!--datatable-->
                            <material-card
                                    class=" w-100"
                                     color="primary"
                                    title="لباس های کاربر"
                            >

                                <!--datatable-->
                                <v-data-table
                                        :headers="headers"
                                        :items="items"
                                        :pagination.sync="pagination"
                                        :total-items="totalItems"
                                        :loading="loading"


                                        class="elevation-1"
                                        item-key="id"


                                >
                                    <v-progress-linear slot="progress"  color="primary"   indeterminate></v-progress-linear>
                                    <template slot="items" slot-scope="props">
                                        <tr>
                                            <td>
                                                <router-link :to="`clothes/${props.item.id}`">
                                                    <v-tooltip top>
                                                        <p slot="activator">{{props.item.title}}</p>
                                                        <span>
                                                            <v-avatar
                                                                    size="150"
                                                            >
                                                                <img width="100%" :src="props.item.image" alt="image">
                                                            </v-avatar>
                                                        </span>
                                                    </v-tooltip>

                                                </router-link>
                                            </td>
                                            <td class="text-xs-right">
                                                <v-chip :color="
                                props.item.confirmation_status==='pending'?'warning'
                                :props.item.confirmation_status==='confirmed'?'success'
                                :'red'"
                                                        small
                                                        disabled
                                                        text-color="white">{{ props.item.confirmation_status_farsi }}
                                                </v-chip>

                                            </td>
                                            <td class="text-xs-right">{{ props.item.category.title }}</td>
                                        </tr>
                                    </template>
                                    <template slot="no-data">
                                        <v-alert :value="true" color="grey" icon="warning">
                                            چیزی برای نمایش وجود ندارد.
                                        </v-alert>
                                    </template>
                                    <template slot="pageText" slot-scope="props">
                                        موارد {{ props.pageStart }} تا {{ props.pageStop }} - از {{ props.itemsLength }} مورد
                                    </template>
                                </v-data-table>

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

                //datatable
                totalItems: 0,
                items: [],
                loading: true,
                pagination: {},
                headers: [
                    {
                        text: 'عنوان',
                        align: 'right',
                        value: 'title'
                    },
                    {
                        text: 'وضعیت تایید',
                        align: 'right',
                        value: 'confirmation_status'
                    },
                    {
                        text: 'دسته بندی',
                        align: 'right',
                        value: 'category'
                    },
                ],
            }
        },

        watch: {
            pagination: {
                handler() {
                    this.getDataFromApi()
                        .then(data => {
                            this.items = data.items;
                            this.totalItems = data.total;
                        })
                },
                deep: true
            },


        },
        created() {
            this.getDataFromApi()
                .then(data => {
                    this.items = data.items;
                    this.totalItems = data.total
                });
            let headers = {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${window.Auth.token()}`
            };
            axios.get(`/api/admin/users/${this.$route.params.id}`,{headers:headers})
                .then(response => {
                    this.item = response.data.response;
                })
                .catch(error => console.log(error.response.data));

        },

        methods: {
            getDataFromApi: function () {
                this.loading = true;
                return new Promise((resolve, reject) => {
                    const {sortBy, descending, page, rowsPerPage} = this.pagination;
                    let headers = {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${window.Auth.token()}`
                    };
                    axios.get(`/api/admin/users/${this.$route.params.id}/clothes`,{headers:headers})
                        .then((response) => {


                            let items = response.data.response;


                            const total = items.length;

                            if (this.pagination.sortBy) {
                                items = items.sort((a, b) => {
                                    const sortA = a[sortBy];
                                    const sortB = b[sortBy];

                                    if (descending) {
                                        if (sortA < sortB) return 1;
                                        if (sortA > sortB) return -1;
                                        return 0
                                    } else {
                                        if (sortA < sortB) return -1;
                                        if (sortA > sortB) return 1;
                                        return 0
                                    }
                                })
                            }

                            if (rowsPerPage > 0) {
                                items = items.slice((page - 1) * rowsPerPage, page * rowsPerPage)
                            }

                            setTimeout(() => {
                                this.loading = false;
                                resolve({
                                    items,
                                    total
                                })
                            }, 1000)
                        });


                })
            },
        }
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