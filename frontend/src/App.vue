<template>
  <v-app>
    <v-app-bar app>
      <!-- -->
      <div class=" row d-flex align-items-center">
        <div class="col-1" v-if="$route.name.toLowerCase() !== 'home' && $route.name.toLowerCase() !== 'login'">
          <a-icon style="font-size: 25px; cursor: pointer;" type="arrow-left" @click="$router.go(-1)" />
        </div>
        <div class="col-9 mt-4" style="text-align: start">
          <h1 @click="getInitialData">{{ $route.name.toUpperCase() }}</h1>

        </div>
        <div class="col-1" v-if="$route.name.toLowerCase() == 'home'"></div>
        <div class="col-2" style="text-align: end">
          <a-icon type="logout" style="font-size: 25px;" @click="logout" v-if="$session.get('logged_in')"/>
        </div>
      </div>
    </v-app-bar>

    <!-- Sizes your content based upon application components -->
    <v-main>
      <!-- Provides the application the proper gutter -->
      <v-container>
        <!-- If using vue-router -->
        <router-view></router-view>
      </v-container>
    </v-main>

    <v-footer app>
      <!-- -->
    </v-footer>
  </v-app></template
>

<script>
export default {
  name: "App",

  data: () => ({
    //
  }),
  methods: {
    logout(){
      this.$session.destroy();
      window.location.reload();
    },
    getAxios() {
      return this.axios.create({
        headers: {
          "Access-Control-Allow-Origin": "*",
          "Access-Control-Allow-Credentials": "true",
        },
      });
    },
    getInitialData() {
      this.axios.get("http://127.0.0.1:8000/api/posts").then((result) => {
        console.log(result);
      });
    },
  },
};
</script>
