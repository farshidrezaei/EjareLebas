<template>

    <div>
        <v-toolbar class="rounded-0" color="orange darken-2 ">
            <v-btn icon dark @click="closeDialog">
                <v-icon>close</v-icon>
            </v-btn>
            <v-toolbar-title class="text-white">ویرایش {{item_title}}</v-toolbar-title>
            <v-spacer></v-spacer>

            <v-btn fab color="orange darken-3 " @click="edit_item_wait_dialog = true">
                <v-icon>edit</v-icon>
            </v-btn>
            <v-dialog
                    v-model="edit_item_wait_dialog"
                    persistent
                    max-width="290"
            >
                <v-card>
                    <v-card-title class="headline">
                        <v-icon>edit</v-icon>
                        ویرایش
                    </v-card-title>
                    <v-card-text>آیا از ویرایش این {{item_title}} با مشخصات وارد شده، مطمئن هستید؟</v-card-text>
                    <v-card-text class="text-danger" v-if="edit_error">{{edit_error_message}}</v-card-text>
                    <v-card-actions>
                        <v-btn color="info darken-1" small @click="edit_item_wait_dialog = false">انصراف</v-btn>
                        <v-spacer></v-spacer>
                        <v-btn
                                :loading="edit_loading"
                                :disabled="edit_loading"
                                color="orange darken-1"
                                small
                                @click="updateClothing"
                        >
                            ویرایش
                            <span slot="loader">صبر کنید...</span>
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>

        </v-toolbar>
        <v-container fluid grid-list-md>
            <v-layout row wrap>
                <v-flex xs12 md6>
                    <v-card>
                        <v-container>
                            <v-layout row wrap>

                                <!--title-->
                                <v-flex xs12 md6>
                                    <v-text-field
                                            v-model="new_item.title"
                                            label="عنوان"
                                            @keydown="errors.deleteError('title')"
                                            :error="errors.hasError('title')"
                                            :messages="errors.getErrorText('title')"
                                    ></v-text-field>
                                </v-flex>

                                <!--size-->
                                <v-flex xs12 md6>
                                    <v-combobox
                                            v-model="new_item.size"
                                            :items="sizes"
                                            label="اندازه"
                                            @click="errors.deleteError('size')"
                                            :error="errors.hasError('size')"
                                            :messages="errors.getErrorText('size')"
                                    >
                                        <template slot="item" slot-scope="data">
                                            <v-chip
                                                    small
                                                    :key="JSON.stringify(data.item)"
                                                    :selected="data.selected"
                                                    :disabled="data.disabled"
                                                    class="v-chip--select-multi "
                                                    @input="data.parent.selectItem(data.item)"
                                            >
                                                {{ data.item }}
                                            </v-chip>
                                        </template>
                                        <template slot="selection" slot-scope="data">
                                            <v-chip
                                                    small
                                                    :key="JSON.stringify(data.item)"
                                                    :selected="data.selected"
                                                    :disabled="data.disabled"
                                                    class="v-chip--select-multi "
                                                    @input="data.parent.selectItem(data.item)"
                                            >
                                                {{ data.item }}
                                            </v-chip>
                                        </template>
                                    </v-combobox>
                                </v-flex>

                                <v-flex xs12>
                                    <v-textarea
                                            name="description"
                                            v-model="new_item.description"
                                            label="توضیحات"
                                            @keydown="errors.deleteError('description')"
                                            :error="errors.hasError('description')"
                                            :messages="errors.getErrorText('description')"
                                    ></v-textarea>
                                </v-flex>
                            </v-layout>
                        </v-container>
                    </v-card>
                </v-flex>
                <v-flex xs12 md6>
                    <v-card>
                        <v-container>
                            <v-layout row wrap>
                                <v-flex xs12 md4 offset-md1>
                                    <v-text-field
                                            label="هزینه روزانه"
                                            suffix="تومان"
                                            v-model="new_item.daily_price"
                                            @keydown="errors.deleteError('daily_price')"
                                            :error="errors.hasError('daily_price')"
                                            :messages="errors.getErrorText('daily_price')"
                                    ></v-text-field>
                                </v-flex>
                                <!--weekly-->
                                <v-flex xs12 md3 offset-md1>
                                    <v-text-field
                                            label="هزینه هفتگی"
                                            suffix="تومان"
                                            v-model="new_item.weekly_price"
                                            @keydown="errors.deleteError('weekly_price')"
                                            :error="errors.hasError('weekly_price')"
                                            :messages="errors.getErrorText('weekly_price')"
                                    ></v-text-field>
                                </v-flex>
                                <!--monthly-->
                                <v-flex xs12 md3>
                                    <v-text-field
                                            label="هزینه ماهانه"
                                            suffix="تومان"
                                            v-model="new_item.monthly_price"
                                            @keydown="errors.deleteError('monthly_price')"
                                            :error="errors.hasError('monthly_price')"
                                            :messages="errors.getErrorText('monthly_price')"
                                    ></v-text-field>
                                </v-flex>

                                <!--cash-->
                                <v-flex xs12 md6 offset-md1>
                                    <v-text-field
                                            label="وثیقه نقدی"
                                            suffix="تومان"
                                            v-model="new_item.cash_collateral"
                                            @keydown="errors.deleteError('cash_collateral')"
                                            :error="errors.hasError('cash_collateral')"
                                            :messages="errors.getErrorText('cash_collateral')"
                                    ></v-text-field>
                                </v-flex>
                                <!--non-cash-->
                                <v-flex xs12 md5>
                                    <v-select
                                            :items="non_cash_collaterals"
                                            label="وثیقه غیر نقدی"
                                            multiple
                                            attach
                                            v-model="new_item.non_cash_collateral"
                                            @keydown="errors.deleteError('non_cash_collateral')"
                                            :error="errors.hasError('non_cash_collateral')"
                                            :messages="errors.getErrorText('non_cash_collateral')"

                                    >
                                        <template slot="selection" slot-scope="data">
                                            <v-chip
                                                    small
                                                    :key="JSON.stringify(data.item)"
                                                    :selected="data.selected"
                                                    :disabled="data.disabled"
                                                    class="v-chip--select-multi"
                                                    @input="data.parent.selectItem(data.item)"
                                            >
                                                {{ data.item }}
                                            </v-chip>
                                        </template>
                                    </v-select>
                                </v-flex>

                            </v-layout>
                        </v-container>
                    </v-card>
                    <v-card class="mt-2">
                        <v-container>
                            <v-layout row wrap>
                                <v-flex xs12>
                                    <vue-dropzone
                                            ref="myVueDropzone"
                                            id="dropzone"
                                            :options="dropzoneOptions"
                                            :duplicateCheck="true"
                                    >

                                    </vue-dropzone>
                                </v-flex>
                            </v-layout>
                        </v-container>
                    </v-card>
                </v-flex>
            </v-layout>
        </v-container>
    </div>

</template>

<script>


    import vue2Dropzone from 'vue2-dropzone'
    import 'vue2-dropzone/dist/vue2Dropzone.min.css'

    class Errors {
        constructor() {
            this.errors = {};
        }

        hasError(field) {
            return this.errors.hasOwnProperty(field);
        }

        recordErrors(errors) {
            this.errors = errors;
        }

        getErrorText(field) {
            if (this.errors[field]) {
                return this.errors[field][0];
            }
        }

        deleteError(field) {
            if (field) {
                delete this.errors[field];
            }
        }

        hasAnyErrors() {
            return Object.keys(this.errors).length > 0;
        }
    }

    export default {
        name: 'edit-item',
        props: ['item', 'item_title', 'resource_url'],
        components: {
            vueDropzone: vue2Dropzone
        },
        data() {
            return {

                errors: new Errors(),

                edit_item_wait_dialog: false,
                edit_loading: false,
                edit_error: '',
                edit_error_message: '',


                //edit-item
                new_item: {
                    title: '',
                    size: '',
                    description: '',
                    daily_price: '',
                    weekly_price: '',
                    monthly_price: '',
                    cash_collateral: '',
                    non_cash_collateral: [],
                },


                //size
                sizes: [
                    's', 'm', 'l', 'xl', 'xxl', 'xxxl', 'free'
                ],


                non_cash_collaterals: [
                    'کارت ملی',
                    'شناسنامه',
                    'چک',
                ],

                //dropzoneOptions
                dropzoneOptions: {
                    url: '/api/test',
                    thumbnailWidth: 200,
                    editRemoveLinks: true,
                    dictDefaultMessage: "تصاویر را اینجا بکشید یا کلیک کنید."
                }


            }

        },
        methods: {
            closeDialog: function () {
                this.errors=new Errors();
                this.$emit('close-dialog');
            },

            updateClothing: function () {
                this.edit_loading = true;
                axios.put(`${this.resource_url}${this.new_item.id}`, this.new_item)
                    .then(response => {
                        if (response.data.result === false) {
                            this.edit_loading = false;
                            this.edit_error = true;
                            this.errors.recordErrors(response.data.response);

                            this.edit_error_message = response.data.message ? response.data.message : 'خطای ناشناخته';
                            this.closeWaitDialog();
                        } else {
                            this.new_item = {
                                title: '',
                                size: '',
                                description: '',
                                daily_price: '',
                                weekly_price: '',
                                monthly_price: '',
                                cash_collateral: '',
                                non_cash_collateral: [],
                            };

                            this.edit_loading = false;
                            this.edit_item_wait_dialog = false;
                            this.$emit('close-dialog');
                            this.$emit('refresh');
                        }
                    })
                    .catch(response => {
                        this.edit_loading = false;
                        this.edit_error = true;
                        this.errors.recordErrors(response.response);
                        this.edit_error_message = response.message ? response.message : 'خطای ناشناخته';
                        this.closeWaitDialog();
                    });


            },

            closeWaitDialog: function () {
                this.edit_item_wait_dialog = false;
                this.edit_error = false;
                this.edit_error_message = ''
            }
        },
        created() {
            this.new_item = this.item;
        }

    }
</script>

<style scoped>

</style>