<template>
    <div>
        <Header></Header>
       
        <div class="main-contents">

       
            <p class="utitle">My Subject(s)</p>
            <div class="field has-addons">

            </div>
            <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                <tr>
                    <th scope="col">Subject Name</th>
                    <th scope="col">Average Grade</th>
                    <th>Action</th>
                </tr>
                <tr v-if="subjects.data == ''">      
                    <td class="nodata" colspan='3' v-if="nodata"><p>No Subject Available</p></td>
                </tr>
                <tr v-if="loadings">
                    <td class="nodata" colspan='3'>
                        <div class="loading">
                            <p> <img src="https://jerickson.net/img/loading%20icon.png"></p>
                        </div> 
                    </td>
                </tr>
                <tr v-else v-for="(subject,index) in subjects.data">
                  
                    <td>{{subject.subjectname }}</td>
                    <td> {{subject.grade }} </td>
                     <td>
                        <router-link v-bind:to="'/pupils/tests/' + subject.id"  class="button is-info" ></i>View <i class="fa fa-angle-double-right"></i> </router-link>
                    </td>            
                </tr>
            </table>
            <p> 
                <pagination :data="subjects" @pagination-change-page="getsubjects">>
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


    export default{
        components:{
            'Header' : Header,
            'Footer' : Footer,
            vueTopprogress
        },
        data(){
            return{
                nodata : false,
                subjects : {},
                loadings : false
            }
        },
        methods:{
            getsubjects:function(page){
                if (typeof page === 'undefined') {
                    page = 1;
                }
                var vm = this
                axios({
                    method: 'get',
                    url: 'http://localhost:8000/api/pupils?page=' + page,
                    accept: 'json',
                    ContentType: 'json',
                    Authorization: 'Bearer' + this.$cookie.get('token')
                }).then(response => {  
                    this.subjects = response.data
                    vm.loadings = false
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
            this.getsubjects() 

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

   border: solid 1px #555;
   background-color: #eed;
   box-shadow: 12px 0 15px -4px rgba(31, 73, 125, 0.8), -12px 0 8px -4px rgba(31, 73, 125, 0.8);
   -moz-box-shadow: 12px 0 15px -4px rgba(31, 73, 125, 0.8), -12px 0 8px -4px rgba(31, 73, 125, 0.8);
   -webkit-box-shadow: 12px 0 15px -4px rgba(31, 73, 125, 0.8), -12px 0 8px -4px rgba(31, 73, 125, 0.8);
   -o-box-shadow: 12px 0 15px -4px rgba(31, 73, 125, 0.8), -12px 0 8px -4px rgba(31, 73, 125, 0.8);
}
.columns{
    width:100% ;
    padding:10px 10px;
}
.utitle {
    background: #4b4b6b;
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
    background: blue;
    margin:5px 15px;
}
.is-right {
    margin-top: 5px;
}
.create i{
    padding: 6px 5px;
    
}

i.fa.fa-angle-double-right {
    margin-top: 5px;
    margin-left: 5px;
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
