<template>
  <div class="login">
    <br />
    <template>
      <v-card
          :loading="loading"
          class="mx-auto my-12"
          max-width="374"
      >
        <template slot="progress">
          <v-progress-linear
              color="blue"
              height="10"
              indeterminate
          ></v-progress-linear>
        </template>

        <v-img
            height="250"
            src="https://flightstar.com.au//assets/img/admin.png"
        ></v-img>

        <v-card-title>{{ sign_in ? 'Login':'Signup' }}</v-card-title>

        <v-form
            ref="form"
            v-model="valid"
            lazy-validation
            v-if="sign_in"
        >
        <v-card-text >
          <v-row
              align="center"
              class="mx-0"
          >
              <v-text-field
                  v-model="email"
                  :rules="emailRules"
                  label="E-mail"
                  required
              ></v-text-field>
              <v-text-field
                  v-model="password"
                  :rules="passwordRules"
                  label="Password"
                  type="password"
                  required
              ></v-text-field>

          </v-row>
        </v-card-text>
        </v-form>
        <v-form
            ref="form"
            v-model="valid"
            lazy-validation
            v-else
        >
        <v-card-text >
          <v-row
              align="center"
              class="mx-0"
          >
            <v-text-field
                v-model="name"
                :rules="nameRules"
                label="Name"
                required
            ></v-text-field>
            <v-text-field
                v-model="email"
                :rules="emailRules"
                label="E-mail"
                required
            ></v-text-field>
            <v-text-field
                v-model="password"
                :rules="passwordRules"
                label="Password"
                type="password"
                required
            ></v-text-field>

          </v-row>
        </v-card-text>
        </v-form>

        <v-card-actions>
          <v-btn
              color="blue "
              text
              @click="login"
          >
            Submit
          </v-btn>
        </v-card-actions>
        <v-card-actions v-if="sign_in">
          <p>Don't have an account? <span class="link" @click="switchSign">Sign up</span></p>
        </v-card-actions>
        <v-card-actions v-else>
          <p>Already have an account? <span class="link" @click="switchSign">Sign in</span></p>
        </v-card-actions>
      </v-card>
    </template>

  </div>
</template>

<script>

import { mdiAccount, mdiPencil, mdiShareVariant, mdiDelete } from "@mdi/js";
export default {
  name: "Login",
  components: {  },

  data() {
    return {
      valid: true,
      sign_in:true,
      name: '',
      email: '',
      password: '',
      nameRules: [
        v => !!v || 'Name is required',
      ],
      emailRules: [
        v => !!v || 'E-mail is required',
        v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
      ],
      passwordRules: [
        v => !!v || 'Password is required',
      ],
      loading: false,
      icons: {
        mdiAccount,
        mdiPencil,
        mdiShareVariant,
        mdiDelete,
      },
    };
  },
  methods: {
    switchSign(){
      this.sign_in = !this.sign_in;
    },
    login(){

      let validated = this.$refs.form.validate();
      if(validated){
        this.loading = true;
      }
      if(this.sign_in && validated){
      //  sign in
      //  call api if returned user data, set logged_in true, set user in session
        let values = {
        user: {
          email: this.email,
          password:this.password,
        }
      }
        this.axios.post("http://127.0.0.1:8000/api/user/signin", values).then(result=>{
          this.loading = false;
          console.log(result)

           if(result.data.length > 0){
            console.log(result)
            this.$session.set("logged_in", true);
            this.$session.set("user", result.data[0]);
            this.$router.replace("/");
          //  check status and if user obj has data if yes go on
          }else{
            this.$message.error("Wrong email/password");
          }
        })
      }else if(!this.sign_in && validated) {
      //  signup
      //  call api if signup successful, log him in, save the user in session
        let values = {
        user: {
          name: this.name,
          email: this.email,
          password: this.password,
        }
      }
        this.axios.post("http://127.0.0.1:8000/api/user/signup", values).then(result=>{
          this.loading = false;

          if(result.data.email){
            console.log(result)
            this.$session.set("logged_in", true);
            this.$session.set("user", result.data);
            this.$router.replace("/");
            //  check status and if user obj has data if yes go on
          }else if(result.data.message){
            this.$message.error(result.data.message);

          }
        })
        console.log(values);
      }
    },
  },

  mounted: function() {

  },
};
</script>

<style scoped>
.link{
  cursor: pointer;
  color: blue;
  text-decoration: underline;
}
</style>
