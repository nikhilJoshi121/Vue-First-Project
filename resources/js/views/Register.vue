<template>
     <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-7">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Create Account</h3></div>
                                    <div class="card-body">
                                        <form v-on:submit.prevent="register">
                                            <div class="form-row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="inputFirstName">Full name</label>
                                                        <input class="form-control py-4" v-model="user.name" id="inputFirstName" type="text" placeholder="Enter Full name" />
                                                        <div class="invalid-feedback" v-if="errors.name" > {{ errors.name[0] }} </div>
                                                    </div>
                                                </div>
                                              
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputEmailAddress">Email</label>
                                                <input class="form-control py-4" v-model="user.email" id="inputEmailAddress" type="email" aria-describedby="emailHelp" placeholder="Enter email address" />
                                                   <div class="invalid-feedback" v-if="errors.email" > {{ errors.email[0] }} </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="inputPassword">Password</label>
                                                        <input class="form-control py-4" v-model="user.password" id="inputPassword" type="password" placeholder="Enter password" />
                                                       <div class="invalid-feedback" v-if="errors.password" > {{ errors.password[0] }} </div>
                                                        
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="inputConfirmPassword">Confirm Password</label>
                                                        <input class="form-control py-4" v-model="user.password_confirmation" id="inputConfirmPassword" type="password" placeholder="Confirm password" />
                                                       <div class="invalid-feedback" v-if="errors.password_confirmation" > {{ errors.password_confirmation[0] }} </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mt-4 mb-0"><button class="btn btn-primary btn-block" type="submit">Create Account</button></div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center">
                                        <div class="small"><router-link to="/login">Have an account? Go to login</router-link></div>
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
    name:'register',
    created(){
        document.querySelector('body').style.background ="#495057b0";
    },
     data() {
       return {
                user:{
                    name:'',
                    email:'',
                    password:'',
                    password_confirmation: ''
                },
                errors: {}
            }  
    },
    methods: {
        register : async function() {
           try {
               await auth.register(this.user);
               this.errors = {};
               this.$router.push('/login');
           } catch (error) {
               
                switch (error.response.status) {
                            case 422:
                                this.errors = error.response.data.errors;
                            break;
                            case 500:
                                this.errors = error.response.data.errors;
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