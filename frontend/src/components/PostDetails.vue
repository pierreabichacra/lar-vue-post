<template>
  <div class="preview" v-if="post">
    <div class="row d-flex align-items-center">
      <div class="col-8">
        <h2>{{ post.title }}</h2>

      </div>
      <div class="col-4" style="text-align: end">
        <h4>- {{post.name || 'Mysterious being'}}</h4>
      </div>
    </div>
    <hr>
    <p :style="`${read_more ? '':'text-overflow: ellipsis;white-space: nowrap;overflow: hidden;'}`">{{ post.content }}</p>
    <div class="row">
      <div style="text-align: end" class="col-12">
        <v-btn
            color="blue "
            text
            v-if="!read_more"
            @click="read_more = true"
        >
          Read More
        </v-btn>

        <v-btn
            v-if="read_more"
            color="blue "
            text
            @click="read_more = false"
        >
          Hide
        </v-btn>
      </div>
    </div>
  </div>
</template>

<script>

export default {
  name: "Details",
  data() {
    return {
      read_more: false,
      post: null,
    };
  },
  methods: {
  },
  created: function(){
    if(this.$route.params.post){
      this.post = this.$route.params.post;
      this.$session.set("backup", this.post);
    }else {
      this.post = this.$session.get("backup");
    }
  }
};
</script>

<style>
</style>
