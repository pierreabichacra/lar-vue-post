<template>
  <v-app>
    <v-app-bar app>
      <!-- -->
      <div>
        <h1 @click="getInitialData">My Posts</h1>
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
