<template>
    <div>
        <Header></Header>
        <Modal ref="modal" v-on:add-grade="afteraddgrade" v-on:edit-grade="aftereditgrade"  v-on:upload-grade="afteruploadgrade"></Modal>
         <div class="main-contents">

            <article v-if="notify" class="message is-primary">
                <div class="message-header">
                    <p>{{msg}}</p>
                </div>
            </article>

            <p class="utitle"> {{testname}} Test Grade</p>
            <div class="field has-addons">
               <div v-on:click="addgrade" class="is-right" style="float:right;">
                <router-link to=""  class="create" ><i class="fa fa-plus" aria-hidden="true"></i>Add Grade</router-link>
            </div>
             <div v-on:click="uploadgrade" class="is-right" style="float:right;">
                <router-link to=""  class="createres" ><i class="fa fa-file" aria-hidden="true"></i> Upload Grade</router-link>
            </div>
            </div>
            <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                <tr>

                    <th scope="col">Pupils Username</th>
                    <th scope="col">Pupils Name</th>
                    <th scope="col">Grade</th>
                    <th>Action</th>
                </tr>
                <tr v-if="grades.data == ''">      
                    <td class="nodata" colspan='4' v-if="nodata"><p>No Grade Available</p></td>
                </tr>
                <tr v-if="loadings">
                    <td class="nodata" colspan='4'>
                        <div class="loading">
                            <p> <img src="https://jerickson.net/img/loading%20icon.png"></p>
                        </div> 
                    </td>
                </tr>
                <tr v-else v-for="(grade,index) in grades.data">
                  
                    <td> {{grade.username }} </td>
                    <td> {{grade.firstname }} {{grade.lastname }} </td>
                    <td> {{grade.grade }} </td> 
                    <td>
                      <a v-on:click="editgrade(index)" class="icon is-size-5 has-text-info"><i class="fa fa-edit" aria-hidden="true"></i></a>
                    </td>             
                </tr>
            </table>
            <p> 
                <pagination :data="grades" @pagination-change-page="getgrades">>
                    <span slot="prev-nav">&lt; Previous</span>
                    <span slot="next-nav">Next &gt;</span>
                </pagination>
            </p>
        </div>
        <Footer></Footer>
        <vue-topprogress ref="topProgress"></vue-topprogress>
    </div>
</template>
<script>
    import Header from './../sections/header.vue'
    import Footer from './../sections/footer.vue'
    import { vueTopprogress } from 'vue-top-progress'
    import Modal from './GradeModal.vue'

    export default{
        components:{
            'Header' : Header,
            'Footer' : Footer,
            vueTopprogress,
            'Modal' : Modal 
        },
        data(){
            return{
                notify : false, 
                nodata : false,
                msg: '',

                testid :  this.$route.params.id,
                testname : '',
                grades : {},
                loadings : false
            }
        },
        methods:{
            gettest:function(value) {
                axios({
                    method: 'get',
                    url: 'http://localhost:8000/api/tests/' + this.testid,
                    accept: 'json',
                    ContentType: 'json',
                    Authorization: 'Bearer' + this.$cookie.get('token')
                }).then(response => {                  
                    this.testname = response.data.data.TestName
                })
                .catch( error  => {

                });
            },
            getgrades:function(page){
                var vm = this
                if (typeof page === 'undefined') {
                    page = 1;
                }
                axios({
                    method: 'get',
                    url: 'http://localhost:8000/api/grades/' + this.testid+ '/?page=' + page,
                    accept: 'json',
                    ContentType: 'json',
                    Authorization: 'Bearer' + this.$cookie.get('token')
                }).then(response => {  
                    if(response.data != null){
                        this.grades = response.data
                        vm.loadings = false
                    }
                    else{
                        this.nodata = true
                    }
                })
                .catch( error  => {
                
                });
            },
            uploadgrade:function(){
                var child = this.$refs.modal;
                var click = child.upload(this.testid);
            },
            afteruploadgrade:function() {
                this.notify = true;
                this.getgrades() 
                this.msg = 'New Grade Added Successfuly'
                var sel = this
                setTimeout(function() { sel.notify = false }, 5000)
            },
            addgrade:function(){
                var child = this.$refs.modal;
                var click = child.add(this.testid);
            },
            afteraddgrade:function() {
                this.notify = true;
                this.getgrades() 
                this.msg = 'New Grade Added Successfuly'
                var sel = this
                setTimeout(function() { sel.notify = false }, 5000)
            },
            editgrade:function(index){
                var child = this.$refs.modal;
                var click = child.edit(index,this.grades.data[index]);
            },
            aftereditgrade:function() {
                this.notify = true;
                this.getgrades() 
                this.msg = 'Grade Updated Successfuly'
                var sel = this
                setTimeout(function() { sel.notify = false }, 5000)
            }        
        },
        mounted(){
            this.$refs.topProgress.start()
            var vm = this
            vm.loadings = true            
            setTimeout(() => {
                vm.loading = true,
                vm.$refs.topProgress.done()
            }, 500)
            this.gettest() 
            this.getgrades() 

        }
    }
</script>

<style scoped>
span.error {
  color: #9F3A38;
}
#activeerror{
    background: #9F3A38;
    color: white;
    font-size: 15px;
    font-weight: bold;
    padding: 10px;
    border-radius: 5px;
    margin-bottom: 20px;
}
.main-contents{
   margin-top: 0;
   margin: 5% 20% 10% 20%;
   padding: 10;
   padding: 20px 20px;
}
.columns{
    width:100% ;
    padding:10px 10px;
}
.utitle {
    background: #306e53;
    font-family: Arial, Helvetica, sans-serif;
    padding: 5px;
    text-align: center;
    font-weight: bold;
    font-size: 20px;
    margin-bottom: 20px;
    color: white;
    box-shadow: 2px 2px #888888;
}

/* notifications after CRUD */
.notifications{
    text-align: center;
    margin-top: 10px;
    margin-left:10%;
}
.notifications span{
    background: #5f5f5f;
    color: #ffffff;
    font-size: 17px;
    border: 1px solid #cccccc;
    font-family: Verdana,sans-serif;
    padding: 5px 14px 10px 10px;
    overflow: visible;
    border-radius: 6px;
}
.nodata p{
    text-align: center;
    font-size: 20px;
    padding: 5px;
}

table{
    border: 1px solid #ddd
}

table thead th{
    border: 1px solid #ddd
}
table td{
    border: 1px solid #ddd;
}
table tr{
    border: 1px solid #ddd
}

.table.is-narrow td, .table.is-narrow th {
   padding: 0.7em 0.7em; 
}
.create{
    padding: 7px 8px;
    color: white;
    border-radius: 3px;
    font-size:18px;
    font-weight:bold;
    border-color: white;
    background: #456e80;
    margin:5px 15px;
}
.createres{
    padding: 7px 8px;
    color: white;
    border-radius: 3px;
    font-size:18px;
    font-weight:bold;
    border-color: white;
    background: #069c8f;
    margin:5px 15px;
}
.is-right {
    margin-top: 5px;
}
.create i{
    padding: 6px 5px;
    
}


.pagination, .pagination-list{
    align-items: center;
    display: flex;
    justify-content: center;
    text-align: center;
}

.pagination {
    display: inline-flex;
    padding-left: 0;
    list-style: none;
    font-size: 1rem;
    margin: -.25rem;
}
.pagination, .pagination-list {
    align-items: center;
    display: flex;
    justify-content: center;
    text-align: center;
}
.page-item.active .page-link {
    z-index: 3;
    color: #fff;
    background-color: #0d6efd;
    border-color: #0d6efd;
}
.page-item:first-child .page-link {
    border-top-left-radius: .25rem;
    border-bottom-left-radius: .25rem;
}

.page-link {
    padding: .375rem .75rem;
}
.page-link {
    position: relative;
    display: block;
    color: #0d6efd;
    text-decoration: none;
    background-color: #fff;
    border: 1px solid #dee2e6;
    transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
}
.page-item:last-child .page-link {
    border-top-right-radius: .25rem;
    border-bottom-right-radius: .25rem;
}


li.page-item.pagination-page-nav{
    z-index: 3;
    color: #fff;
    background-color: #0d6efd;
    border-color: #0d6efd;
}
.page-link:hover {
    z-index: 2;
    color: #0a58ca;
    background-color: #e9ecef;
    border-color: #dee2e6;
}
</style>
