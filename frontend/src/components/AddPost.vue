<template>
  <div class="add">
    <div class="button align-end">
      <v-btn
        class="mx-2 floating-button"
        fab
        dark
        color="green"
        @click="addPostVisible = !addPostVisible"
      >
        <v-icon dark>
          mdi-plus
        </v-icon>
      </v-btn>
    </div>
    <a-modal v-model="addPostVisible" title="Add Post" :footer="null">
      <a-form
        :form="form"
        :label-col="{ span: 5 }"
        :wrapper-col="{ span: 12 }"
        @submit="handleAddPost"
      >
        <a-form-item label="Title">
          <a-input
            v-decorator="[
              'title',
              {
                rules: [{ required: true, message: 'Please input a title!' }],
              },
            ]"
          />
        </a-form-item>
        <a-form-item label="Content">
          <a-input
            v-decorator="[
              'content',
              {
                rules: [
                  { required: true, message: 'Please write your content!' },
                ],
              },
            ]"
          />
        </a-form-item>
        <a-form-item :wrapper-col="{ span: 12, offset: 5 }">
          <a-button type="primary" html-type="submit">
            Submit
          </a-button>
        </a-form-item>
      </a-form>
    </a-modal>
  </div>
</template>

<script>
export default {
  name: "AddButton",

  data() {
    return {
      formLayout: "horizontal",
      form: this.$form.createForm(this, { name: "coordinated" }),

      addPostVisible: false,
    };
  },
  methods: {
    handleAddPost(e) {
      e.preventDefault();
      this.form.validateFields((err, values) => {
        if (!err) {
          values.author_id = -1;
          this.axios
            .post(`http://127.0.0.1:8000/api/post/store`, {
              post: values,
            })
            .then((result) => {
              console.log(result);
              this.addPostVisible = false;
              this.$emit("added", result.data);
            });
          console.log("Received values of form: ", values);
        }
      });
    },
  },
};
</script>

<style scoped>
.floating-button {
  position: fixed;
  top: 100px;
  right: 50px;
}
.align-end {
  text-align: end;
}
</style>
