<template>
    <v-footer
            id="core-footer"
            absolute
            height="82"
            color="black"
    >
        <div class="footer-items">
      <span
              class="text-white"
              v-for="link in links"
              :key="link.name">
        <a
                :href="link.Link"
                class="white--text footer-links">{{ link.name }}</a>
      </span>
        </div>
        <v-spacer/>
        <span style="direction: rtl;text-align: right;" class="font-weight-light white--text  ">

      {{ (new Date()).getFullYear() }}
        &copy;
      <a href="https://www.t.me/farshid_0935" target="_blank">فرشید رضائی</a>
        , ساخته شده با
      <v-icon color="red" >mdi-heart</v-icon>
    </span>

    </v-footer>
</template>

<script>
    export default {
        data: () => ({
            links: [
                {name: 'داشبورد', Link: '/dashboard'},
                {name: 'لباس ها', Link: '/clothes'},
                {name: 'کاربران', Link: '/users'},
            ]
        })
    }
</script>

<style>
    #core-footer {
        z-index: 0;
    }
</style>
