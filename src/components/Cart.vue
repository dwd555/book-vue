<template>
	  <div class='cart_body'>
    <MyHeader  title='购物车'></MyHeader>
    <section class="content">

      <div class="list_null" v-if='isNull'>
        <p class="desc" v-if='isLogin' v-show='isNull'>您还没有购买任何商品</p>
        <p class="desc" v-if='!isLogin'>您当前尚未登录!</p>
        <div class='car_login'>
          <mt-button size="normal" type='danger' @click='goLogin' v-if='!isLogin'>点击登录</mt-button>
        </div>
      </div>
      <div class='list' v-for='(item,index) in cartlist'>
        <input type="checkbox" class="fl c_checkbox" @click='updateSelected(index)'  v-model='item.selected'>
        <router-link :to="{path:'/main/home/detail/'+item.bid}">
          <img class='fl' :src="'/static/img/'+item.img_sm" alt="">
        </router-link>
        <div class="detail">
          <p class="fr prd_price">￥{{item.single_price}}</p>
          <p class="fl prd_tit">
          <a>{{item.name}}</a>
          </p>
          <p class="clear tags">
            <a class="garbage"  @click='remove(index)'></a>
          </p>
        </div>
        <div style='font-size:1rem;'>
          <!-- <div class="weui_cells vux-no-group-title">
            <div class="weui_cell">
              <div class="weui_cell_bd weui_cell_primary">
                <p>数量</p>
              </div>
              <div class="weui_cell_ft" style="font-size: 0px;">
                <a class="vux-number-selector vux-number-selector-sub" @click='decrease(index)'>-</a>
                <input  type="num" class="vux-number-input" style="width: 50px;" v-model='item.count' @blur='checkNum(index)'>
                <a class="vux-number-selector vux-number-selector-plus">+</a>
              </div>
            </div>
          </div> -->
          <MyInput :min='1' :max='200' v-model='item.count' @on-change='updateCount(index)'></MyInput>
        </div>
      </div>
      
    </section>
	<div class='gray_text'>
		<span class='gray_layout'>你可能还想要</span>
	</div>
    <section class="hot cart_hot">
      <h4>推广商品<i>广告</i></h4>
      <ul>
        <li v-for='item in advertisement'>
          <router-link :to="{path:'/main/home/detail/'+item.bid}">
            <img :src="'/static/img/'+item.img_sm">
            <span>{{item.name}} {{item.introduction}}</span>
            <em>¥{{item.newprice}}</em>
          </router-link>
        </li>
      </ul>
    </section>
    <footer class="total_result" v-if='!isNull'>
        <div class="fl ">
            <input type="checkbox" class="c_checkbox" @click='updateAllSelected' v-model='allSelected' >
            <span >全选</span>
        </div>
       
        <div class="fr"> 
           <mt-button size="normal" type='danger' @click='order'>去结算({{itemCount}})</mt-button>
        </div>
        <div class="fr totalPrice">
                    <span>合计:</span>
          <span style="color:#ff463c;">{{sum}}</span>
        </div>
        </footer>
  </div>
</template>
<script>
	import MyHeader from './Header.vue'
	import { Group, XNumber } from 'vux'
	import {Toast,MessageBox} from 'mint-ui';
    import MyInput from './CountNum.vue'
    import qs from 'qs'
	export default{
		components:{
			MyHeader,
			Group,
			XNumber,
            MyInput
		},
		data(){
			return{
				isNull:true,
				isLogin:false,
				advertisement: [],
				cartlist:[],
			}
		},
		methods:{
			goLogin(){
				this.$router.push({path:'/Login'});
			},
            init(){
                let _this=this;
                if(this.getCookie('BOOK_user_uid')!==null){
                    this.isLogin=true;
                    let phone=this.getCookie('BOOK_user_phone');
                    this.$http.get('cartlist.php?phone='+phone).then(function(res){
                        //console.log(res);
                        if(res.data.msg=='succ'){
                            _this.isNull=false;
                            _this.cartlist = res.data.data.map((val, index) => ({
                              kid:val.kid,
                              bid:val.bid,
                              selected: val.selected==5?true:false,
                              count:Number(val.count),
                              single_price:val.single_price,
                              name:val.name,
                              img_sm:val.img_sm
                            }));
                            _this.cartlist.reverse();
                            //console.log(list)
                        }else if(res.data.msg=='null'){
                            _this.cartlist=[];
                            _this.isNull=true;
                        }
                    }).catch(function(err){
                        console.log(err);
                    })
                }
            },
			fetchData(){
				let _this=this;
				this.$http.get('advertisement2.php').then(function (res) {
		          _this.advertisement = res.data;
		        }).catch(function (err) {
		          console.log(err);
		        });
			},
			updateSelected(index){
				//console.log(index);
                let kid=this.cartlist[index].kid;
                let selected=this.cartlist[index].selected==true?5:6;
                this.$http.get('updateSelected.php?kid='+kid+'&selected='+selected).then(function(res){
                    //console.log(res);
                }).catch(function(err){
                    console.log(err);
                })
			},
            updateCount(index){
                //console.log(this.cartlist[index].count);
                let kid=this.cartlist[index].kid;
                let count=this.cartlist[index].count;
                this.$http.post('updateCount.php',qs.stringify({'kid':kid,'count':count}),{headers: {'Content-Type': 'application/x-www-form-urlencoded',},
                }).then(function(res){
                    if(res.data.msg=='err'){
                        Toast({
                          message: '修改数量失败,请稍后重试',
                          duration:2000
                        });
                        //应该把数量设为前一次数量，不过懒得写
                    }
                }).catch(function(err){
                    console.log(err);
                })
            },
            updateAllSelected(){
                let uid=this.getCookie('BOOK_user_uid');
                if(this.allSelected==true){
                    this.updateSql(uid,5);
                }else{
                    this.updateSql(uid,6);
                }
            },
            updateSql(uid,selected){
                this.$http.get('updateAllSelected.php?uid='+uid+'&selected='+selected).then(function(res){
                    //console.log(res);
                }).catch(function(err){
                    console.log(err);
                })
            },
            remove(index){
                let kid=this.cartlist[index].kid;
                let _this=this;
                MessageBox.confirm('确定删除该商品吗?').then(action => {
                  this.$http.get('removeItem.php?kid='+kid).then(function(res){
                        if(res.data.msg=='succ'){
                            _this.init();
                        }
                    }).catch(function(err){
                        console.log(err);
                    })
                }).catch(function(res){
                    //console.log(res)
                });
            },
            order(){
                this.$router.push('/main/home/order');
            }
		},
		computed:{
			allSelected: {
	        	get: function() {
	          	for (var i = 0, length = this.cartlist.length; i < length; i++) {
	              if (this.cartlist[i].selected == false) {
	                return false;
	              }
	            }
		            return true;
		        },
		        set: function(val) {
		          	for (var i = 0, length = this.cartlist.length; i < length; i++) {
		              this.cartlist[i].selected = val;
		            }
		          }
		        },
            itemCount(){
                for (var i = 0, sum=0, length = this.cartlist.length; i < length; i++) {
                        var item = this.cartlist[i];
                        if (item.selected == true) {
                            sum+=Number(item.count);
                        }
                    }
                    return sum;
            },
		    sum: function() {
		        var totalAmount = 0;
		          	for (var i = 0, length = this.cartlist.length; i < length; i++) {
		            	var item = this.cartlist[i];
			            if (item.selected == true) {
			            	totalAmount += item.single_price * item.count;
			            }
		          	}
		          return totalAmount.toFixed(2);
		        }
		},
		watch:{
			
		},
		created(){
			this.init();
		    this.fetchData();
		}
	}
</script>

<style scoped>
/*Car.vue*/
.cart_body{
	background: #f0f2f5;
}
	/*空数据列表*/
	.content{
		width: 100%;
	    min-height: 100%;
	    overflow: auto;
	    background-color: #f2f2f2;
	}
.list_null{ 
	width:100%;
     padding:16.8rem 0 1.88rem 0;
            background:url('../assets/cart_null.gif') center 3.5rem no-repeat;
            background-size:14.1rem 11.7rem;
            border-bottom: solid 1px #EBEBEB;


}
.list_null p{ line-height: 4rem;color:#777;font-size: 1.2rem;
              text-align:center}
.list_null div{margin:0 auto;}
.list_null div a{ float: left; width:40%; height:3.25rem; line-height:3.25rem;border:.1rem solid #777;border-radius:6px;color:#777;font-size: 1.3rem;text-align:center; margin:0 .85rem;}
.car_login{
	text-align: center;
}



/*新加*/

input, select, textarea {
    -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
    -webkit-appearance: none;
    border: 0;
    border-radius: 0;
}
.list{
	/* margin-top: 50px; */
	background: #fff;
	/* min-height: 400px; */
}
.c_checkbox {
    width: 2rem;
    height: 2rem;
    background-image: url('../assets/c_checkbox_off.png');
    background-position: center center;
    background-repeat: no-repeat;
    background-size: 1.5rem;
    background-color: transparent;
    border-radius: 1rem;
    display: block;
    margin: .575rem 1rem 0 0;
}

.list .c_checkbox {
    margin: 2rem 0rem 0 0.5rem;
    padding: 1rem;
    background-position: center;
    background-color: transparent;
}
.c_checkbox:checked {
    background-image: url('../assets/c_checkbox_on.png');
}
.list img{
	width: 4.5rem;
    height: 4.5rem;
    margin: 1rem 1rem 1rem 0;
    text-align: right;
}
.fl{
	float: left;
}
.fr{
	float: right;
}
.detail {
    font-size: .9rem;
    padding: .5rem 0;
    overflow: hidden;
}
.prd_tit {
    width: 50%;
}
.prd_tit a {
    width: 100%;
    height: 3rem;
    overflow: hidden;
    line-height: 1.6rem;
    display: block;
    color: #464646;
    word-wrap: break-word;
}
.prd_price {
    color: #f23030;
    overflow: auto;
    margin-right: 1rem;
    clear: both;
}
.tags {
    width: 100%;
    height: 1rem;
    clear: both;
}
.tags a.garbage {
    margin: 0;
    width: 4rem;
}
.tags a {
    float: right;
    color: #ff463c;
    font-size: 1.1rem;
    margin: 0 1.5rem 0 0;
}
.garbage, .c_del {
    width: 1.4rem;
    height: 1.5rem;
    background-image: url('../assets/c_del.png');
    background-position: center;
    background-repeat: no-repeat;
    background-size: 1.4rem;
    display: block;
    margin: 1rem 1rem 0 1.5rem;
    text-indent: -10000px;
}
.vux-number-input{
	border: 1px solid #ececec;
}
.weui_cells{
	font-size: .9rem;
}
.weui_cells:before{
	border-top: 0;
}
.cart_hot{
	/* margin-top: 60px; */
	padding-bottom: 120px;
}
.list{
	margin-top: 1rem;
}
/*footer*/
footer{
	/* padding-bottom: 50px; */
}
.total_result {
    background-color: #fff;
    background-size:100%;
    position: fixed;
    width: 100%;
    bottom: 0px;
    box-shadow: rgb(207, 207, 207) 0px -1px 5px;
}
.total_result .fl {
    /* padding:1.4rem 0 1.1rem 1.4rem; */
    vertical-align:middle;
}
.total_result .c_checkbox {
    float:left;
    /* background-image: url(../images/c_checkbox_off_red.png);  */
	width: 25px;
	height: 25px;
	margin-left: 10px;
	background-size: 25px,25px;
	margin: 12.5px;
}
.total_result .c_checkbox:checked {
    background-image:url('../assets/c_checkbox_on.png');
}

.total_result .fl span {
    line-height:50px;
    font-size:16px;
}
.total_result .fr span {
    font-size:15px;
}
.total_result .fr p {
    font-size:15px;
    color:#ff463c;
    overflow:hidden;
}
.total_result .fr {
    /* padding:0.85rem 1.5rem .75rem 0; */
    padding: 2px 8px;
    margin-left: 1rem;
    position: relative;
}

.totalPrice.fr{
	padding: 0;
	height: 50px;
	line-height: 50px;
}

.gray_text {
    position: relative;
    display: -webkit-box;
    margin: 14px 5px;
    color: #848689;
    font-size: 14px;
    -webkit-box-pack: center;
}
.gray_text:after {
    content: "";
    height: 1px;
    width: 100%;
    position: absolute;
    top: 50%;
    left: 0;
    background-color: #cbcbcb;
    -webkit-transform: scaleY(0.5);
}
.gray_layout {
    padding: 0 10px;
    background-color: #f0f2f5;
    position: relative;
    display: block;
    z-index: 1;
}

</style>