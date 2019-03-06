<template>
    <v-container fill-height fluid grid-list-xl>
        <v-layout justify-center wrap>
            <v-flex md12>
                <material-card
                        color="primary"
                        title="کاربر ها"
                        text="لیست کاربر ها"
                >
                    <items></items>

                </material-card>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>


    import Items from "./User/Items";


    export default {
        components: { Items},
        data: () => ({

        }),


    }
</script>
<style>

    .v-toolbar__title {
        color: white !important;
    }

</style>
