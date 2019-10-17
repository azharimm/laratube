<template>
	<div class="video__voting">
		<a href="#" class="video__voting-button" :class="{'video__voting-button--voted' : userVote == 'up'}" @click.prevent="vote('up')">
			<span class="fa fa-thumbs-up"></span>
		</a> {{up}} &nbsp;

		<a href="#" class="video__voting-button" :class="{'video__voting-button--voted' : userVote == 'down'}" @click.prevent="vote('down')">
			<span class="fa fa-thumbs-down"></span>
		</a> {{down}} &nbsp;
	</div>
</template>

<script>
export default{
	data(){
		return{
			up:null,
			down:null,
			userVote:null,
			canVote:null
		}
	},
	props:{
		videoUid : null
	},
	mounted(){
		this.getVotes();
	},
	methods:{
		getVotes(){
			this.$http.get('/videos/'+this.videoUid+'/vote').then((response)=>{
				const data = JSON.parse(response.bodyText);
				this.up = data.data.up;
				this.down = data.data.down;
				this.userVote = data.data.user_vote;
				this.canVote = data.data.can_vote;
			});
		},
		vote(type){
			if(this.userVote == type){
				this[type]--;
				this.userVote == null;
				this.deleteVote(type);
				return;
			}
			if(this.userVote){
				this[type == 'up' ? 'down' : 'up']--;
			}
			this[type]++;
			this.userVote = type;
			this.createVote(type);
		},
		deleteVote(type){
			this.$http.delete(`/videos/${this.videoUid}/vote`, {
				_token: this.csrfToken
			});
		},
		createVote(type){
			this.$http.post(`/videos/${this.videoUid}/vote`, {
				type:type,
				_token: this.csrfToken
			});
		}
	}
}
</script>