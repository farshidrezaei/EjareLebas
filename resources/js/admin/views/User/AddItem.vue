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

                <!--information-->
                <v-flex xs12 md8>
                    <v-card>
                        <v-container>
                            <v-layout row wrap>
                                <v-flex xs12 md2 offset-md1>
                                    <v-container>
                                        <v-layout row wrap>
                                            <!--avatar-->
                                            <v-flex xs12 md12 class="text-xs-center text-sm-center text-md-center text-lg-center">
                                                <p class="mt-4"></p>
                                                <v-avatar @click='pickFile' color="grey" size="150">
                                                    <img :src="avatarUrl" v-if="avatarUrl" alt="avatar"/>
                                                    <div v-if="!avatarUrl">انتخاب</div>
                                                </v-avatar>
                                                <input
                                                        type="file"
                                                        style="display: none"
                                                        ref="avatar"
                                                        accept="image/*"
                                                        @change="onFilePicked"
                                                >
                                            </v-flex>
                                        </v-layout>
                                    </v-container>

                                </v-flex>

                                <v-flex xs12 md9>
                                    <v-container>
                                        <v-layout row wrap>
                                            <!--first_name-->
                                            <v-flex xs12 md5>
                                                <v-text-field
                                                        v-model="new_item.first_name"
                                                        label="نام"
                                                        @keydown="errors.deleteError('first_name')"
                                                        :error="errors.hasError('first_name')"
                                                        :messages="errors.getErrorText('first_name')"
                                                ></v-text-field>
                                            </v-flex>

                                            <!--last_name-->
                                            <v-flex xs12 md5>
                                                <v-text-field
                                                        v-model="new_item.last_name"
                                                        label="نام خانوادگی"
                                                        @keydown="errors.deleteError('last_name')"
                                                        :error="errors.hasError('last_name')"
                                                        :messages="errors.getErrorText('last_name')"
                                                ></v-text-field>
                                            </v-flex>

                                            <!--gender-->
                                            <v-flex xs4 md2>
                                                <v-select
                                                        v-model="new_item.gender"
                                                        :items="genders"
                                                        label="جنسیت"
                                                        @change="errors.deleteError('gender')"
                                                        :error="errors.hasError('gender')"
                                                        :messages="errors.getErrorText('gender')"
                                                        small-chips
                                                >
                                                </v-select>
                                            </v-flex>

                                            <!--national_code-->
                                            <v-flex xs8 md4>
                                                <v-text-field
                                                        v-model="new_item.national_code"
                                                        label="کد ملی"
                                                        @keydown="errors.deleteError('national_code')"
                                                        :error="errors.hasError('national_code')"
                                                        :messages="errors.getErrorText('national_code')"
                                                ></v-text-field>
                                            </v-flex>

                                            <!--mobile-->
                                            <v-flex xs12 md4>
                                                <v-text-field
                                                        v-model="new_item.mobile"
                                                        label="موبایل"
                                                        @keydown="errors.deleteError('mobile')"
                                                        :error="errors.hasError('mobile')"
                                                        :messages="errors.getErrorText('mobile')"
                                                ></v-text-field>
                                            </v-flex>

                                            <!--email-->
                                            <v-flex xs12 md4>
                                                <v-text-field
                                                        v-model="new_item.email"
                                                        label="ایمیل"
                                                        @keydown="errors.deleteError('email')"
                                                        :error="errors.hasError('email')"
                                                        :messages="errors.getErrorText('email')"
                                                ></v-text-field>
                                            </v-flex>

                                            <!--address-->
                                            <v-flex xs12 md12>
                                                <v-textarea
                                                        name="address"
                                                        v-model="new_item.address"
                                                        label="آدرس"
                                                        value=""
                                                        @keydown="errors.deleteError('address')"
                                                        :error="errors.hasError('address')"
                                                        :messages="errors.getErrorText('address')"
                                                ></v-textarea>
                                            </v-flex>

                                            <!--biography-->
                                            <v-flex xs12 md12>
                                                <v-textarea
                                                        name="biography"
                                                        v-model="new_item.biography"
                                                        label="بیوگرافی"
                                                        value=""
                                                        @keydown="errors.deleteError('biography')"
                                                        :error="errors.hasError('biography')"
                                                        :messages="errors.getErrorText('biography')"
                                                ></v-textarea>
                                            </v-flex>
                                        </v-layout>
                                    </v-container>
                                </v-flex>


                            </v-layout>
                        </v-container>
                    </v-card>
                </v-flex>

                <!--password & map-->
                <v-flex xs12 md4>

                    <!--password-->
                    <v-card>
                        <v-container>
                            <v-layout row wrap>

                                <!--password-->
                                <v-flex xs6 md6>
                                    <v-text-field
                                            label="کلمه عبور"
                                            v-model="new_item.password"
                                            @keydown="errors.deleteError('password')"
                                            :error="errors.hasError('password')"
                                            :messages="errors.getErrorText('password')"
                                            type="password"
                                    ></v-text-field>
                                </v-flex>

                                <!--password_confirmation-->
                                <v-flex xs6 md6>
                                    <v-text-field
                                            label="تکرار کلمه عبور"
                                            v-model="new_item.password_confirmation"
                                            @keydown="errors.deleteError('password_confirmation')"
                                            :error="errors.hasError('password_confirmation')"
                                            :messages="errors.getErrorText('password_confirmation')"
                                            type="password"
                                    ></v-text-field>
                                </v-flex>
                            </v-layout>
                        </v-container>
                    </v-card>

                    <!--map-->
                    <v-card class="mt-2">
                        <v-container>
                            <v-layout row wrap>

                                <!--map-->
                                <v-flex xs12 md12>

                                    <v-tooltip left>
                                        <v-btn
                                                icon
                                                fab
                                                slot="activator"
                                                small
                                                color="info"
                                                @click="getLocation"
                                                :disabled="get_location_loading"
                                                :loading="get_location_loading">
                                            <v-icon dark>mdi-target</v-icon>
                                        </v-btn>
                                        <span>محل من روی نقشه</span>
                                    </v-tooltip>

                                    <gmap-map :center="center" ref="map" :zoom="19" style="width: 100%; height: 300px">
                                        <gmap-marker
                                                ref="marker"
                                                v-model="marker_position"
                                                :position="marker_position"
                                                :clickable="true"
                                                :draggable="true"
                                                @click="center=marker_position"
                                                @dragend="markerDragEnd"

                                        >
                                        </gmap-marker>
                                    </gmap-map>
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
        props: ['item_title', 'resource_url'],
        data() {
            return {


                center: {
                    lat: 51.39069282159426,
                    lng: 35.68695934981364
                },
                marker_position: {
                    lat: 51.39069282159426,
                    lng: 35.68695934981364
                },
                get_location_loading: false,


                errors: new Errors(),

                add_item_wait_dialog: false,
                add_loading: false,
                add_error: '',
                add_error_message: '',


                //add-item
                new_item: {
                    first_name: '',
                    last_name: '',
                    gender: '',
                    national_code: '',
                    mobile: '',
                    email: '',
                    address: '',
                    biography: '',
                    password: '',
                    password_confirmation: '',
                    roles: [],
                    x: '',
                    y: '',
                    avatar: ''
                },


                //gender
                genders: [
                    {text: 'مرد', value: 'male'},
                    {text: 'زن', value: 'female'},
                ],


                //avatar
                avatar_dialog: false,
                avatarName: '',
                avatarUrl: '',
                avatarFile: ''

            }

        },
        methods: {

            //map
            markerDragEnd() {
                let location = {
                    x: this.$refs.marker.$markerObject.position.lng(),
                    y: this.$refs.marker.$markerObject.position.lat()
                };
                this.$refs.map.$mapPromise.then((map) => {
                    map.panTo({lat: location.y, lng: location.x})
                });

                this.new_item.x = location.x;
                this.new_item.y = location.y;

                this.marker_position = {
                    lat: location.y, lng: location.x
                };
            },
            getLocation() {
                if (navigator.geolocation) {
                    this.get_location_loading = true;
                    navigator.geolocation.getCurrentPosition(function (position) {
                        this.get_location_loading = false;
                        this.setMarker(position);
                    }.bind(this));
                } else {
                    console.log("این ویژگی در مرورگر شما فعال نیست");
                    this.get_location_loading = false;
                }
            },
            setMarker(position) {
                let location = {
                    x: position.coords.longitude,
                    y: position.coords.latitude
                };
                this.$refs.map.$mapPromise.then((map) => {
                    map.panTo({lat: location.y, lng: location.x});
                });

                this.new_item.x = location.x;
                this.new_item.y = location.y;

                this.marker_position = {
                    lat: location.y, lng: location.x
                };

            },

            //avatar
            pickFile() {
                this.$refs.avatar.click();
                this.avatar_dialog = true;
            },


            onFilePicked(e) {
                const files = e.target.files;
                if (files[0] !== undefined) {
                    this.avatarName = files[0].name;
                    if (this.avatarName.lastIndexOf('.') <= 0) return;
                    const fr = new FileReader();
                    fr.readAsDataURL(files[0]);

                    fr.addEventListener('load', () => {
                        this.avatarUrl = fr.result;
                        this.avatarFile = files[0];

                    });

                    let form_data = new FormData();
                    form_data.append('avatar', files[0]);
                    let headers = {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${window.Auth.token()}`
                    };
                    axios.post('api/admin/avatar-upload', form_data,{headers:headers})
                        .then(response => {
                            this.new_item.avatar = response.data.response;
                        })
                        .catch(response => {
                            console.log(response.message);
                        });

                } else {
                    this.avatarName = '';
                    this.avatarFile = '';
                    this.avatarUrl = '';
                }
            },


            //dialogs
            closeDialog: function () {

                this.new_item = {
                    avatar: '',
                    x: '',
                    y: '',
                    first_name: '',
                    last_name: '',
                    gender: '',
                    national_code: '',
                    mobile: '',
                    email: '',
                    address: '',
                    biography: '',
                    password: '',
                    password_confirmation: '',
                    roles: []

                };
                this.avatarName = '';
                this.avatarFile = '';
                this.avatarUrl = '';
                this.$refs.avatar.value = '';
                this.errors = new Errors();
                this.$emit('close-dialog');
            },

            saveItem: function () {
                this.add_loading = true;
                let headers = {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${window.Auth.token()}`
                };
                axios.post(this.resource_url, this.new_item,{headers:headers})
                    .then(response => {
                        if (response.data.result === false) {
                            this.add_loading = false;
                            this.add_error = true;
                            this.errors.recordErrors(response.data.response);
                            this.add_error_message = response.data.message ? response.data.message : 'خطای ناشناخته';
                            this.closeWaitDialog();
                        } else {
                            this.new_item = {
                                avatar: '',
                                x: '',
                                y: '',
                                first_name: '',
                                last_name: '',
                                gender: '',
                                national_code: '',
                                mobile: '',
                                email: '',
                                address: '',
                                biography: '',
                                password: '',
                                password_confirmation: '',
                                roles: []

                            };
                            this.avatarName = '';
                            this.avatarFile = '';
                            this.avatarUrl = '';
                            this.$refs.avatar.value = '';
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

                    });


            },

            closeWaitDialog: function () {
                this.add_item_wait_dialog = false;
                this.add_error = false;
                this.add_error_message = ''
            }
        },

    }
</script>

<style scoped>

</style>