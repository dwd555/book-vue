<template>
	<div class='person-center'>
		<MyHeader title='我的'></MyHeader>
		<div class='user_info' @click='updateDetail'>
			<img src="../assets/images/user_img.png" class='avater'>
			<div class='user_name'>
				<p>{{username}}</p>
			</div>
		</div>
		<group>
      		<cell title="全部订单" is-link>
       	 	<img slot="icon" class='link'  style="display:block;margin-right:5px;" src='../assets/images/my_03.png' >
      		</cell>
      		<cell title="待付款" is-link>
       	 	<img slot="icon" class='link'  style="display:block;margin-right:5px;" src='../assets/images/my_07.png' >
      		</cell>
      		<cell title="待收货" is-link>
       	 	<img slot="icon" class='link'  style="display:block;margin-right:5px;" src='../assets/images/my_10.png' >
      		</cell>
      		<cell title="收货地址" is-link @click.native='gotoAddress'>
       	 	<img slot="icon" class='link'  style="display:block;margin-right:5px;" src='../assets/images/wd-012-05.png' >
      		</cell>
    	</group>
    	<group>
    		<div class='collect'>
    			<div class='collect-content bg1'>
    				<span></span>
    				<p>收藏</p>
    			</div>
    			<div class='collect-content bg2'>
    				<span></span>
    				<p>我的点评</p>
    			</div>
    			<div class='collect-content bg3'>
    				<span></span>
    				<p>客服中心</p>
    			</div>
    		</div>
    	</group>
	</div>
</template>
<script>
	import MyHeader from './Header.vue'
	import { Cell, Group } from 'vux'
	export default {
		components:{
			MyHeader,
			Cell,
			Group
		},
		data(){
			return {
				isLogin:false,
				username:'您还没有登录，请点击登录'
			}
		},
		methods:{
			init(){
				let _this=this;
                if(this.getCookie('BOOK_user_uid')!==null){
                    this.isLogin=true;
                    let phone=this.getCookie('BOOK_user_phone');
                    this.$http.get('person_detail.php?phone='+phone).then(function(res){
                    	if(res.status==200){
                    		if(res.data.nickname!=='NULL'){
                    			_this.username=res.data.nickname;
                    		}else{
                    			_this.username=res.data.phone;
                    		}
                    	}
                    }).catch(function(err){
                    	console.log(err);
                    })
                }else{
                	this.isLogin=false;
                	this.username='您还没有登录，请点击登录'
                }
			},
			updateDetail(){
				if(this.isLogin==false){
					this.$router.push('/login');
				}else{
					this.$router.push('/main/personCenter/myAccount');
				}
			},
			gotoAddress(){
				if(this.isLogin){
					this.$router.push('/main/personCenter/myAccount/address')
				}else{
					this.$router.push('/login')
				}
			}
		},
		created(){
			this.init();
		}

	}
</script>
<style>
	.person-center .weui_cell_bd > p{
		color: #646464;
	}
</style>
<style scoped>
	.person-center{
		background: #F6F6F6;
	}
	.user_info{
		width: 100%;
		height: 9rem;
		background: url('../assets/images/user_bg_01.png') no-repeat;
		background-size:cover;
		position: relative;
	}
	.user_info:after{
		position: absolute;
    	top: 50%;
    	display: block;
    	content: '';
    	width: 1.3em;
    	height: 1.6em;
    	transform: translateY(-50%);
    	background: url('../assets/arrow.png') no-repeat;
    	background-size: 80%;
    	right: 1rem;
	}
	.avater{
		width: 3.75rem;
		position: absolute;
		top: 50%;
		left: 0;
		transform: translateY(-50%);
		margin-left: 1.56rem;
		border-radius: 50%
	}
	.user_name{
		padding-left: 6.5rem;
		position: absolute;
		top: 50%;
		transform: translateY(-50%);
		color: #fff;
		font-size: 1rem;
	}
	.link{
		width: 1.1rem;
	}
	.collect-content{
		box-sizing: border-box;
		width: 33.3%;
		height: 5.625rem;
		border-left:1px solid #d7d6dc ;
		border-bottom:1px solid #d7d6dc ;
		float: left;
	}
	.collect-content span{
		display: block;
		margin: 0 auto;
		width: 2.5rem;
		height: 2.5rem;
		background: url('../assets/images/collect_15.png') no-repeat;
		background-size: 18.75rem;
		margin-top: .5rem;
	}
	.collect-content.bg1 span{
		background-size: 18.75rem;
	}
	.collect-content.bg2 span{
		background-position:-7.6875rem 0;
	}
	.collect-content.bg3 span{
		background-position:-15.375rem 0;
	}
	.collect-content:first-child{
		border-left: 0;

	}
	.collect-content p{
		text-align: center;
		padding-top: .5rem;
		font-size: 1rem;
		color: #646464;
	}
</style>