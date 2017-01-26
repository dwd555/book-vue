<template>
	<div class='person-center'>
		<MyHeader title='个人资料管理'></MyHeader>
		<group>
      		<cell title="昵称" is-link @click.native='updateNickname'>
       	 		  <span slot="value" style="color: #3a3a3a;font-size:14px" >{{username}}</span>
      		</cell>
      		<cell title="修改登录密码" is-link @click.native='developing'>
       	 		  
      		</cell>
      		<cell title="已绑定手机号" is-link @click.native='developing'>
       	 		  <span slot="value" style="color: #3a3a3a;font-size:14px">{{phone}}</span>
      		</cell>
      		<cell title="修改收货地址" is-link link="/main/personCenter/myAccount/address">
      		 <span slot="value" style="color: #3a3a3a"></span>
      		</cell>
    	</group>
    	<group style='padding:0 1rem'>
    	<mt-button type="danger" size='large' class='logoutBtn' @click='logout'>退出登录</mt-button>

    	</group>
	</div>
</template>
<script>
	import MyHeader from './Header.vue'
	import { Cell, Group,XButton } from 'vux'
	import {Toast,MessageBox} from 'mint-ui'
	export default {
		components:{
			MyHeader,
			Cell,
			Group,
			XButton
		},
		data(){
			return {
				isLogin:false,
				username:'点击修改昵称',
				phone:''
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
                    		_this.phone=res.data.phone;
                    		if(res.data.nickname!=='NULL'){
                    			_this.username=res.data.nickname;
                    		}else{
                    			_this.username='点击修改昵称';
                    		}
                    	}
                    }).catch(function(err){
                    	console.log(err);
                    })
                }else{
                	this.isLogin=false;
                	this.$router.push('/main/personCenter');
                }
			},
			updateDetail(){
				if(this.isLogin==false){
					this.$router.push('/login');
				}else{
					console.log('跳到修改资料页')
				}
			},
			logout(){
				MessageBox.confirm('确定退出登录吗?').then(action => {
                  	this.delCookie('BOOK_user_phone')
                  	this.delCookie('BOOK_user_uid');
                  	this.$router.push('/main/personCenter');
                }).catch(function(res){
                    //console.log(res)
                });
			},
			updateNickname(){
				var nickname=this.username;
				var _this=this;
				MessageBox.prompt('请输入昵称').then(({ value, action }) => {
					this.$http.get('update_nickname.php?phone='+this.phone+'&nickname='+value).then(function(res){
						if(res.data.msg=='succ'){
							Toast({
					            message: '修改昵称成功',
					            duration: 1000
					          });
							_this.init();
						}						
					}).catch(function(err){
						console.log(err);
					})
                 
                }).catch(function(res){
                    //console.log(res)
                });
			},
			developing(){
				Toast({
					message: '开发中',
					duration: 1000
				});
			}
		},
		created(){
			this.init();
		}

	}

</script>
<style scoped>

</style>