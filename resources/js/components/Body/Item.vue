<template>
    <v-card

            color="orange darken-1"
            dark
    >
        <v-img
                height="200"
                position="0 -10em"
                src="http://images.unsplash.com/photo-1484502249930-e1da807099a5?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=1080&fit=max"
        >
            <v-layout wrap>
                <v-flex xs12>
                    <v-progress-linear
                            :active="isUpdating"
                            class="ma-0"
                            color="orange lighten-3"
                            height="4"
                            indeterminate
                    ></v-progress-linear>
                </v-flex>
                <v-flex
                        text-xs-right
                        xs12
                >

                </v-flex>
                <v-layout
                        align-start
                        column
                        justify-end
                        pa-3
                >
                    <h3 class="headline">{{ name }}</h3>
                    <span class="grey--text text--lighten-1">{{ title }}</span>
                </v-layout>
            </v-layout>
        </v-img>
        <v-form>
            <v-container>
                <v-layout wrap>
                    <v-flex xs12>
                        <toggle-button :value="true"
                                       :color="{checked: '#ab4417', unchecked: '#ab6217', disabled: '#CCCCCC'}"
                                       :sync="true"
                                       :labels="{checked: 'مردانه', unchecked: 'زنانه'}"
                                       width="80"
                                       height="20"
                                       fontSize="15"/>
                    </v-flex>
                    <v-flex xs12>
                        <v-text-field
                                v-model="name"
                                :disabled="isUpdating"
                                box
                                color=" lighten-2"
                                label="عنوان"
                        ></v-text-field>
                    </v-flex>
                    <v-flex xs12>
                        <v-autocomplete
                                v-model="friends"
                                :disabled="isUpdating"
                                :items="people"
                                box
                                chips
                                color=" lighten-2"
                                label="چه لباسی میخوایی؟"
                                item-text="name"
                                item-value="name"
                                multiple
                                hide-selected

                        >
                            <template
                                    slot="selection"
                                    slot-scope="data"
                            >
                                <v-chip
                                        :selected="data.selected"
                                        close
                                        class="chip--select-multi"
                                        @input="remove(data.item)"
                                >
                                    <v-avatar>
                                        <img :src="data.item.avatar">
                                    </v-avatar>
                                    {{ data.item.name }}
                                </v-chip>
                            </template>
                            <template
                                    slot="item"
                                    slot-scope="data"
                            >
                                <template v-if="typeof data.item !== 'object'">

                                    <v-list-tile-content v-text="data.item"></v-list-tile-content>
                                </template>
                                <template v-else>
                                    <v-list-tile-avatar>
                                        <img :src="data.item.avatar">
                                    </v-list-tile-avatar>
                                    <v-list-tile-content>
                                        <v-list-tile-title v-html="data.item.name"></v-list-tile-title>
                                        <v-list-tile-sub-title v-html="data.item.group"></v-list-tile-sub-title>
                                    </v-list-tile-content>
                                </template>
                            </template>
                        </v-autocomplete>
                    </v-flex>
                    <v-flex xs12>
                       
                    </v-flex>
                </v-layout>
            </v-container>
        </v-form>
        <v-divider></v-divider>
        <v-card-actions>
            <v-switch
                    v-model="autoUpdate"
                    :disabled="isUpdating"
                    class="mt-0"
                    color="green lighten-2"
                    hide-details
                    label="Auto Update"
            ></v-switch>
            <v-spacer></v-spacer>
            <v-btn
                    :disabled="autoUpdate"
                    :loading="isUpdating"
                    color="blue-grey darken-3"
                    depressed
                    @click="isUpdating = true"
            >
                <v-icon left>mdi-update</v-icon>
                Update Now
            </v-btn>
        </v-card-actions>
    </v-card>
</template>

<script>
    export default {
        data() {
            const srcs = {
                1: 'https://cdn.vuetifyjs.com/images/lists/1.jpg',
                2: 'https://cdn.vuetifyjs.com/images/lists/2.jpg',
                3: 'https://cdn.vuetifyjs.com/images/lists/3.jpg',
                4: 'https://cdn.vuetifyjs.com/images/lists/4.jpg',
                5: 'https://cdn.vuetifyjs.com/images/lists/5.jpg'
            };

            return {
                autoUpdate: true,
                friends: [],
                isUpdating: false,
                name: '',
                people: [

                    {name: 'شلوار', group: '', avatar: srcs[1]},
                    {name: 'پیراهن', group: '', avatar: srcs[2]},
                    {name: 'کفش', group: '', avatar: srcs[3]},
                    {name: 'لباس مجلسی', group: '', avatar: srcs[2]},
                    {name: 'کت شلوار', group: '', avatar: srcs[4]},
                    {name: 'کت تک', group: '', avatar: srcs[5]},
                    {name: 'لباس عروس', group: '', avatar: srcs[1]},
                ],
                title: 'دنبال چی میگردی؟'
            }
        },

        watch: {
            isUpdating(val) {
                if (val) {
                    setTimeout(() => (this.isUpdating = false), 3000)
                }
            }
        },

        methods: {
            remove(item) {
                const index = this.friends.indexOf(item.name)
                if (index >= 0) this.friends.splice(index, 1)
            }
        }
    }
</script>

<style scoped lang="scss">
    .header {
        /*height: 40em;*/
        background-image: url("https://joorpin.ir/images/content/header/jp-header.jpg");
        width: 100%;
        background-size: cover;
    }

    .logo {
        width: 8em;
    }
</style>