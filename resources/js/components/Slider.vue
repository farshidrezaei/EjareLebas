<template>

        <v-carousel>
            <v-carousel-item
                    v-for="(item,i) in items"
                    :key="i"
                    :src="item.src"
                    reverse-transition="fade"
                    transition="fade"

            >
                <v-btn >j</v-btn>
            </v-carousel-item>
        </v-carousel>

</template>
<script>
    export default {
        data () {
            return {
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
        }
    }
</script>
<style >
    #example-custom-transition .fade-enter-active,
    #example-custom-transition .fade-leave-active,
    #example-custom-transition .fade-leave-to {
        transition: 0.3s ease-out;
        position: absolute;
        top: 0;
        left: 0;
    }

    #example-custom-transition .fade-enter,
    #example-custom-transition .fade-leave,
    #example-custom-transition .fade-leave-to {
        opacity: 0;
    }
</style>