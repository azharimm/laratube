<template>
	<div>
		<div class="video-comment clearfix" v-if="laratube.user.authenticated">
			<textarea placeholder="Say something" class="form-control video-comment__input" v-model="body"></textarea>
			<div class="float-right">
				<button type="submit" class="btn btn-outline-secondary" @click.prevent="createComment">Post</button>
			</div>
		</div>
		<p>{{comments.length}} Comments</p>
		<div class="media" v-for="comment in comments" :key="comment.id">
		  <img class="mr-3" :src="comment.channel.image" :alt="comment.channel.name" width="40px">
		  <div class="media-body">
		    <h5 class="mt-0"><a href="">{{comment.channel.name}}</a> <small>{{comment.created_at_human}}</small></h5>
		    <p>{{comment.body}}</p>
			<ul class="list-inline" v-if="laratube.user.authenticated">
				<li class="list-inline-item">
					<a href="#" @click.prevent="toggleReplyForm(comment.id)">{{replyFormVisible === comment.id ? 'Cancel' : 'Reply'}}</a>
				</li>
				<li class="list-inline-item">
					<a href="#" @click.prevent="deleteComment(comment.id)" v-if="laratube.user.id === comment.user_id">Delete</a>
				</li>
			</ul>

		    <div class="video-comment clear" v-if="replyFormVisible === comment.id">
		    	<textarea class="form-control video-comment__input" v-model="replyBody"></textarea>	
		    	<div class="float-right">
					<button type="submit" class="btn btn-sm btn-outline-secondary" @click.prevent="createReply(comment.id)">Reply</button>
				</div>
		    </div>

		    <div class="media" v-for="reply in comment.replies" :key="reply.id">
			  <img class="mr-3" :src="reply.channel.image" :alt="reply.channel.name" width="40px">
			  <div class="media-body">
			    <h5 class="mt-0"><a href="">{{reply.channel.name}}</a> <small>{{reply.created_at_human}}</small></h5>
			    <p>{{reply.body}}</p>
			    <ul class="list-inline" v-if="laratube.user.authenticated">
					<li class="list-inline-item">
						<a href="#" @click.prevent="deleteComment(reply.id)" v-if="laratube.user.id === reply.user_id">Delete</a>
					</li>
				</ul>
			  </div>
			</div>
		  </div>
		</div>
	</div>
</template>

<script>
	export default{
		data(){
			return{
				comments : [],
				body:null,
				replyBody:null,
				replyFormVisible: null
			}
		},
		props:{
			videoUid: null
		},
		methods:{
			getComments(){
				this.$http.get(`/videos/${this.videoUid}/comments`)
				.then((response)=>{
					this.comments = JSON.parse(response.bodyText).data;				
				});
			},
			createComment(){
				this.$http.post(`/videos/${this.videoUid}/comments`, {body:this.body})
				.then((response) => {
					//add comment to the list
					this.comments.unshift(JSON.parse(response.bodyText).data);
					this.body = null;
				}, (e)=>{
					console.log(e)
				});
			},
			toggleReplyForm(commentId){
				this.replyBody = null;
				if(this.replyFormVisible === commentId){
					this.replyFormVisible = null;
					return;
				}

				this.replyFormVisible = commentId;
			},
			createReply(commentId){
				this.$http.post(`/videos/${this.videoUid}/comments`, {
					body:this.replyBody,
					reply_id: commentId
				})
				.then((response) => {
					//add comment to the list
					this.comments.map((comment, index) => {
						if(comment.id === commentId){
							this.comments[index].replies.unshift(JSON.parse(response.bodyText).data);
						}
					})
					this.replyBody = null;
					this.replyFormVisible = null;
				}, (e)=>{
					console.log(e)
				}); 
			},
			deleteComment(commentId){
				if(!confirm('Are you sure you want to delete?')){
					return;
				}

				this.deleteById(commentId);
				this.$http.delete(`/videos/${this.videoUid}/comments/${commentId}`);
			},
			deleteById(commentId){
				this.comments.map((comment, index) =>{
					if(comment.id === commentId){
						this.comments.splice(index,1);
						return;
					}

					comment.replies.map((reply, replyIndex) =>{
						if(reply.id === commentId){
							this.comments[index].replies.splice(replyIndex, 1);
							return;
						}
					})
				});

			}
		},
		mounted(){
			this.getComments();
		}
	}
</script>