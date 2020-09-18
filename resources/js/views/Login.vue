<template>
<div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div>
                                    <div class="card-body">
                                        <form v-on:submit.prevent="login">
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputEmailAddress">Email</label>
                                                <input class="form-control py-4" v-model="user.email" id="inputEmailAddress" type="email" placeholder="Enter email address" />
                                                   <div class="invalid-feedback" v-if="errors.email" > {{ errors.email[0] }} </div>

                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputPassword">Password</label>
                                                <input class="form-control py-4"  v-model="user.password" id="inputPassword" type="password" placeholder="Enter password" />
                                                   <div class="invalid-feedback" v-if="errors.password" > {{ errors.password[0] }} </div>

                                            </div>
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" v-model="user.remember_me" id="rememberPasswordCheck" type="checkbox" />
                                                    <label class="custom-control-label"  for="rememberPasswordCheck">Remember password</label>
                                                </div>
                                            </div>
                                            <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <router-link class="small" to="forgot">Forgot Password?</router-link>
                                                <button class="btn btn-primary" type="submit">Login</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center">
                                        <div class="small"><router-link to="/register">Need an account? Sign up!</router-link></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
</div>
</template>
<script>
import * as auth from '../services/auth_services';

export default {
    name:'Login',
    data() {
      return {
          user: {
              email:'',
              password: '',
              remember_me: ''
          },
          errors:{}
      }
    },
    created(){
        document.querySelector('body').style.background ="#495057b0";
    },
    methods:{
        login: async function() {
            try {
                
                 const response =  await auth.login(this.user);
                 this.errors = {};
                 this.$router.push('/');
                
            } catch (error) {
                 switch (error.response.status) {
                    case 422:
                        this.errors = error.response.data.errors;
                    break;
                     case 401:
                       
                         this.flashMessage.error({
                            title:  error.response.data.message,
                            time: 5000
                        });
                    break;
                    case 500:
                        this.errors = error.response.data.message;
                    break;
                    default: 
                        this.flashMessage.error({
                            title: 'Some errors cooured',
                            message: 'Oh, you broke my heart! Shame on you!',
                            time: 5000
                        });
                        // alert( 'some errors cooured');
                    break;
                    }  
            }
        }
    }
}
</script>