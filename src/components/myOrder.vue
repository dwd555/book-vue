<template>
	 <div>
        <MyHeader title="我的订单"></MyHeader>
        <div class="order_list">
            <div class="order_title">
                当当自营
            </div>
            <div class="order_item">
                
            </div>
        </div> 
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
                    //_this.$http.get("")
                }
            },
			
		},
		created(){
			
		}
	}
</script>

<style scoped>
    .order_list{
        background:#fff;
        margin-top:.5rem;
    }
    .order_title{
        padding:.8rem .3rem;
        padding-left:2.5rem;
        background:url('../assets/shop_icon.png') no-repeat 1rem center;
        background-size:1rem;
        
    }
    .order_item{
        border:1px solid #ddd;
        border-left:0;
        border-right: 0;
    }
</style>