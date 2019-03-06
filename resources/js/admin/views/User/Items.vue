<template>
    <div>

        <!--actions-->
        <v-container>

            <v-layout row warp>

                <!--add-item-->
                <v-tooltip top>
                    <v-btn
                            icon
                            fab
                            slot="activator"
                            small color="success" @click="addItem">
                        <v-icon small>mdi-plus</v-icon>

                    </v-btn>
                    <span>افزودن</span>
                </v-tooltip>
                <v-dialog
                        v-model="add_item_dialog"
                        fullscreen
                        hide-overlay
                        transition="dialog-bottom-transition"
                >
                    <v-card>
                        <add-item
                                item_title="کاربر"
                                :resource_url="resource_url"
                                v-on:close-dialog="add_item_dialog=false"
                                v-on:refresh="refreshItems"
                        ></add-item>

                        <div style="flex: 1 1 auto;"></div>
                    </v-card>
                </v-dialog>

                <!--edit-item-->
                <v-tooltip top>
                    <v-btn slot="activator"
                           small
                           icon
                           fab
                           color="orange"
                           v-if="selected.length===1"
                           @click="updateItem">

                        <v-icon small>edit</v-icon>

                    </v-btn>
                    <span>ویرایش</span>
                </v-tooltip>
                <v-dialog
                        v-model="edit_item_dialog"
                        fullscreen
                        hide-overlay
                        transition="dialog-bottom-transition"
                >
                    <v-card>
                        <edit-item
                                item_title="کاربر"
                                :resource_url="resource_url"
                                v-if="selected.length===1"
                                v-on:close-dialog="edit_item_dialog=false"
                                v-on:refresh="refreshItems"
                                :item_id="selected[0].id"
                        ></edit-item>
                        <div style="flex: 1 1 auto;"></div>
                    </v-card>
                </v-dialog>

                <!--delete-item-->
                <v-tooltip top>
                    <v-btn
                            icon
                            fab
                            slot="activator" small color="red" v-if="selected.length>0" @click="delete_item_dialog = true">
                        <v-icon small>delete</v-icon>
                    </v-btn>
                    <span>حذف</span>
                </v-tooltip>
                <v-dialog
                        v-model="delete_item_dialog"
                        persistent
                        max-width="290"
                >
                    <v-card>
                        <v-card-title class="headline">
                            <v-icon>delete</v-icon>
                            حذف
                        </v-card-title>
                        <v-card-text>آیا از حذف {{item_title}} های انتخاب شده مطمئن هستید؟</v-card-text>
                        <v-card-text class="text-danger" v-if="delete_item_error">{{delete_item_error_message}}</v-card-text>
                        <v-card-actions>
                            <v-btn color="info darken-1" small @click="delete_item_dialog = false">انصراف</v-btn>
                            <v-spacer></v-spacer>
                            <v-btn
                                    :loading="delete_item_loading"
                                    :disabled="delete_item_loading"
                                    color="red darken-1"
                                    small
                                    @click="deleteItems"

                            >
                                حذف
                                <span slot="loader">صبر کنید...</span>
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>

                <v-spacer></v-spacer>

                <!--refresh-item-->
                <v-tooltip top>
                    <v-btn
                            icon
                            fab
                            slot="activator"
                            small color="info"
                            :loading="refresh_items_loading"
                            :disabled="refresh_items_loading"
                            @click="refreshItems">
                        <v-icon small>refresh</v-icon>
                    </v-btn>
                    <span>بروزرسانی</span>
                </v-tooltip>

            </v-layout>
        </v-container>

        <!--datatable-->
        <v-data-table

                v-model="selected"
                :headers="headers"
                :items="items"
                :pagination.sync="pagination"
                :total-items="totalItems"
                :loading="loading"


                class="elevation-1"
                item-key="id"
                select-all

        >
            <v-progress-linear slot="progress" color="primary" indeterminate></v-progress-linear>
            <template slot="items" slot-scope="props">
                <tr>
                    <td>
                        <v-checkbox
                                v-model="props.selected"
                                primary
                                hide-details
                                :disabled="props.item.secured"
                        ></v-checkbox>
                    </td>
                    <td>
                        <router-link :to="`users/${props.item.id}`">
                            <v-tooltip top>
                                <p slot="activator">{{props.item.full_name}}</p>
                                <span>
                                    <v-avatar
                                        size="150"
                                    >
                                        <img width="100%" :src="props.item.avatar" alt="">
                                    </v-avatar>
                                </span>
                            </v-tooltip>

                        </router-link>
                    </td>
                    <td class="text-xs-right">
                        <v-icon>{{props.item.gender==='male'?'mdi-human-male':'mdi-human-female'}}</v-icon>
                    </td>
                    <td class="text-xs-right">
                        {{ props.item.email }}
                    </td>
                    <td class="text-xs-right">{{ props.item.created_at_fa }}</td>
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
            <!--<template slot="expand" slot-scope="props">-->
            <!--<v-card >-->
            <!--<v-container >-->
            <!--<v-layout warp row>-->
            <!--<v-flex xs12 >-->
            <!--<v-card-text>-->
            <!--<v-avatar color="grey" size="150">-->
            <!--<img-->
            <!--:src="props.item.avatar?props.item.avatar:'https://picsum.photos/300/300'"-->
            <!--alt="avatar"/>-->
            <!--</v-avatar>-->

            <!--</v-card-text>-->

            <!--</v-flex>-->

            <!--<v-flex xs12 >-->

            <!--<v-card-text>-->
            <!--<p>بیوگرافی:</p>-->
            <!--{{props.item.biography}}-->
            <!--</v-card-text>-->

            <!--</v-flex>-->

            <!--<v-flex xs12 >-->

            <!--<v-card-text>-->
            <!--<gmap-map :center="{lat:props.item.y,lng:props.item.x}" ref="map" :zoom="19" style="width: 100%; height: 150px">-->
            <!--<gmap-marker-->
            <!--ref="marker"-->
            <!--:position="{lat:props.item.y,lng:props.item.x}"-->

            <!--&gt;-->
            <!--</gmap-marker>-->
            <!--</gmap-map>-->
            <!--</v-card-text>-->

            <!--</v-flex>-->
            <!--</v-layout>-->
            <!--</v-container>-->
            <!--</v-card>-->
            <!--</template>-->
        </v-data-table>
    </div>
</template>

<script>


    import AddItem from "./AddItem";
    import EditItem from "./EditItem";

    export default {
        name: 'items',
        components: {AddItem, EditItem},
        data() {
            return {

                item_title: 'کاربر',
                resource_url: 'api/admin/users/',

                //datatable
                totalItems: 0,
                items: [],
                selected: [],
                expand: false,
                loading: true,
                pagination: {},
                headers: [
                    {
                        text: 'نام و نام خانوادگی',
                        align: 'right',
                        value: 'full_name'
                    },
                    {
                        text: 'جنسیت',
                        align: 'right',
                        value: 'gender'
                    },
                    {
                        text: 'ایمیل',
                        align: 'right',
                        dir: 'rtl',
                        value: 'email'
                    },
                    {
                        text: 'زمان عضویت',
                        align: 'right',
                        value: 'created_at'
                    },
                ],


                //loadings
                refresh_items_loading: false,
                delete_item_loading: false,

                //dialogs
                edit_item_dialog: false,
                add_item_dialog: false,
                delete_item_dialog: false,


                //errors
                delete_item_error: '',
                delete_item_error_message: '',


            }
        },
        created() {
            this.getDataFromApi()
                .then(data => {
                    this.items = data.items;
                    this.totalItems = data.total
                })
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
        methods: {
            refreshItems: function () {
                this.refresh_items_loading = true;
                this.getDataFromApi()
                    .then(data => {
                        this.items = data.items;
                        this.totalItems = data.total;
                        this.refresh_items_loading = false;
                        this.selected = [];
                    });

            },
            getDataFromApi: function () {
                this.loading = true;
                return new Promise((resolve, reject) => {
                    const {sortBy, descending, page, rowsPerPage} = this.pagination;

                    axios.get(this.resource_url).then((response) => {


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
            addItem: function () {
                this.add_item_dialog = true;
            },
            updateItem: function () {
                this.edit_item_dialog = true;
            },
            deleteItems: function () {
                this.delete_item_loading = true;
                axios.delete(this.resource_url, {data: {ids: this.selected}})
                    .then(response => {
                        if (response.data.result === false) {
                            this.delete_item_loading = false;
                            this.delete_item_error = true;
                            this.delete_item_error_message = response.data.message ? response.data.message : 'خطای ناشناخته';
                        } else {
                            this.delete_item_loading = false;
                            this.refreshItems();
                            this.selected = [];
                            this.delete_item_dialog = false;
                        }
                    })
                    .catch(response => {
                        this.delete_item_loading = false;
                        this.delete_item_error = true;
                        this.delete_item_error_message = response.message ? response.message : 'خطای ناشناخته';
                    });


            },
            closeAddDialog: function () {
                this.add_item_dialog = false;
            }
        }
    }
</script>

<style>
    .v-datatable__progress {
        display: table-row;
    }

    .v-datatable .v-btn .v-btn__content .v-icon {
        color: #4caf50;
    }

    .v-btn--floating.v-btn--small {
        height: 40px;
        width: 40px;
        border-radius: 500px;
    }

</style>