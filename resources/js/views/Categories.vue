<template>
    <main>
    <div class="container-fluid">
      <h1 class="mt-4">Dashboard</h1>
      <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
      </ol>
   
      <div class="card mb-4">
        <div class="card-header">
          <span>
             <i class="fas fa-table mr-1"></i>
             DataTable Example
          </span>
          <button class="btn btn-primary btn-sm ml-auto float-right" @click="showCategory"><span class="fa fa-plus"></span> Category</button>

        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
               <thead>
                <tr>
                  <th>Id</th>
                  <th>Name</th>
                  <th>Image</th>
                  <th>Action</th>
                </tr>
              </thead>
           
              <tbody>
                 
                <tr v-for="(category, index) of categories" :key="index">
                    <th>{{ index+1 }}</th>
                    <th>{{ category.name }}</th>
                    <!-- <th>{{ category.image }}</th> -->
                    <th><img :src="'userImages/'+ category.image" :alt="category.name" style="width:100px; height:100px"></th>
                    <th>
                        <button class="btn btn-primary"><span class="fa fa-show"></span> </button>
                      <button class="btn btn-info" v-on:click="editCategory(category)"><span class="fa fa-edit"></span> </button>
                      <button class="btn btn-danger" v-on:click="deleteCategory(category)"><span class="fa fa-trash"></span></button>
                    </th>
                </tr>
                    
                  
              </tbody>
            </table>
             <div class="text-center" v-show="paginationExist">
                     <button class="btn btn-info" v-on:click="pagination"> <span class="fa fa-arow-down"></span>Load More..</button>
            </div>
          </div>
        </div>

          <b-modal ref="my-modal" hide-footer title="Add Category">
              <div class="d-block ">

               <form v-on:submit.prevent="createCategory">
                      <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" v-model="categoryData.name" class="form-control" id="name" aria-describedby="emailHelp" placeholder="Enter Name">
                        <div class="invalid-feedback" v-if="errors.name" > {{ errors.name[0] }} </div>
                      </div>
                      <div class="form-group">
                        <label for="image">Image</label>

                        <div v-if="categoryData.image.name"> 
                             <img src="" ref="newCategoryImageDisplay" alt="" style="width:100px; height:100px">
                        </div>

                        <input type="file" v-on:change="attachImage" ref="newcategoyimage" class="form-control" id="image" placeholder="image">
                        <div class="invalid-feedback" v-if="errors.image" > {{ errors.image[0] }}  </div>

                      </div>

                      <button type="button" class="btn btn-info" v-on:click="hideCategory">Cancel</button>
                      <button type="submit" class="btn btn-primary float-right"><span class="fa fa-check"></span>Submit</button>
                </form>

              </div>
          
          </b-modal>


             <b-modal ref="edit-my-modal" hide-footer title="Update  Category">
              <div class="d-block ">

               <form v-on:submit.prevent="updateCategory">
                      <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" v-model="editCategoryData.name" class="form-control" id="name" aria-describedby="emailHelp" placeholder="Enter Name">
                        <div class="invalid-feedback" v-if="errors.name" > {{ errors.name[0] }} </div>
                      </div>
                      <div class="form-group">
                        <label for="image">Image</label>

                        <div> 
                             <img :src="'userImages/'+ editCategoryData.image" ref="editCategoryImageDisplay" alt="" style="width:100px; height:100px">
                        </div>

                        <input type="file" v-on:change="editAttachImage" ref="ediCategoyimage" class="form-control" id="image" placeholder="image">
                        <div class="invalid-feedback" v-if="errors.image" > {{ errors.image[0] }}  </div>

                      </div>

                      <button type="button" class="btn btn-info" v-on:click="hideEditCategory">Cancel</button>
                      <button type="submit" class="btn btn-primary float-right"><span class="fa fa-check"></span>Update</button>
                </form>

              </div>
          
          </b-modal>
      </div>
    </div>
  </main>
</template>


<script>
import * as  categoryService from  '../services/categoryService';

export default{
    name: 'category',
    data () {
      return {
        categories:[],
        categoryData: {
          name: '',
          image: ''
        },
        editCategoryData: {},
        paginationExist : false,
        nextpage: 0,
        errors: {}
      }
    },
    mounted() {     // auto call method function(get All category)
         this.getCategoriesAll();
    },
    methods:{
      
          attachImage() {
            // render the image
            this.categoryData.image = this.$refs['newcategoyimage'].files[0];

            let reader = new FileReader();       // read a file as per select 
                                        
            reader.addEventListener('load', function() {
                this.$refs['newCategoryImageDisplay'].src = reader.result;
            }.bind(this), false);
              reader.readAsDataURL(this.categoryData.image);
          },

          hideCategory() {
              this.$refs['my-modal'].hide();
          },

          showCategory() {
              this.$refs['my-modal'].show();
          },

            getCategoriesAll: async function() {     //get data All categories 
                 try{
                       const response = await categoryService.getCategory();
                         console.log(response);
                      
                         this.categories = response.data.data;

                        if(response.data.current_page < response.data.last_page ){  // for pgination
                             this.paginationExist = true;
                             this.nextpage =   response.data.current_page + 1;   // 1+1 = 2
                        }
                        else{
                              this.paginationExist = false;
                        }

                         console.log( this.categories );
                 } catch(error) {
                       console.log('error data');
                       this.flashMessage.error({
                                    title: 'Some errors cooured',
                                    message: 'Oh, you broke my heart!',
                                    time: 5000
                                });
                 }

            },

            createCategory: async function () {       // store form data (Post)
                // submit form 
              let formData = new FormData();  

              formData.append('name', this.categoryData.name);
              formData.append('image', this.categoryData.image);

                    try{
                          const response = await categoryService.createCategory(formData);
                          //  console.log(response);
                           this.categories.unshift(response.data);  // for data unshift without relode get current data
                           this.hideCategory();  // redirect back
                            this.getCategoriesAll();
                           this.categoryData = {name: '', image: ''  };   //CLEAN FORM

                          this.flashMessage.success({                 //Flash Message
                              title: 'Category Add Successfuly',
                              message: 'Hoorah, it is my fist npm package and it works!',
                              time: 5000
                          });
                    }
                    catch (error){
                         console.log(error.response.status);
                         switch (error.response.status) {
                            case 422:
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

          },
          deleteCategory: async function(category) {       //delete data
                
                if( !window.confirm(`Are you want to delete Category "${ category.name }"`))
                {
                    return;
                } 
                try {
                      const response = await categoryService.deleteCategory(category.id);
                      this.categories = this.categories.filter( obj => {
                           return obj.id != category.id;
                      });
                      console.log(response);
                      this.flashMessage.success({                 //Flash Message
                              title: `${ response.data.result }`,
                              time: 5000
                          });

                } catch (error) {
                    
                      this.flashMessage.error({                 //Flash Message
                              title: error.response.data.result,
                              time: 5000
                          });
                }      
          },
          hideEditCategory(){                             // Edit Model hide
                 this.$refs['edit-my-modal'].hide();
          },
          showEditCategory() {                            // Edit Model Show
              this.$refs['edit-my-modal'].show();
          },
           editAttachImage() {
            // render the image
            this.editCategoryData.image = this.$refs['ediCategoyimage'].files[0];

            let reader = new FileReader();       // read a file as per select 
                                        
            reader.addEventListener('load', function() {
                this.$refs['editCategoryImageDisplay'].src = reader.result;
            }.bind(this), false);
              reader.readAsDataURL(this.editCategoryData.image);
          },
          editCategory (category) {
                 this.editCategoryData = {...category };
                 this.showEditCategory();                 // call Edit  Model
          },
          updateCategory: async function(){
            // update event call
              let formData = new FormData();  

              formData.append('name', this.editCategoryData.name);
              formData.append('image', this.editCategoryData.image);
              formData.append('_method','put');

              try {
                       const response = await  categoryService.updateCategory(this.editCategoryData.id, formData);

                        this.categories.map(catgory =>{                       //same time update data on browser
                              if( catgory.id == response.data.data.id){     //match array & response data id
                                          for( let key in response.data.data ){
                                                catgory[key] = response.data.data[key];  
                                          }
                              }
                        }); 
                      this.hideEditCategory();       //hide
                      this.flashMessage.success({                 //Flash Message
                            title: `${ response.data.result }`,
                            time: 5000
                        });

              } catch (error) {
                 this.flashMessage.success({                 //Flash Message
                            title: `${ error.response.data.result }`,
                            time: 5000
                        });
              }
          },
          pagination: async function(){           //pagination
                 try {
                         const response = await categoryService.loadPagination(this.nextpage); // in nextpage id
                         
                        if(response.data.current_page < response.data.last_page ){
                             this.paginationExist = true;
                             this.nextpage =   response.data.current_page + 1;
                        }
                        else{
                              this.paginationExist = false;
                        }
                        
                        response.data.data.forEach(element => {  // for load at a time page next
                                this.categories.push(element);
                        });



                 } catch (error) {
                    this.flashMessage.error({                 //Flash Message
                              title: 'Some error occured during page load',
                              time: 5000
                          });
                 }
          }
    }
}
</script>

