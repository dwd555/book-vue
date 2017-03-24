<template>
	 <div>
        <MyHeader title="我的订单"></MyHeader>   
     </div>
</template>
<script>
	import MyHeader from './Header.vue'
	import { Group, XNumber } from 'vux'
	import {Toast,MessageBox} from 'mint-ui';
    import qs from 'qs'
	export default{
		components:{
			MyHeader,
			Group,
		},
		data(){
			return{
                orderList:[],
			}
		},
		methods:{
			goLogin(){
				this.$router.push({path:'/Login'});
			},
            init(){
                let _this=this;
                if(this.getCookie('BOOK_user_uid')!==null){
                    this.goLogin()
                }else{

                }
            },
			
		},
		created(){
			
		}
	}
</script>

<style scoped>

</style>