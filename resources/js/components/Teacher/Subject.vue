<template>
    <div>
        <Header></Header>
       
        <div class="main-contents">

            <article v-if="notify" class="message is-primary">
                <div class="message-header">
                    <p> {{msg}} </p>
                </div>
            </article>
           

            <p class="utitle">All Test of {{ subject }} Subject</p>
            <div class="field has-addons">
            
                <div class="is-right" style="float:right;">
                    <router-link v-bind:to="'/teacher/addtest/' + subjectid"  class="create" ><i class="fa fa-plus" aria-hidden="true"></i>Add New Test</router-link>

                     <router-link v-bind:to="'/teacher/testresult/' + subjectid"  class="res" > {{ subject }} Result <i class="fa fa-angle-double-right"></i></router-link>

                </div>
            </div>
            <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                <tr>
                    <th scope="col">Test Code</th>
                    <th scope="col">Test Name</th>
                    <th scope="col">Test Date</th>
                    <th scope="col">Created</th>
                    <th>Action</th>
                </tr>
                <tr v-if="tests.data == ''">      
                    <td class="nodata" colspan='5' v-if="nodata"><p>No Test Available</p></td>
                </tr>
                <tr v-if="loadings">
                    <td class="nodata" colspan='5'>
                        <div class="loading">
                            <p> <img src="https://jerickson.net/img/loading%20icon.png"></p>
                        </div> 
                    </td>
                </tr>
                <tr v-else v-for="(test,index) in tests.data">
                  
                    <td>{{test.testcode }}</td>
                    <td> {{test.name }} </td>
                    <td> {{test.date | moment("DD MMMM, YYYY")  }} </td>
                    <td>{{test.created_at | moment("DD-mM-YYYY")  }} </td> 
                     <td>
                        <router-link v-bind:to="'/teacher/test/' + test.id"  class="button is-link" ></i>View</router-link>
                        <router-link v-bind:to="'/teacher/edittest/' + test.id" class="button is-warning">Edit</router-link>
                        <a  v-on:click="deletetest(test.id)" class="button is-danger">Delete</a>
                    </td>            
                </tr>
            </table>
            <p> 
                <pagination :data="tests" @pagination-change-page="getalltest">>
                    <span slot="prev-nav">&lt; Previous</span>
                    <span slot="next-nav">Next &gt;</span>
                </pagination>
            </p>

            <div class="modal"  v-bind:class="activedeletemodal">
                <div class="modal-background"></div>
                <div class="modal-card">
                    <header class="modal-card-head">
                        <p class="modal-card-title">Remove Test</p>
                        <button class="delete" aria-label="close" v-on:click="dedelete"></button>
                    </header>
                    <section class="modal-card-body">
                        <!-- Content ... -->
                        <p>Are you want to remove this test ?</p>
                    </section>
                    <footer class="modal-card-foot">
                        <button type="submit" class="button is-danger" v-on:click="testdelete">Delete</button>
                        <button class="button" v-on:click="dedelete">Cancel</button>
                    </footer>
                </div>
            </div>

        </div>
        <Footer></Footer>
        <vue-topprogress ref="topProgress"></vue-topprogress>
    </div>
</template>
<script>
    import Header from './../sections/header.vue'
    import Footer from './../sections/footer.vue'
    import { vueTopprogress } from 'vue-top-progress'


    export default{
        components:{
            'Header' : Header,
            'Footer' : Footer,
            vueTopprogress
        },
        data(){
            return{
                activedeletemodal: '',
                notify : false,
                errornotify : false,
                anotify : false,
                msg: '', 
                nodata : false,
                tests : {},
                testid : '',

                subject: '',
                subjectid :  this.$route.params.id,
                loadings : false
            }
        },
        methods:{
            getsubject:function(value){
                var vm = this
                axios({
                    method: 'get',
                    url: 'http://localhost:8000/api/subjects/' + vm.subjectid,
                    accept: 'json',
                    ContentType: 'json',
                    Authorization: 'Bearer' + this.$cookie.get('token')
                }).then(response => {  
                    this.subject = response.data.data.SubjectName
                })
                .catch( error  => {
                
                });
            },
            getalltest:function(page){
                var vm = this
                if (typeof page === 'undefined') {
                    page = 1;
                }
                var vm = this
                axios({
                    method: 'get',
                    url: 'http://localhost:8000/api/teacher/subjects/' + vm.subjectid+ '/?page=' + page,
                    accept: 'json',
                    ContentType: 'json',
                    Authorization: 'Bearer' + this.$cookie.get('token')
                }).then(response => {  
                    if(response.data != null){
                        this.tests = response.data
                        vm.loadings = false
                    }
                    else{
                        this.nodata = true
                    }
                })
                .catch( error  => {
                
                });
            },
            deletetest:function(id){
                var vm = this
                vm.testid = id
                this.activedeletemodal = 'is-active'

            },
            dedelete:function(){
                this.activedeletemodal = ''
            },
            testdelete() {
                var vm = this
                axios({
                    method: 'delete',
                    url: 'http://localhost:8000/api/tests/'+ this.testid,
                    accept: 'json',
                    ContentType: 'json',
                }).then(response => { 
                    this.getalltest() 
                    this.notify = true
                    vm.activedeletemodal = ''
                    this.msg = 'Test Deleted Successfuly'
                    setTimeout(function() { vm.notify = false }, 5000)
                    this.$cookie.delete('message');
                })
                .catch( error  => {

                });
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
            this.getsubject()
            this.getalltest() 

           if (this.$cookie.get('message') != null) {
            this.notify = true
            this.msg = this.$cookie.get('message')
            setTimeout(function() { vm.notify = false }, 5000)
            this.$cookie.delete('message');
        }

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
    background: #387a8a;
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
    background: #3ed0a4;
    margin:5px 15px;
}

.res{
    padding: 7px 8px;
    color: white;
    border-radius: 3px;
    font-size:18px;
    font-weight:bold;
    border-color: white;
    background: #3eaed0;
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
