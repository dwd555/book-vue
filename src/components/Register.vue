<template>
	<div>
		 <MyHeader title='注册'></MyHeader>
		 <section class="main">		 		
		 		<div class='inp' :class="{'err':errPhone}">
		 			<span class='icon'></span>
		 			<div class='input'>
						<mt-field style='background:transparent;' :attr="{autocomplete:'off'}" placeholder="请输入手机号" v-model='userName'></mt-field>
		 			</div>
		 		</div>
		 		<div class='inp' :class="{'err':errPwd}">
		 			<span class='icon pwd'></span>
		 			<div class='input'>
						<mt-field style='background:transparent;' :attr="{autocomplete:'off'}" placeholder="请输入6~20位密码" type='password' v-model='userPwd'></mt-field>
		 			</div>
		 		</div>
		 		<div class='inp'>
						
					
		 			<div class='input code'>
						<mt-field style='background:transparent;' :attr="{autocomplete:'off'}" placeholder="请输入验证码" type='password' v-model='verify'></mt-field>
		 			</div>
		 			<div class='identify' >
		 				<img :src="imgsrc" class='repic'>
		 				<a href="#" class='refresh' @click='refresh'></a>
		 			</div>
		 		</div>


		 		<mt-button class='loginBtn' :disabled='disabled' type="danger" size="large" @click='register'>注册</mt-button>
	
</section>
	</div>
</template>
<script>
	import MyHeader from './Header.vue'
	import qs from 'qs'
	import {Toast} from 'mint-ui';
	export default{
		data(){
			return {
				disabled:true,
				userName:'',
				userPwd:'',
				errPhone:false,
				errPwd:false,
				isLogin:false,
				imgsrc:'../../static/data/autocode.php',
				verify:''
			}
		},
		components:{
			MyHeader,
		},
		computed:{
			validPhone(){
				var r=/^1[34578]\d{9}$/;
				if(r.test(this.userName)){
					return true;
				}else{
					return false;
				}
			},
			validPwd(){
				var r=/^\w{6,20}$/;
				if(r.test(this.userPwd)){
					return true;
				}else{
					return false;
				}
			},
			validCode(){
				var r=/^\w{4}$/;
				if(r.test(this.verify)){
					return true;
				}else{
					return false;
				}
			}
		},
		methods:{
			btnOn(){
				if(this.userName!==''&&this.userPwd!==''&&this.verify!==''){
					this.disabled=false;
					//this.err=false;
				}else{
					this.disabled=true;
				}
			},
			register(){
				//console.log(1);
				// let postPwd=this.userPwd;
				// this.userPwd='';
				// let _this=this;
				// this.$http.post('login.php',qs.stringify({phone:this.userName,upwd:postPwd}),{headers: {'Content-Type': 'application/x-www-form-urlencoded',},
				// }).then(function(res){
				// 	//console.log(res);
				// 	if(res.data.msg=='succ'){
				// 		Toast({
				// 		  message: '登录成功',
				// 		});
				// 		_this.SetCookie('BOOK_user_phone',_this.userName);
				// 		_this.SetCookie('BOOK_user_uid',res.data.uid);
				// 		_this.isLogin=true;
				// 		_this.$router.back();
				// 	}else{
				// 		Toast({
				// 		  message: '手机号或密码错误',
				// 		});
				// 		_this.err=true;
				// 	}
				// }).catch(function(err){
				// 	console.log(err);
				// 	Toast({
				// 		  message: '当前网络不给力请稍后重试',
				// 		});
				// })
				//console.log(this.validPhone,this.validPwd)
				let _this=this;
				if(!this.validPhone){
					Toast({
						  message: '请输入正确的手机号',
						});
					this.errPhone=true;
				}else if(!this.validPwd){
					Toast({
						  message: '请输入6~20位密码',
						});
					this.errPwd=true;
				}else if(!this.validCode){
					Toast({
						  message: '请输入4位验证码',
						});
					this.verify=''
					this.refresh();
				}else{
					this.$http.get('verifycode.php?authcode='+this.verify).then(function(res){
						if(res.data.msg=='succ'){
								let phone=_this.userName;
								let pwd=_this.userPwd;
							 _this.$http.post('register.php',qs.stringify({'phone':phone,'pwd':pwd}),{headers: {'Content-Type': 'application/x-www-form-urlencoded',},
							 }).then(function(res){
							 	console.log(res);
							 	if(res.data.msg=='err'){
							 		Toast({
									  message: '手机已注册',
									});
									_this.errPhone=true;
									_this.refresh();
									_this.verify='';
							 	}else{
							 		Toast({
									  message: '注册成功',
									});
									_this.SetCookie('BOOK_user_phone',res.data.phone);
									_this.SetCookie('BOOK_user_uid',res.data.uid);
									_this.$router.push('/main/home');
							 	}
							 }).catch(function(err){
							 	console.log(err);
							 })
						}else{
							Toast({
							  message: '验证码输入错误',
							});
							_this.refresh();
							_this.verify='';
						}
					}).catch(function(err){
						console.log(err)
					})
				}
			},
			refresh(){
				let ranNum=Math.random();
				this.imgsrc='../../static/data/autocode.php?'+ranNum;
			},
			init(){
				if(this.getCookie('BOOK_user_uid')!==null){
                    this.isLogin=true;
                    this.$router.push('/main/home')
                }
                
			}
		},
		created(){
			this.init();
		},
		watch:{
			userName(){
				this.btnOn();
			},
			userPwd(){
				this.btnOn();
			},
			verify(){
				this.btnOn();
			}
		}
	}
</script>
<style scoped>
/*login.vue*/
.child-view{
	background: #fff;
}
.main{
	padding-top: 1.5rem;
	margin: auto 1.2rem;
	/* margin-top: 40px; */
}
.inp{
	height: 2.5rem;
	background-color: #fafafa;
    border: 1px solid #fafafa;
    position:relative;
}
.inp.err{
	border-color: #e4393c;
}
.inp .icon{
	height: 100%;
	width: 2rem;
	position: absolute;
	left: 0;
	top: 0;
	background: url('../assets/user_icon.png') 0.5rem  center no-repeat ;
	background-size: 1.5rem auto;
}
.icon.pwd{
	background: url('../assets/pw_icon.png') 0.5rem  center no-repeat ;
	background-size: 1.5rem auto;
}
.input{
	float: left;
	margin-left: 2rem;
	width: 90%;
	height: 100%;
}
.inp+.inp{
	margin-top: 1.5rem;
}
.loginBtn{
	margin-top: 1.5rem;
}
.main .func{margin-top:1rem;overflow:hidden;}
.main .func dt,.main .func dd{display:block;font-size:.9rem;}
.main .func dt{float:left;border-bottom:1px solid #a3a3a3;}
.main .func dd{float:right;}
.main .func dd a{display:block;padding-right:.875rem;background:url('../assets/arrow_r_icon.png') right center no-repeat;background-size:.7rem auto;}


.identify{
	height:2.5rem;
	width:7rem;
	background:#fff;
	position:absolute;
	top:0;
	right:0;
}
.repic{
	height: 100%;
	width: 5rem;
}
.refresh{
	height: 100%;
	width: 2rem;
	float: right;
	background: url('../assets/refresh_icon.png') no-repeat;
	background-size: 70%;
	background-position: .3rem;
}
.input.code{
	margin-left: 0;
}
</style>