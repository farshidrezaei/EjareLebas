<template>
  <div class="">
    <v-content class="pt-0">
      <div id="core-view">
        <v-fade-transition mode="out-in">
          <router-view />
        </v-fade-transition>
      </div>
    </v-content>
    <core-footer v-if="$route.name !== 'Maps'" />
  </div>
</template>

<script>
export default {
  metaInfo () {
    return {
      title: 'اجاره لباس'
    }
  }
}
</script>

<style>
#core-view {
  padding-bottom: 100px;
}
</style>
