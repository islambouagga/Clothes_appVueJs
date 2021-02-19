<template>
    <div class="container">
        <div class="row justify-content-center mt-5">

            <button type="button" class="btn  btn-outline-success" data-toggle="modal" data-target="#command">
                Add Command
            </button>

        </div>
        <div class="row">
            <div class="form-group">
                <label >client name</label>
                <input type="text" name="table_search" @keyup="searchit" v-model="client_name" class="form-control float-right"
                       placeholder="Search">
            </div>
            <div class="form-group">
                <label >date</label>
                <input type="date" name="table_search" @keyup="searchit" v-model="date1" class="form-control float-right"
                       placeholder="Search">
            </div>
            <div class="form-group">
                <label >date 2 </label>
                <input type="date" name="table_search" @keyup="searchit" v-model="date2" class="form-control float-right"
                       placeholder="Search">
            </div>
            <div class="form-group">
                <label >date 3 </label>
                <input type="date" name="table_search" @keyup="searchit" v-model="date3" class="form-control float-right"
                       placeholder="Search">
            </div>
            <div class="form-group">
                <label >date 4 </label>
                <input type="date" name="table_search" @keyup="searchit" v-model="date4" class="form-control float-right"
                       placeholder="Search">
            </div>
            <div class="form-group">
                <label >{{ this.text }} </label>
            <app-switch classes="is-warning" @click.prevent="searchit" v-model="value" checked></app-switch>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"> Comand's List</h3>

                        <div class="card-tools">

                            <div class="input-group input-group-sm" style="width: 150px;">
<!--                                <input type="text" name="table_search" @keyup="searchit" v-model="search" class="form-control float-right"-->
<!--                                       placeholder="Search">-->

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                            <tr>
                                <th>suive number</th>
                                <th>client Name</th>
                                <th>clothe</th>
                                <th>color</th>
                                <th>price</th>
                                <th>isPaid</th>
                                <th>dateToGive</th>
                                <th>comment</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="command in commands.data " :key="command.id">
                                <td>{{ command.id }}</td>
                                <td>{{ command.client_name }}</td>
                                <td>{{ command.clothe_title}}</td>
                                <td>{{ command.color }}</td>
                                <td>{{ command.price }}</td>
                                <td v-show="command.isPaid" >    <span class="badge badge-success">Success</span></td>
                                <td v-show="!command.isPaid" >    <span class="badge badge-danger">not yes </span></td>
                                <td>{{ command.dateToGive }}</td>
                                <td>{{ command.comment }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">

                        <pagination :data="commands" @pagination-change-page="getResults">

                            <span slot="prev-nav">&lt; Previous</span>
                            <span slot="next-nav">Next &gt;</span>
                        </pagination>
                    </div>
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
                                <label>Minimal</label>
                                <select class="form-control select2" style="width: 100%;" v-model="command.clothe_id">
                                    <option v-for="clothe in clothes " :key="clothe.id" name="clothe_id"  :value="clothe.id"  >{{ clothe.title }}</option>
                                </select>
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
import _ from 'lodash';
import Switch from "./Switch";
export default {
    components: {
        'app-switch': Switch
    },
    data() {
        return {
            value: false,
            text: '',
            commands: {},
            clothes :{},
            client_name : '',
            date1 : '',
            date2 : '',
            date3 : '',
            date4 : '',
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
                clothe_id :''
            })
        }
    },
    watch: {
        value(val) {
            this.text = val ? 'ispaid' : 'not yet'
        }
    },
    methods: {
        loadCommand() {
            axios.get('api/command').then(({data}) => (this.commands = data));

        },
        loadClothes(){
            axios.get('api/clothe').then(({data}) => (this.clothes = data.data ));
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
        },
        getResults(page = 1) {
            axios.get('api/command?page=' + page)
                .then(response => {
                    this.commands = response.data;
                });
        },
        searchit : _.debounce(() =>{
            Fire.$emit('searching')
        })

        },
        created() {
            this.loadCommand();
            this.loadClothes();
        Fire.$on('searching',() =>{
            let client_name  =  this.client_name;
            let date1  =  this.date1;
            let date2  =  this.date2;
            let date3  =  this.date3;
            let date4  =  this.date4;
            let ispaid
            if (this.value === true){
                ispaid = 1
            }else {
                ispaid = 0
            }


            axios.get('api/findCommand?q='+client_name+'&a='+date1+'&b='+date2+'&c='+date3+'&d='+date4+'&e='+ispaid)
            .then((data) => {
                this.commands =data.data
            })
            .catch(()=>{

            })
        })
            Fire.$on('AfterCreate' ,() => {
                this.loadCommand();
                this.loadClothes();
            });


        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
