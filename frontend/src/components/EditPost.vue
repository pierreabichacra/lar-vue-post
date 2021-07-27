<template>
  <div class="add">
    <div class="button">
      <button @click="editPostVisible = !editPostVisible">edit</button>
    </div>
    <a-modal v-model="editPostVisible" title="Edit Post" :footer="null">
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
                initialValue: title,

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
                initialValue: content,

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
  name: "EditButton",
  props: {
    title: {
      type: String,
      required: true,
    },
    content: {
      type: String,
      required: true,
    },
    id: {
      required: true,
    },
  },

  data() {
    return {
      formLayout: "horizontal",
      form: this.$form.createForm(this, { name: "coordinated" }),

      editPostVisible: false,
    };
  },
  methods: {
    handleAddPost(e) {
      e.preventDefault();
      this.form.validateFields((err, values) => {
        if (!err) {
          values.author_id = -1;
          this.axios
            .put(`http://127.0.0.1:8000/api/post/${this.id}`, {
              post: values,
            })
            .then((result) => {
              console.log(result);
              this.editPostVisible = false;
              this.$emit("getData");
            });
          console.log("Received values of form: ", values);
        }
      });
    },
  },
};
</script>
