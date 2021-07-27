<template>
  <div v-if="posts">
    <br />
    <div v-for="post in posts" :key="post.id" class="row card_custom pointer">
      <div class="col-8">
        <h4>{{ post.title }}</h4>
        <p>{{ post.content }}</p>
      </div>
      <div class="col-4 align-end">
        <v-btn color="red" depressed>
          <v-icon left @click="deletePost(post.id)">
            {{ icons.mdiDelete }}
          </v-icon>
        </v-btn>
        <p>
          <edit-button
            :title="post.title"
            :content="post.content"
            :id="post.id"
          />
        </p>
      </div>
    </div>
    <add-post :added="addPost($event)" />
  </div>
</template>

<script>
import AddPost from "../components/AddPost.vue";
import EditButton from "../components/EditPost.vue";
import { mdiAccount, mdiPencil, mdiShareVariant, mdiDelete } from "@mdi/js";
export default {
  name: "Home",
  components: { AddPost, EditButton },

  data() {
    return {
      icons: {
        mdiAccount,
        mdiPencil,
        mdiShareVariant,
        mdiDelete,
      },
      posts: null,
      editTtitle: "",
      editContent: "",
    };
  },
  methods: {
    addPost(item) {
      if (!this.posts) {
        this.posts = [];
        this.posts.push(item);
      } else {
        this.posts.push(item);
      }
    },
    getAllData() {
      console.log("get All dat ainitiated");
      this.axios.get("http://127.0.0.1:8000/api/posts").then((result) => {
        this.posts = result.data;
      });
    },
    deletePost(id) {
      this.axios
        .delete(`http://127.0.0.1:8000/api/post/${id}/${-1}`)
        .then((result) => {
          this.getAllData();
          console.log(result);
        });
    },
  },

  mounted: function() {
    this.getAllData();
  },
};
</script>

<style scoped>
.align-end {
  text-align: end;
}
.card_custom {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  transition: 0.3s;
  width: 100%;
  padding: 10px;

  margin-bottom: 35px;
}

.card_custom:hover {
  box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
}

.pointer {
  cursor: pointer;
}
</style>
