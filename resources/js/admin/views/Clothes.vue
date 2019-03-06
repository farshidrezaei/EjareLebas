<template>
    <v-container fill-height fluid grid-list-xl class="pt-0">
        <v-layout justify-center wrap>
            <v-flex md12>
                <material-card
                        color="primary"
                        title="لباس ها"
                        text="لیست لباس ها"
                >
                    <items ></items>

                </material-card>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>


    import Items from "./Clothing/Items";



    export default {
        components: {Items},
        data: () => ({}),


    }
</script>
<style>

    .v-toolbar__title {
        color: white !important;
    }

</style>
