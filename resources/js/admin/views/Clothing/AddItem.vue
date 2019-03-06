<template>

    <div>
        <v-toolbar class="rounded-0" color="success darken-2 ">
            <v-btn icon dark @click="closeDialog">
                <v-icon>close</v-icon>
            </v-btn>
            <v-toolbar-title class="text-white">افزودن {{item_title}} جدید</v-toolbar-title>
            <v-spacer></v-spacer>

            <v-btn fab color="success darken " @click="add_item_wait_dialog = true">
                <v-icon>save</v-icon>
            </v-btn>
            <v-dialog
                    v-model="add_item_wait_dialog"
                    persistent
                    max-width="290"
            >
                <v-card>
                    <v-card-title class="headline">
                        <v-icon>save</v-icon>
                        افزودن
                    </v-card-title>
                    <v-card-text>آیا از افزودن {{item_title}} جدید با مشخصات وارد شده، مطمئن هستید؟</v-card-text>
                    <v-card-text class="text-danger" v-if="add_error">{{add_error_message}}</v-card-text>
                    <v-card-actions>
                        <v-btn color="info darken-1" small @click="closeWaitDialog">انصراف</v-btn>
                        <v-spacer></v-spacer>
                        <v-btn
                                :loading="add_loading"
                                :disabled="add_loading"
                                color="success darken-1"
                                small
                                @click="saveItem"
                        >
                            افزودن
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
                                            value=""
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
        name: 'add-item',
        components: {
            vueDropzone: vue2Dropzone
        },
        props: ['item_title', 'resource_url'],
        data() {
            return {

                errors: new Errors(),

                add_item_wait_dialog: false,
                add_loading: false,
                add_error: '',
                add_error_message: '',


                //add-item
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
                    addRemoveLinks: true,
                    dictDefaultMessage: "تصاویر را اینجا بکشید یا کلیک کنید."
                }


            }

        },
        methods:
            {
                closeDialog: function () {

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
                    this.errors=new Errors();
                    this.$emit('close-dialog');
                },

                saveItem: function () {
                    this.add_loading = true;
                    axios.post(this.resource_url, this.new_item)
                        .then(response => {
                            if (response.data.result === false) {
                                this.add_loading = false;
                                this.add_error = true;
                                this.errors.recordErrors(response.data.response);
                                this.add_error_message = response.data.message ? response.data.message : 'خطای ناشناخته';
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

                                this.add_loading = false;
                                this.add_item_wait_dialog = false;
                                this.$emit('close-dialog');
                                this.$emit('refresh');
                            }
                        })
                        .catch(response => {
                            this.add_loading = false;
                            this.add_error = true;
                            this.errors.recordErrors(response.response);
                            this.add_error_message = response.message ? response.message : 'خطای ناشناخته';
                            this.closeWaitDialog();
                        });


                },

                closeWaitDialog: function () {
                    this.add_item_wait_dialog = false;
                    this.add_error = false;
                    this.add_error_message = ''
                }
            }
        ,

    }
</script>

<style scoped>

</style>