<template>
    <div class="header">
        <v-container grid-list-md text-xs-center>
            <v-layout row wrap>
                <v-flex xs12 mt-3>
                    <img src="https://joorpin.ir/images/content/jp-orange-logo.svg" alt="" class="logo">
                </v-flex>
                <v-flex xs12 mt-1>
                    <search></search>
                </v-flex>
            </v-layout>
        </v-container>
    </div>
</template>

<script>
    import Search from './Search';

    export default {
        name: "Header",
        components: {Search}
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