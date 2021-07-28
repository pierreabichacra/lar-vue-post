<template>
  <div v-if="posts">
    <br />
    <div v-for="(post, index) in posts" :key="index" >
      <div class="row d-flex align-items-center card_custom pointer">
        <div class="col-10">
          <h4>{{ post ? post.title : 'oops something bad happened' }}</h4>
          <p style="text-overflow: ellipsis;white-space: nowrap;overflow: hidden;">{{ post ? post.content : 'oops something bad happened' }}</p>
        </div>
        <div class="col-2 align-end">
          <div class="row">
            <div class="col-3"></div>
            <div class="col-3">
              <a-icon type="eye" style="font-size: 25px;" class="shadow-custom" @click="showPost(post)"/>
            </div>
            <div class="col-3">
              <a-icon style="font-size: 25px; color: red;" class="shadow-custom" type="delete" @click="deletePost(post.id)"/>

            </div>
            <div class="col-3">
              <edit-button
                  :title="post.title"
                  :content="post.content"
                  :id="post.id"
                  @getData="getAllData"
              />
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <p>- {{post.name || 'Mysterious being'}}</p>
            </div>
          </div>
        </div>
      </div>


    </div>
    <add-post @added="addPost()" />
  </div>
</template>

<script>
import AddPost from "../components/AddPost.vue";
import EditButton from "../components/EditPost.vue";
export default {
  name: "Home",
  components: { AddPost, EditButton },

  data() {
    return {
      posts: [],
      editTtitle: "",
      editContent: "",
    };
  },
  methods: {
    showPost(post){
      this.$router.push({name: "Details", params: {post: post}}).catch(()=>{});
    },
    addPost() {
      this.getAllData()
    },
    getAllData() {
      console.log("get All dat ainitiated");
      this.axios.get("http://127.0.0.1:8000/api/posts").then((result) => {
        console.log(result)
        this.posts = [];
        this.posts  = result.data;
      });
    },
    deletePost(id) {
      let self = this;
      this.$confirm({
        title: 'Delete Post',
        content: 'You are about to delete this post. Are you sure you want to continue?',
        okText: 'DELETE',
        okType: 'danger',
        cancelText: 'CANCEL',
        onOk() {
          self.axios
              .delete(`http://127.0.0.1:8000/api/post/${id}/${self.$session.get('user').id}`)
              .then((result) => {
                if(result.data.message){
                  self.$message.error(result.data.message)
                }
                self.getAllData();
                console.log(result);
              });
        },
        onCancel() {
          console.log('Cancel');
        },
      });


    },
    checkLogin(){
      let logged_in = this.$session.get('logged_in')
    if(!logged_in){
      this.$session.start()
      this.$router.push({ name: 'Login' }).catch(()=>{})
    }
    }
  },

  mounted: function() {
    this.checkLogin();
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
.shadow-custom:hover{
  -webkit-filter: drop-shadow( 3px 3px 2px rgba(0, 0, 0, .7));
  filter: drop-shadow( 3px 3px 2px rgba(0, 0, 0, .7));

}

.pointer {
  cursor: pointer;
}
</style>
