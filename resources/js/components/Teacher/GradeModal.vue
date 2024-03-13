<template>
	<div>

		<div class="modal" v-bind:class="activeaddmodal">
			<div class="modal-background"></div>
			<div class="modal-card">
				<header class="modal-card-head">
					<p class="modal-card-title">Add Grade</p>
					<button class="delete" aria-label="close" v-on:click="deadd"></button>
				</header>
				<section class="modal-card-body">
					<!-- Content ... -->
					<form @submit.prevent="">
						<article v-if="notify" class="message is-danger">
							<div class="message-header">
								<p>{{msg}}</p>
							</div>
						</article>
						<div :class="{ 'has-error': errors.has('username') }">
							<label class="control-label" for="username">Pupils Username : </label><br>
							<input v-validate="'required'" v-model="username" type="text" name="username" class="input">
							<span v-show="errors.has('username')">{{ errors.first('username') }}</span>       
						</div>
						<br>
						<div :class="{ 'has-error': errors.has('grade') }">
							<label class="control-label" for="grade">Grade : </label><br>
							<input v-validate="'required'" v-model="grade" type="text" name="grade" class="input">
							<span v-show="errors.has('grade')">{{ errors.first('grade') }}</span>       
						</div>
						<br>
						<br>
					</form>
				</section>
				<footer class="modal-card-foot">					
					<button type="submit" class="button is-success" v-on:click="addgrade">Submit</button>
					<button class="button" v-on:click="deadd">Cancel</button>
				</footer>
			</div>
		</div>

		<div class="modal" v-bind:class="activeuploadmodal">
			<div class="modal-background"></div>
			<div class="modal-card">
				<header class="modal-card-head">
					<p class="modal-card-title">Upload Grade(s)</p>
					<button class="delete" aria-label="close" v-on:click="deupload"></button>
				</header>
				<section class="modal-card-body">
					<!-- Content ... -->
					<form @submit.prevent="">
						<article v-if="notify" class="message is-danger">
							<div class="message-header">
								<p>{{msg}}</p>
							</div>
						</article>
						<label class="control-label" for="question4">Import File : </label><br>
						<input v-validate="'required'" type="file" name="file" id="file" @change="onFileChange" class="input" accept="file/*">
						<br>
						<br>
					</form>
				</section>
				<footer class="modal-card-foot">					
					<button type="submit" class="button is-success" v-on:click="uploadgrade">Submit</button>
					<button class="button" v-on:click="deupload">Cancel</button>
				</footer>
			</div>
		</div>

		<div class="modal"  v-bind:class="activeeditmodal">
			<div class="modal-background"></div>
			<div class="modal-card">
				<header class="modal-card-head">
					<p class="modal-card-title">Update Grade</p>
					<button class="delete" aria-label="close" v-on:click="deedit"></button>
				</header>
				<section class="modal-card-body">
					<!-- Content ... -->
					<form @submit.prevent="">
						<div :class="{ 'has-error': errors.has('username') }">
							<label class="control-label" for="username">Username : </label><br>
							<input disabled="" v-validate="'required'" v-model="username" type="text" name="username" class="input">
							<span v-show="errors.has('username')">{{ errors.first('username') }}</span>         
						</div>
						<br>
						<div :class="{ 'has-error': errors.has('name') }">
							<label class="control-label" for="name">Name : </label><br>
							<input disabled="" v-validate="'required'" v-model="name" type="text" name="name" class="input">
							<span v-show="errors.has('name')">{{ errors.first('name') }}</span>         
						</div>
						<br>
						<div :class="{ 'has-error': errors.has('grade') }">
							<label class="control-label" for="grade">Grade : </label><br>
							<input v-validate="'required'" v-model="grade" type="text" name="grade" class="input">
							<span v-show="errors.has('grade')">{{ errors.first('grade') }}</span>       
						</div>
						<br>
						<br>
						<br>
					</form>
				</section>
				<footer class="modal-card-foot">
					<button class="button is-success" v-on:click="editgrade">Save changes</button>
					<button class="button" v-on:click="deedit">Cancel</button>
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
				activeuploadmodal: '',
				activeeditmodal: '',
				activeviewmodal: '',

				notify : false, 
                msg: '',

				testid : '',
				userid : '',
				username : '',
				name : '',
				grade : '',
				gradefile : '',
			}
		},
		methods:{
			add:function(value){
				this.testid = value
				this.activeaddmodal = 'is-active'
			},
			deadd:function(){
				this.activeaddmodal = ''
				this.username = ''
				this.name = ''
				this.grade = ''
				this.$validator.reset()
				this.errors.clear()
			},
			addgrade() {
				var vm = this
				this.$validator.validateAll().then((result) => {					
					axios({
						method: 'post',
						url: 'http://localhost:8000/api/grades',
						accept: 'json',
						ContentType: 'json',
						data: {
							flag: 0,
							test_id: vm.testid,
							user_name: vm.username,
							grade: vm.grade
						}
					}).then(response => { 
						if (response.status == 201) {
							vm.activeaddmodal = ''
							this.$emit('add-grade');
						} 
						else {
							vm.notify = true
							vm.msg = response.data.message
						}
					})
					.catch( error  => {

					});
				});
			},
			upload:function(id){
				this.testid = id
				this.activeuploadmodal = 'is-active'
			},
			deupload:function(){
				this.activeuploadmodal = ''
				
				this.$validator.reset()
				this.errors.clear()
			},
			onFileChange(e) {

				var fileReader = new FileReader()
				fileReader.readAsDataURL(e.target.files[0])
				var vm = this;				
				
				var fileName = e.target.files[0].name
				var ext = fileName.split('.').pop();

				if(ext == "xlsx"){
					fileReader.onload = (e) => {
						vm.gradefile = e.target.result; 
					}  
				}
				else{
					$("#file").val("")
					alert("Please Upload only xlxs file")
				}

			},
			uploadgrade() {
				var vm = this
				if (vm.gradefile != '') {
					this.$validator.validateAll().then((result) => {					
						axios({
							method: 'post',
							url: 'http://localhost:8000/api/grades',
							accept: 'json',
							ContentType: 'json',
							data: {
								flag: 1,
								test_id: vm.testid,
								file : vm.gradefile
							}
						}).then(response => { 
							if (response.status == 201) {
								vm.activeuploadmodal = ''
								this.$emit('upload-grade');
							} 
							else {
								vm.notify = true
								vm.msg = response.data.message
							}
						})
						.catch( error  => {
							console.log(error)
						});
					});
				}
				else{ 
					vm.notify = true
					vm.msg = "Please upload the file"
				}    
			},
			edit:function(index,items){
				this.testid = items.id
				this.username  = items.username
				this.name = items.firstname+' '+items.lastname
				this.grade  = items.grade
				this.activeeditmodal = 'is-active'
			},
			deedit:function(){
				this.userid = ''
				this.username = ''
				this.name = ''
				this.grade = ''
				this.$validator.reset()
				this.errors.clear()
				this.activeeditmodal = ''
			},
			editgrade() {
				var vm = this
				this.$validator.validateAll().then((result) => {
					axios({
						method: 'put',
						url: 'http://localhost:8000/api/grades/'+ vm.testid,
						accept: 'json',
						ContentType: 'json',
						data: {
							grade: vm.grade
						}
					}).then(response => { 
						vm.activeeditmodal = ''
						this.$emit('edit-grade');
					})
					.catch( error  => {

					});
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