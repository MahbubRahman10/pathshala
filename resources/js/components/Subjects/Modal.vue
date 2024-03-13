<template>
	<div>

		<div class="modal" v-bind:class="activeaddmodal">
			<div class="modal-background"></div>
			<div class="modal-card">
				<header class="modal-card-head">
					<p class="modal-card-title">Add New Subject</p>
					<button class="delete" aria-label="close" v-on:click="deadd"></button>
				</header>
				<section class="modal-card-body">
					<!-- Content ... -->
					<form @submit.prevent="">
						<div :class="{ 'has-error': errors.has('subjectname') }">
							<label class="control-label" for="subjectname">Subject Name : </label><br>
							<input v-validate="'required'" v-model="subjectname" type="text" name="subjectname" class="input">
							<span v-show="errors.has('subjectname')">{{ errors.first('subjectname') }}</span>         
						</div>
						<br>
						<div :class="{ 'has-error': errors.has('class') }" id="role">
							<label class="control-label" for="class">Class </label><br>
							<div class="select is-fullwidth">
								<select @change="" v-model="classid" >
									<option v-for="(vclass,index) in classes" :value="vclass.id"> {{ vclass.ClassName }} </option>
								</select>
							<span v-show="errors.has('class')">{{ errors.first('class') }}</span> 
							</div>
						</div>
						<br>
						<div :class="{ 'has-error': errors.has('teacher') }" id="role">
							<label class="control-label" for="teacher">Teacher </label><br>
							<div class="select is-fullwidth">
								<select @change="" v-model="teacherid" >
									<option v-for="(teacher,index) in teachers" :value="teacher.id"> {{ teacher.Username }} - {{ teacher.FirstName }} {{ teacher.LastName }} </option>
								</select>
							<span v-show="errors.has('pupils')">{{ errors.first('pupils') }}</span> 
							</div>
						</div>
						<br>
						
						<br>
					</form>
				</section>
				<footer class="modal-card-foot">					
					<button type="submit" class="button is-success" v-on:click="addsubject">Submit</button>
					<button class="button" v-on:click="deadd">Cancel</button>
				</footer>
			</div>
		</div>

		<div class="modal"  v-bind:class="activeeditmodal">
			<div class="modal-background"></div>
			<div class="modal-card">
				<header class="modal-card-head">
					<p class="modal-card-title">Update User</p>
					<button class="delete" aria-label="close" v-on:click="deedit"></button>
				</header>
				<section class="modal-card-body">
					<!-- Content ... -->
					<form @submit.prevent="">
						
						<div :class="{ 'has-error': errors.has('subjectname') }">
							<label class="control-label" for="subjectname">Subject Name : </label><br>
							<input v-validate="'required'" v-model="subjectname" type="text" name="subjectname" class="input">
							<span v-show="errors.has('subjectname')">{{ errors.first('subjectname') }}</span>         
						</div>
						<br>
						<div :class="{ 'has-error': errors.has('class') }" id="role">
							<label class="control-label" for="class">Class </label><br>
							<div class="select is-fullwidth">
								<select @change="" v-model="classid" >
									<option v-for="(vclass,index) in classes"  v-bind:value="vclass.id"> {{ vclass.ClassName }} </option>
								</select>
								<span v-show="errors.has('class')">{{ errors.first('class') }}</span> 
							</div>
						</div>
						<br>
						<div :class="{ 'has-error': errors.has('teacher') }" id="role">
							<label class="control-label" for="teacher">Teacher </label><br>
							<div class="select is-fullwidth">
								<select @change="" v-model="teacherid" >
									<option v-for="(teacher,index) in teachers" :value="teacher.id"> {{ teacher.Username }} - {{ teacher.FirstName }} {{ teacher.LastName }} </option>
								</select>
								<span v-show="errors.has('pupils')">{{ errors.first('pupils') }}</span> 
							</div>
						</div>

						<br>
						<br>
					</form>
				</section>
				<footer class="modal-card-foot">
					<button class="button is-success" v-on:click="edituser">Save changes</button>
					<button class="button" v-on:click="deedit">Cancel</button>
				</footer>
			</div>
		</div>

		<div class="modal"  v-bind:class="activedeletemodal">
			<div class="modal-background"></div>
			<div class="modal-card">
				<header class="modal-card-head">
					<p class="modal-card-title">Delete Subject</p>
					<button class="delete" aria-label="close" v-on:click="dedelete"></button>
				</header>
				<section class="modal-card-body">
					<!-- Content ... -->
					<p>Are you want to delete this subject ?</p>
				</section>
				<footer class="modal-card-foot">
					<button type="submit" class="button is-danger" v-on:click="deletesubject">Delete</button>
					<button class="button" v-on:click="dedelete">Cancel</button>
				</footer>
			</div>
		</div>

		<div class="modal"  v-bind:class="activearchivemodal">
			<div class="modal-background"></div>
			<div class="modal-card">
				<header class="modal-card-head">
					<p class="modal-card-title">Arcive Subject</p>
					<button class="delete" aria-label="close" v-on:click="dearchive" ></button>
				</header>
				<section class="modal-card-body">
					<!-- Content ... -->
					<p>Are you want to archive this subject ?</p>
				</section>
				<footer class="modal-card-foot">
					<button type="submit" class="button is-primary" v-on:click="archivesubject">Archive</button>
					<button class="button" v-on:click="dearchive">Cancel</button>
				</footer>
			</div>
		</div>

	</div>
</template>

<script>
	
	
	export default{
		components: {
        
    	},
		data(){
			return{

				activeaddmodal: '',
				activeeditmodal: '',
				activeviewmodal: '',
				activedeletemodal: '',
				activearchivemodal: '',

				subjectid : '',
				subjectname : '',

				cname : '',
				tname : '',

                teacherid : '',
                classid:'',

                teachers: '',
                classes: ''

			}
		},
		methods:{
			add:function(){
				this.activeaddmodal = 'is-active'
				this.getallclass()
				this.getallteacher()
			},
			deadd:function(){
				this.activeaddmodal = ''
				this.subjectname = ''
				this.teacherid = ''
				this.classid = ''
				this.$validator.reset()
				this.errors.clear()
			},
			getallclass() {
				var vm = this
				axios({
					method: 'get',
					url: 'http://localhost:8000/api/class/pupils',
					accept: 'json',
					ContentType: 'json',
					Authorization: 'Bearer' + this.$cookie.get('token')
				}).then(response => { 
					if(response.data != null){
						this.classes = response.data.data
					}
				})
				.catch( error  => {

				});				
			},
			getallteacher() {
				var vm = this
				axios({
					method: 'get',
					url: 'http://localhost:8000/api/teachers',
					accept: 'json',
					ContentType: 'json',
					Authorization: 'Bearer' + this.$cookie.get('token')
				}).then(response => { 
					if(response.data != null){
						this.teachers = response.data.data
					}
				})
				.catch( error  => {

				});				
			},
			addsubject() {
				var vm = this
				this.$validator.validateAll().then((result) => {
					if (result) {
						axios({
							method: 'post',
							url: 'http://localhost:8000/api/subjects',
							accept: 'json',
							ContentType: 'json',
							Authorization: 'Bearer' + this.$cookie.get('token'),
							data: {
								subjectname: vm.subjectname,
								user_id: vm.teacherid,
								class_id: vm.classid
							}
						}).then(response => { 
							vm.activeaddmodal = ''
							this.deadd()
							this.$emit('add-subject');
						})
						.catch( error  => {
							
						});
					}
				});
			},
			edit:function(index,items){
				this.subjectid = items.id
				this.subjectname  = items.subjectname
				this.classid  = items.class_id
				this.teacherid  = items.user_id
				this.getallclass()
				this.getallteacher()
				this.activeeditmodal = 'is-active'
			},
			deedit:function(){
				this.userid = ''
				this.subjectname = ''
				this.teacherid = ''
				this.$validator.reset()
				this.errors.clear()
				this.activeeditmodal = ''
			},
			edituser() {
				var vm = this
				
				this.$validator.validateAll().then((result) => {
					axios({
						method: 'put',
						url: 'http://localhost:8000/api/subjects/'+ this.subjectid,
						accept: 'json',
						ContentType: 'json',
						Authorization: 'Bearer' + this.$cookie.get('token'),
						data: {
							subjectname: vm.subjectname,
							class_id: vm.classid,
							user_id: vm.teacherid
						}
					}).then(response => { 
						vm.activeeditmodal = ''
						this.$emit('edit-subject');
					})
					.catch( error  => {

					});
				
				});
			},
			delete:function(index,id){
				this.activedeletemodal = 'is-active'
				this.subjectid = id
				this.index  = index
			},
			dedelete:function(){
				this.activedeletemodal = ''
			},
			deletesubject() {
				var vm = this
				axios({
					method: 'delete',
					url: 'http://localhost:8000/api/subjects/'+ this.subjectid,
					accept: 'json',
					ContentType: 'json',
					Authorization: 'Bearer' + this.$cookie.get('token'),
				}).then(response => { 
					if (response.status == 201) {
						vm.activedeletemodal = ''
						this.$emit('remove-subject');
					} else {
						vm.activedeletemodal = ''
						this.$emit('error-subject');
					}
				})
				.catch( error  => {

				});
			},
			archive:function(index,items){
				this.subjectid = items.id
				this.activearchivemodal = 'is-active'
			},
			dearchive:function(){
				this.activearchivemodal = ''
			},
			archivesubject() {
				var vm = this
				axios({
					method: 'post',
					url: 'http://localhost:8000/api/archives',
					accept: 'json',
					ContentType: 'json',
					Authorization: 'Bearer' + this.$cookie.get('token'),
					data: {
						subject_id: vm.subjectid
					}
				}).then(response => { 
					vm.activearchivemodal = ''
					if (response.status == 201) {
						this.$emit('archive-subject');
					}
				})
				.catch( error  => {
					vm.activearchivemodal = ''
					this.$emit('error-archive');
				});
			}

		},
		mounted(){

		}

	}

</script>

<style scoped="">
	

form span{
        padding: 3px 5px;
        color: #d9534f!important;
}
.has-error input{
        border-color: #d9534f!important;
}
.has-error textarea{
        border-color: #d9534f!important;
}

.modal-card-body span{
	margin-left: 10px;
}




</style>