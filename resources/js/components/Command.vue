<template>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Responsive Hover Table</h3>

                        <div class="card-tools">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="text" name="table_search" class="form-control float-right"
                                       placeholder="Search">

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
                            <tr v-for="command in commands " :key="command.id">
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
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            commands: {},
            testtttttt : true,
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
    methods: {
        loadClothes() {
            axios.get('api/command').then(({data}) => (this.commands = data.data));

        },

        getClotheTitle(clothe) {

            // return clothe.title
         this.clothe.get('api/command/'+clothe).then(({data}) => (this.titlecl =  data));

            // axios.get('api/command/'+clothe).then(({data}) => (console.log(data)));
        }

        },
        created() {
            this.loadClothes();
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
