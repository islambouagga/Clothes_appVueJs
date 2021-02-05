<template>
    <div class="container">
        <div class="row justify-content-center mt-5">

        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addNew">
            Add new Clothes Type
        </button>
        </div>
        <div class="row d-flex align-items-stretch mt-3 ">

            <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch" v-for="clothe in clothes"  :key="clothe.id">
                <div class="card" style="width: 18rem;">

                    <img class="card-img-top" :src="clothePic(clothe)" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">{{clothe.title}}</h5>
                    </div>
                    <div class="card-body">
                        <a href="#" class="btn btn-primary ">Go somewhere</a>
                    </div>
                </div>
            </div>
            </div>
        <!-- Modal -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="createClothe">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Clothe Title </label>
                            <input v-model="clothe.title" type="text" name="title"
                                   class="form-control" :class="{ 'is-invalid': clothe.errors.has('title') }">
                            <has-error :form="clothe" field="title"></has-error>
                        </div>

                        <div class="form-group  ">
                            <label>Clothe Pic</label>

                                <input type="file" @change="uplodepic" name="photo" class="form-control" id="photo">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                photoclo : '',
                clothes : {},
                clothe : new Form ({
                    title: '',
                    photo: '',
                })
            }
        },
        methods:{
            loadClothes(){
                axios.get('api/clothe').then(({data}) => (this.clothes = data ));
            },
            createClothe(){
                this.$Progress.start()
                Fire.$emit('AfterCreate');
                this.clothe.post('api/clothe');
                Toast.fire({
                    icon: 'success',
                    title: 'Signed in successfully'
                })

                $('#addNew').modal('hide')

                this.$Progress.finish()
            },
            uplodepic(e){
                let file =  e.target.files[0];
                let reader = new FileReader();
                if(file['size'] < 2111775){
                    reader.onloadend =  (file) => {
                        // console.log('result ',reader.result)
                        this.clothe.photo = reader.result;
                    }
                    reader.readAsDataURL(file);
                }
                else{
                }

            },
            clothePic(clothe){
              let photo =  "img/clothes_pics/"+ clothe.photo ;
              this.photoclo = photo;
                return photo;
            }
        },
        created(){
          this.loadClothes();
          Fire.$on('AfterCreate' ,() => {
              this.loadClothes();
          });
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
