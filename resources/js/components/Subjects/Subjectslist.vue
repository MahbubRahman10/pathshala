<template>
    <div>
        <Header></Header>
        <Modal ref="modal" v-on:add-subject="afteraddsubject" v-on:edit-subject="aftereditsubject" v-on:remove-subject="afterremovesubject" v-on:error-subject="aftererrorsubject" v-on:error-archive="aftererrorarchive" v-on:archive-subject="afterarchivesubject"></Modal>
        <div class="main-contents">

            <article v-if="errornotify" class="message is-danger">
                <div class="message-header">
                    <p>{{errormsg}}</p>
                </div>
            </article>

            <article v-if="notify" class="message is-primary">
                <div class="message-header">
                    <p>Subject {{msg}} Successfuly</p>
                </div>
            </article>
              <article v-if="anotify" class="message is-info">
                <div class="message-header">
                    <p>{{msg}}</p>
                </div>
            </article>

            <p class="utitle">All Subject</p>
            <div class="field has-addons">
               <!--  <div class="control">
                    <input class="input" type="text" placeholder="Find Subject" v-model="searchsubject" @keyup="searchsubject()">
                </div> -->
                <div v-on:click="addsubject" class="is-right" style="float:right;">
                    <router-link to=""  class="create" ><i class="fa fa-plus" aria-hidden="true"></i>Add New Subject</router-link>
                </div>
            </div>
            <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                <tr>
                    <th scope="col">Subject Code</th>
                    <th scope="col">Subject Name</th>
                    <th scope="col">Class</th>
                    <th scope="col">Teacher</th>
                    <th>Action</th>
                    <th>Action</th>
                </tr>
                <tr v-if="subjects.data == ''">      
                    <td class="nodata" colspan='6' v-if="nodata"><p>No Subject Available</p></td>
                </tr>
                <tr v-if="loadings">
                    <td class="nodata" colspan='6'>
                        <div class="loading">
                            <p> <img src="https://jerickson.net/img/loading%20icon.png"></p>
                        </div> 
                    </td>
                </tr>
                <tr v-else v-for="(subject,index) in subjects.data">
                  
                    <td>{{subject.subjectcode }}</td>
                    <td> {{subject.subjectname }} </td>
                    <td>{{subject.classname }}</td> 
                    <td>{{subject.username }}</td>
                     <td>
                        <a v-if="subject.subjectstatus == false" v-on:click="archivesubject(index)" class="button is-info" ><i class="fa fa-archive"></i> Arcive</a>
                        <a v-else class="button is-info is-light""><i class="fa fa-archive"></i> </i>Already Arcived</a>
                    </td> 
                    <td  v-if="subject.subjectstatus == false">
                        <a v-on:click="editsubject(index)" class="icon is-size-5 has-text-info"><i class="fa fa-edit" aria-hidden="true"></i></a>
                        <a class="icon is-size-5 has-text-danger" v-on:click="deletesubject(index)"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                    </td>             
                </tr>
            </table>
            <p> 
                <pagination :data="subjects" @pagination-change-page="getallsubject">>
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
    import Modal from './Modal.vue'

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
                errornotify : false,
                anotify : false,
                errormsg: '', 
                nodata : false,
                subjects : {},
                searchsubject : '',
                loadings : false
            }
        },
        methods:{
            getallsubject:function(page){
                var vm = this
                if (typeof page === 'undefined') {
                    page = 1;
                }
                axios({
                    method: 'get',
                    url: 'http://localhost:8000/api/subjects?page=' + page,
                    accept: 'json',
                    ContentType: 'json',
                    Authorization: 'Bearer' + this.$cookie.get('token')
                }).then(response => {  
                    if(response.data != null){
                        this.subjects = response.data
                        vm.loadings = false
                    }
                    else{
                        this.nodata = true
                    }
                })
                .catch( error  => {
                
                });
            },

            // add methods for add new subject
            addsubject:function(){
                var child = this.$refs.modal;
                var click = child.add();
            },
            afteraddsubject:function() {
                this.notify = true;
                this.getallsubject() 
                this.msg = 'created'
                var sel = this
                setTimeout(function() { sel.notify = false }, 5000)
            },
            editsubject:function(index){
                var child = this.$refs.modal;
                var click = child.edit(index,this.subjects.data[index]);
            },
            archivesubject:function(index){
                var child = this.$refs.modal;
                var click = child.archive(index,this.subjects.data[index]);
            },
            aftereditsubject:function() {
                this.notify = true;
                this.getallsubject() 
                this.msg = 'updated'
                var sel = this
                setTimeout(function() { sel.notify = false }, 5000)
            },
            deletesubject:function(index){
                var child = this.$refs.modal;
                var click = child.delete(index,this.subjects.data[index].id);
            },
            afterremovesubject:function(index) {
                this.notify = true;
                this.getallsubject() 
                this.msg = 'Removed'
                var sel = this
                setTimeout(function() { sel.notify = false }, 5000)
            },
            aftererrorsubject:function(index) {
                this.errornotify = true;
                this.errormsg = 'This Subject Can not be removed'
                var sel = this
                setTimeout(function() { sel.notify = false }, 5000)
            },
            afterarchivesubject:function() {
                this.anotify = true;
                this.getallsubject() 
                this.msg = 'Subject added to archive Successfuly'
                var sel = this
                setTimeout(function() { sel.notify = false }, 5000)
            },
             aftererrorarchive:function(index) {
                this.errornotify = true;
                this.errormsg = '´This Subject Can not be Arcived'
                var sel = this
                setTimeout(function() { sel.notify = false }, 5000)
            },
           
           
        },
        mounted(){
            this.$refs.topProgress.start()
            var vm = this
            vm.loadings = true             
            setTimeout(() => {
                vm.loading = true,
                vm.$refs.topProgress.done()
            }, 500)
            this.getallsubject() 

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
    background: #4a477a;
    font-family: Arial, Helvetica, sans-serif;
    padding: 5px;
    text-align: center;
    font-weight: bold;
    font-size: 20px;
    margin-bottom: 20px;
    color: white;
    box-shadow: 0 10px 6px -6px #777;
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
    background: #31b57c;
    margin:5px 15px;
}
.is-right {
    margin-top: 5px;
}
.create i{
    padding: 6px 5px;
    
}
a.button.is-info {
    border-radius: 0;
}
i.fa.fa-archive {
    padding: 5px;
    margin-top: 5px;
}
a.button.is-info.is-light {
    font-weight: bold;
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
