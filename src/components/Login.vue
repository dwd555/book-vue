<template>
	<div>
		 <MyHeader  title='登录'></MyHeader>
		 <section class="main">		 		
		 		<div class='inp' :class="{'err':err}">
		 			<span class='icon'></span>
		 			<div class='input'>
						<mt-field style='background:transparent;' :attr="{autocomplete:'off'}" placeholder="请输入手机号" v-model='userName'></mt-field>
		 			</div>
		 		</div>
		 		<div class='inp' :class="{'err':err}">
		 			<span class='icon pwd'></span>
		 			<div class='input'>
						<mt-field style='background:transparent;' :attr="{autocomplete:'off'}" placeholder="请输入密码" type='password' v-model='userPwd'></mt-field>
		 			</div>
		 		</div>
		 		<mt-button class='loginBtn' :disabled='disabled' type="danger" size="large" @click='login'>登录</mt-button>
		 		<dl class="func">
				<dt><a >找回密码</a></dt>
				<dd>
					<router-link to='/login/register'>注册</router-link>
				</dd>
			</dl>
		 </section>
		 <section class="page_lr another">
	<span class="title">
		<em>第三方账号登录</em>
	</span>
	<ul>
		<li class="qq">
			<a href="https://mpassport.dangdang.com/login_third.php?app=qq&amp;burl=http%3A%2F%2Fhome.m.dangdang.com%2F%3F%26login_app%3Dweb&amp;sid=fd4d2eb467c82428017543932703bf06">
				<em>腾讯QQ</em>
				<i>腾讯QQ</i>
			</a>
		</li>
        		<li class="alipay">
			<a href="https://mpassport.dangdang.com/login_third.php?app=alipay&amp;burl=http%3A%2F%2Fhome.m.dangdang.com%2F%3F%26login_app%3Dweb&amp;sid=fd4d2eb467c82428017543932703bf06">
				<em>支付宝</em>
				<i>支付宝</i>
			</a>
		</li>
        		<li class="sina">
			<a href="https://mpassport.dangdang.com/login_third.php?app=sina&amp;burl=http%3A%2F%2Fhome.m.dangdang.com%2F%3F%26login_app%3Dweb&amp;sid=fd4d2eb467c82428017543932703bf06">
				<em>新浪微博</em>
				<i>新浪微博</i>
			</a>
		</li>
	</ul>
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
				err:false,
				isLogin:false,
			}
		},
		components:{
			MyHeader,
		},
		methods:{
			btnOn(){
				if(this.userName!==''&&this.userPwd!==''){
					this.disabled=false;
					this.err=false;
				}else{
					this.disabled=true;
				}
			},
			login(){
				//console.log(1);
				let postPwd=this.userPwd;
				this.userPwd='';
				let _this=this;
				this.$http.post('login.php',qs.stringify({phone:this.userName,upwd:postPwd}),{headers: {'Content-Type': 'application/x-www-form-urlencoded',},
				}).then(function(res){
					//console.log(res);
					if(res.data.msg=='succ'){
						Toast({
						  message: '登录成功',
						});
						_this.SetCookie('BOOK_user_phone',_this.userName);
						_this.SetCookie('BOOK_user_uid',res.data.uid);
						_this.isLogin=true;
						_this.$router.back();
					}else{
						Toast({
						  message: '手机号或密码错误',
						});
						_this.err=true;
					}
				}).catch(function(err){
					console.log(err);
					Toast({
						  message: '当前网络不给力请稍后重试',
						});
				})
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

/* 第三方帐号登录 */
.another{margin-top:3rem;}
.another .title{display:block;overflow:hidden;position:relative;text-align:center;font-size:0;}
.another .title::before,.another .title::after{position:absolute;top:.3rem;font-size:0;content:"";width:50%;height:1px;line-height:0;}
.another .title::before{left:0;background:-moz-linear-gradient(left,transparent 0%,#eee 100%) 0% 100%;background:-webkit-gradient(linear, left top, right top, color-stop(0%,transparent),color-stop(100%,#eee));background:-webkit-linear-gradient(left,transparent 0%,#eee 100%) 0% 100%;background:-o-linear-gradient(left,transparent 0%,#eee 100%) 0% 100%;background:linear-gradient(left,transparent 0%,#eee 100%) 0 100%;}
.another .title::after{right:0;background:-moz-linear-gradient(left,#eee 0%,transparent 100%) 0% 100%;background:-webkit-gradient(linear, left top, right top, color-stop(0%,#eee),color-stop(100%,transparent));background:-webkit-linear-gradient(left,#eee 0%,transparent 100%) 0% 100%;background:-o-linear-gradient(left,#eee 0%,transparent 100%) 0% 100%;background:linear-gradient(left,#eee 0%,transparent 100%) 0 100%;}
.another .title em{font-size:.6rem;display:inline-block;line-height:.75rem;color:#969696;position:relative;z-index:2;background-color:white;padding:0 .5rem;}
.another ul{clear:both;overflow:hidden;}
.another ul li{float:left;width:33.3333%;}
.another ul li a{display:block;padding-top:1.5rem;color:#646464;}
.another ul li a em{display:block;text-indent:-999rem;height:2.075rem;background-repeat:no-repeat;background-position:center center;background-size:contain;}
.another ul li.qq a em{background-image:url(../assets/qq_icon.png);}
.another ul li.alipay a em{background-image:url(../assets/alipay_icon.png);}
.another ul li.sina a em{background-image:url(../assets/sina_icon.png);}
.another ul li a i{display:block;padding-top:.25rem;text-align:center;font-size:.55rem;}

</style>