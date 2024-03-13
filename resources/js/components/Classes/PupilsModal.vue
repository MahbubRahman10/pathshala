<template>
	<div>

		<div class="modal" v-bind:class="activeaddmodal">
			<div class="modal-background"></div>
			<div class="modal-card">
				<header class="modal-card-head">
					<p class="modal-card-title">Add New Pupils</p>
					<button class="delete" aria-label="close" v-on:click="deadd"></button>
				</header>
				<section class="modal-card-body">
					<!-- Content ... -->
					<form @submit.prevent="">
						<div :class="{ 'has-error': errors.has('pupils') }" id="role">
							<label class="control-label" for="pupils">Pupils </label><br>
							<div class="select is-fullwidth">
								<select @change="selectpupils" v-model="pupils" >
									<option v-for="(student,index) in students" :value="student.id"> {{ student.Username }} - {{ student.FirstName }} {{ student.LastName }} </option>
								</select>
							<span v-show="errors.has('pupils')">{{ errors.first('pupils') }}</span> 
							</div>
						</div>
						<br>
						<br>
					</form>
				</section>
				<footer class="modal-card-foot">					
					<button type="submit" class="button is-success" v-on:click="addpupils">Submit</button>
					<button class="button" v-on:click="deadd">Cancel</button>
				</footer>
			</div>
		</div>


		<div class="modal"  v-bind:class="activedeletemodal">
			<div class="modal-background"></div>
			<div class="modal-card">
				<header class="modal-card-head">
					<p class="modal-card-title">Remove Pupils</p>
					<button class="delete" aria-label="close" v-on:click="dedelete"></button>
				</header>
				<section class="modal-card-body">
					<!-- Content ... -->
					<p>Are you want to remove this pupil ?</p>
				</section>
				<footer class="modal-card-foot">
					<button type="submit" class="button is-danger" v-on:click="deletepupils">Delete</button>
					<button class="button" v-on:click="dedelete">Cancel</button>
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

				pupils: '',
				students : '',
				pupilsid: '',
				error: ''
			}
		},
		methods:{
			selectpupils:function() {
				this.pupilsid = this.pupils
			},
			add:function(){
				this.activeaddmodal = 'is-active'
				var vm = this
				vm.cls = this.$cookie.get('classname')
				axios({
					method: 'get',
					url: 'http://localhost:8000/api/classes/' + vm.cls,
					accept: 'json',
					ContentType: 'json',
					Authorization: 'Bearer' + this.$cookie.get('token')
				}).then(response => {  
					if(response.data != null){
						this.students = response.data.data
					}
					else{
						this.nodata = true
					}
				})
				.catch( error  => {

				});
			},
			deadd:function(){
				this.activeaddmodal = ''
				this.username = ''
				this.firstname = ''
				this.lastname = ''
				this.userrole = ''
				this.password = ''
				this.$validator.reset()
				this.errors.clear()
			},
			
			addpupils() {
				var vm = this
				this.$validator.validateAll().then((result) => {
					if (result) {
						axios({
							method: 'post',
							url: 'http://localhost:8000/api/pupils',
							accept: 'json',
							ContentType: 'json',
							data: {
								user_id: vm.pupilsid,
								classname: this.$cookie.get('classname')
							}
						}).then(response => { 
							vm.activeaddmodal = ''
							this.$emit('add-pupils');
						})
						.catch( error  => {
							vm.errors.add({
								field: 'classname',
								msg: 'classname is already in use'
							})
						});
					}
				});
			},
			
			delete:function(id){
				this.activedeletemodal = 'is-active'
				this.pupilsid = id
			},
			dedelete:function(){
				this.activedeletemodal = ''
			},
			deletepupils() {
				var vm = this
				axios({
					method: 'delete',
					url: 'http://localhost:8000/api/pupils/'+ this.pupilsid,
					accept: 'json',
					ContentType: 'json',
				}).then(response => { 
					vm.activedeletemodal = ''
					this.$emit('remove-pupils');
				})
				.catch( error  => {

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