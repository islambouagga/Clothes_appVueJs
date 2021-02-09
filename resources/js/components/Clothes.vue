<template>
    <div class="container">
        <div class="row justify-content-center mt-5">

        <button type="button" class="btn  btn-outline-success" data-toggle="modal" data-target="#addNew">
            Add new Clothes Type
        </button>
        </div>
        <div class="row d-flex align-items-stretch mt-3 ">

            <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch" v-for="clothe in clothes"  :key="clothe.id">
                <div class="card" style="width: 18rem;">
                    <button type="button" @click="deleteClothe(clothe.id)" class="btn btn-outline-danger" >
                        <i class="fas fa-trash"></i>
                    </button>
                    <img class="card-img-top zoom"  width="200" height="200" :src="clothePic(clothe)" alt="Card image cap">
                    <div class="card-body  d-flex justify-content-center">
                        <p class="card-title "><strong>  {{clothe.title}}</strong> </p>
                    </div>
                    <button type="button" @click="getClotheId(clothe.id)" class="btn btn-outline-primary" data-toggle="modal" data-target="#command">
                       Do command
                    </button>
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
        <div class="modal fade" id="command" tabindex="-1" role="dialog" aria-labelledby="commandModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="commandeModalLongTitle">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="createCommand()">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Client Name </label>
                            <input v-model="command.client_name" type="text" name="client_name"
                                   class="form-control" :class="{ 'is-invalid': command.errors.has('client_name') }">
                            <has-error :form="command" field="client_name"></has-error>
                        </div>
                        <div class="form-group">
                            <label>Color </label>
                            <input v-model="command.color" type="text" name="color"
                                   class="form-control" :class="{ 'is-invalid': command.errors.has('color') }">
                            <has-error :form="command" field="color"></has-error>
                        </div>
                        <div class="form-group">
                            <label>Price </label>
                            <input v-model="command.price" type="number" name="price"
                                   class="form-control" :class="{ 'is-invalid': command.errors.has('price') }">
                            <has-error :form="command" field="price"></has-error>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input custom-control-input-danger custom-control-input-outline" type="radio" v-model="command.isPaid" value="1" id="customRadio4" name="isPaid" checked>
                                <label for="customRadio4" class="custom-control-label">Paid</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input custom-control-input-danger custom-control-input-outline" type="radio" v-model="command.isPaid" value="0"  id="customRadio5" name="isPaid">
                                <label for="customRadio5" class="custom-control-label">not Paid </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Date  </label>
                            <input v-model="command.dateToGive" type="date" name="dateToGive"
                                   class="form-control" :class="{ 'is-invalid': command.errors.has('dateToGive') }">
                            <has-error :form="command" field="dateToGive"></has-error>
                        </div>
                        <div class="form-group">
                            <label>Comment</label>
                            <textarea v-model="command.comment" name="comment" id="comment"
                                      placeholder="Short comment (Optional)"
                                      class="form-control"
                                      :class="{ 'is-invalid': command.errors.has('comment') }"></textarea>
                            <has-error :form="command" field="comment"></has-error>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
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
                id : '',
                clothes : {},
                clothe : new Form ({
                    title: '',
                    photo: '',
                }),
                command : new Form ({
                    color : '',
                    price : '',
                    dateToGive :'',
                    client_name :'',
                    comment :'',
                    isPaid : '',
                    clothe_id :'',
                })
            }
        },
        methods:{
            loadClothes(){
                axios.get('api/clothe').then(({data}) => (this.clothes = data.data ));
            },
            createClothe(){
                this.$Progress.start()

                this.clothe.post('api/clothe')
                .then(()=>{
                    Fire.$emit('AfterCreate');
                    $('#addNew').modal('hide')
                    Toast.fire({
                        icon: 'success',
                        title: 'Signed in successfully'
                    })
                    this.$Progress.finish()
                })
                .catch(()=>{
                    Toast.fire({
                        icon: 'error',
                        title: 'Please entre Title   '
                    })
                    this.$Progress.fail()
                })




            },
            deleteClothe(clotheid){

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {

                    if (result.value){
                        this.clothe.delete('api/clothe/'+clotheid).then(()=>{
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            )
                            Fire.$emit('AfterCreate');
                        }).catch(()=>{
                            Swal("Failed!", "There was  something wronge", "warning")
                        })
                    }


                })
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
            },
            getClotheId(clotheid){
                this.command.clothe_id = clotheid

            },
            createCommand(){
                this.$Progress.start()
                this.command.post('api/command')
                    .then(()=>{
                        Fire.$emit('AfterCreate');
                        $('#command').modal('hide')
                        Toast.fire({
                            icon: 'success',
                            title: 'Signed in successfully'
                        })
                        this.$Progress.finish()
                    })
                    .catch(()=>{
                        Toast.fire({
                            icon: 'error',
                            title: 'Please entre Title   '
                        })
                        this.$Progress.fail()
                    })
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
