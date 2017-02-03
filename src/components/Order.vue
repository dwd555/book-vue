<template>
	<div class='order_body'>
    <MyHeader  title='填写订单'></MyHeader>
    <div class='address' @click='editAddress'>
        <div class='address_item'>{{address.name}}</div>
        <div class='address_item'>
            {{address.phone}}
        </div>
        <div class='location'>
            {{address.address}}
        </div>
        <div v-if='address.length<1'>
            请选择地址
        </div>
        <i class='arrow'></i>
        <b class='lo_border'></b>
    </div>
    <div class='orderList' v-for='(item,key) in cartlist'>
        <div class='order-title'>
            订单{{key+1}}
        </div>
        <div class='order-content'>
            <div class='order-img'>
                <img :src="'/static/img/'+item.img_sm" alt="">
            </div>
            <div class='order-detail'>
                <p class='product_name'>{{item.name}}</p>
                <p class='product_price'><i>¥{{item.single_price}}</i>&nbsp;x{{item.count}}</p>
            </div>
        </div>
    </div>
    <footer>
        <div>     
            <div class='total_price'>
                总额:
                <i>¥{{total}}</i>
            </div>
            <mt-button type="danger" style='height:46px;float:right'>提交订单</mt-button>
        </div>
    </footer>
	
  </div>
</template>
<script>
	import MyHeader from './Header.vue'
    import qs from 'qs'
	export default{
		components:{
			MyHeader,
		},
		data(){
			return{
                address:[],
                cartlist:[],
                total:0
			}
		},
		methods:{
            init(){
                if(this.getCookie('BOOK_user_uid')!==null){
                    let uid=this.getCookie('BOOK_user_uid');
                    let _this=this;
                    this.$http.post('getOrder.php',qs.stringify({'uid':uid}),{headers: {'Content-Type': 'application/x-www-form-urlencoded',},
                    }).then(function(res){
                        //console.log(res);
                        _this.address=res.data.address[0];
                        _this.cartlist=res.data.cart.reverse();
                        _this.total=res.data.total;
                    }).catch(function(err){
                        console.log(err);
                    })
                }else{
                    this.$router.push('/login');
                }
            },
            editAddress(){
                this.$router.push('/main/personCenter/myAccount/address');
            }
		},
		computed:{
			
		},
        created(){
            this.init();
            console.log(this.address)
        }

	}
</script>

<style scoped>
    .address{
        background: #fff;
        padding: 5px 25px 5px 20px;
        color: #252525;
        font-size: 1rem;
        position: relative;
    }
    .address:after{
        display: block;
        content: '';
        clear: both;
    }
    .address_item{
        float: left;
        margin-left: 16px;
    }
    .address_item+.address_item{
        margin-left: 2.6rem;
    }
    .location{
        margin-left: 16px;
        clear: both;
        padding-right: 16px;
    }
    .arrow{
        position: absolute;
        display: block;
        width:22px;
        height: 22px;
        background: url('../assets/jump_arrow.png') no-repeat;
        top: 50%;
        right: 20px;
        transform: translateY(-50%);
    }
    .lo_border{
        display: block;
        height: 3px;
        position: absolute;
        background: url('../assets/location-border.png') repeat-x;
        bottom: 0;
        width: 100%;
        background-size:80px 4px ;
    }
    .orderList{
        margin-top: 10px;
        background: #fff;
        padding: 5px 25px 5px 20px;
        color: #464646;
        font-size: 14px;
        border: 1px solid #e1e1e1;
    }
    .order-title{
        border-bottom: 1px solid #dcdcdc;
        color: #ff463c;
        font-size: 1rem;
    }
    .order-content{
        padding: 10px 0;
        display: flex;
        position: relative;
    }
    .order-content:after{
        display: block;
        content: '';
        clear: both;
    }
    .order-img{
        width: 60px;
        height: 60px;
        margin-right: .7rem;
    }
    .order-img img{
        width: 100%;
    }
    .order-detail{
        /* float: left; */
        flex: 1;
    }
    .product_name{
        height: 36px;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        line-height: 18px;
}
    .product_price{
        font-size: 14px;
        color: #787878;
        margin-top: 5px;
    }
    .product_price i{
        color: #ff463c;
        font-weight: bold;
    }
    footer{
        height: 46px;
        padding: 5px 0;
        border-top: 1px solid #dcdcdc;
        border-bottom: 1px solid #e6e6e6;
        position: fixed;
        background: #fff;
        bottom: 0;
    }
    footer>div{
        padding-left: 10px;
    }
    .total_price{
        float: left;
        line-height: 46px;
    }
    .total_price i{
        margin: 0 0 0 5px;
        font-size: 18px;
        display: inline-block;
        color: #ff463c;
        font-weight: bold;
    }
</style>